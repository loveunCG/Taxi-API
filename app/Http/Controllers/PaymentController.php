<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SendPushNotification;

use Stripe\Charge;
use Stripe\Stripe;
use Stripe\StripeInvalidRequestError;

use Auth;
use Setting;
use Exception;

use App\Card;
use App\User;
use App\WalletPassbook;
use App\UserRequests;
use App\UserRequestPayment;

class PaymentController extends Controller
{
       /**
     * payment for user.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
        $this->validate($request, [
                'request_id' => 'required|exists:user_request_payments,request_id|exists:user_requests,id,paid,0,user_id,'.Auth::user()->id
            ]);


        $UserRequest = UserRequests::find($request->request_id);

        if($UserRequest->payment_mode == 'CARD') {

            $RequestPayment = UserRequestPayment::where('request_id',$request->request_id)->first(); 

            $StripeCharge = $RequestPayment->total * 100;

            try {

                $Card = Card::where('user_id',Auth::user()->id)->where('is_default',1)->first();

                Stripe::setApiKey(Setting::get('stripe_secret_key'));

                $Charge = Charge::create(array(
                      "amount" => $StripeCharge,
                      "currency" => "usd",
                      "customer" => Auth::user()->stripe_cust_id,
                      "card" => $Card->card_id,
                      "description" => "Payment Charge for ".Auth::user()->email,
                      "receipt_email" => Auth::user()->email
                    ));

                $RequestPayment->payment_id = $Charge["id"];
                $RequestPayment->payment_mode = 'CARD';
                $RequestPayment->save();

                $UserRequest->paid = 1;
                $UserRequest->status = 'COMPLETED';
                $UserRequest->save();

                if($request->ajax()) {
                   return response()->json(['message' => trans('api.paid')]); 
                } else {
                    return redirect('dashboard')->with('flash_success','Paid');
                }

            } catch(StripeInvalidRequestError $e){
                if($request->ajax()){
                    return response()->json(['error' => $e->getMessage()], 500);
                } else {
                    return back()->with('flash_error', $e->getMessage());
                }
            } catch(Exception $e) {
                if($request->ajax()){
                    return response()->json(['error' => $e->getMessage()], 500);
                } else {
                    return back()->with('flash_error', $e->getMessage());
                }
            }
        }
    }


    /**
     * add wallet money for user.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_money(Request $request){

        $this->validate($request, [
                'amount' => 'required|integer',
                'card_id' => 'required|exists:cards,card_id,user_id,'.Auth::user()->id
            ]);

        try{
            
            $StripeWalletCharge = $request->amount * 100;

            Stripe::setApiKey(Setting::get('stripe_secret_key'));

            $Charge = Charge::create(array(
                  "amount" => $StripeWalletCharge,
                  "currency" => "usd",
                  "customer" => Auth::user()->stripe_cust_id,
                  "card" => $request->card_id,
                  "description" => "Adding Money for ".Auth::user()->email,
                  "receipt_email" => Auth::user()->email
                ));

            $update_user = User::find(Auth::user()->id);
            $update_user->wallet_balance += $request->amount;
            $update_user->save();

            WalletPassbook::create([
              'user_id' => Auth::user()->id,
              'amount' => $request->amount,
              'status' => 'CREDITED',
              'via' => 'CARD',
            ]);

            Card::where('user_id',Auth::user()->id)->update(['is_default' => 0]);
            Card::where('card_id',$request->card_id)->update(['is_default' => 1]);

            //sending push on adding wallet money
            (new SendPushNotification)->WalletMoney(Auth::user()->id,currency($request->amount));

            if($request->ajax()){
                return response()->json(['message' => currency($request->amount).trans('api.added_to_your_wallet'), 'user' => $update_user]); 
            } else {
                return redirect('wallet')->with('flash_success',currency($request->amount).' added to your wallet');
            }

        } catch(StripeInvalidRequestError $e) {
            if($request->ajax()){
                 return response()->json(['error' => $e->getMessage()], 500);
            }else{
                return back()->with('flash_error',$e->getMessage());
            }
        } catch(Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => $e->getMessage()], 500);
            } else {
                return back()->with('flash_error', $e->getMessage());
            }
        }
    }
}
