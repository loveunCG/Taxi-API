<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\Helper;

use Auth;
use Setting;
use Exception;
use \Carbon\Carbon;

use App\User;
use App\Fleet;
use App\Account;
use App\Provider;
use App\UserPayment;
use App\ServiceType;
use App\UserRequests;
use App\ProviderService;
use App\UserRequestRating;
use App\UserRequestPayment;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('account');
        $this->middleware('demo', ['only' => ['profile_update', 'password_update']]);
    }


    /**
     * Dashboard.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        try{

            $rides = UserRequests::has('user')->orderBy('id','desc')->get();
            $cancel_rides = UserRequests::where('status','CANCELLED');
            $scheduled_rides = UserRequests::where('status','SCHEDULED')->count();
            $user_cancelled = $cancel_rides->where('cancelled_by','USER')->count();
            $provider_cancelled = $cancel_rides->where('cancelled_by','PROVIDER')->count();
            $cancel_rides = $cancel_rides->count();
            $service = ServiceType::count();
            $fleet = Fleet::count();
            $revenue = UserRequestPayment::sum('total');
            $providers = Provider::take(10)->orderBy('rating','desc')->get();

            return view('account.dashboard',compact('providers','fleet','scheduled_rides','service','rides','user_cancelled','provider_cancelled','cancel_rides','revenue'));
        }
        catch(Exception $e){
            return redirect()->route('account.user.index')->with('flash_error','Something Went Wrong with Dashboard!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('account.account.profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile_update(Request $request)
    {

        $this->validate($request,[
            'name' => 'required|max:255',
            'mobile' => 'required|digits_between:6,13',
        ]);

        try{
            $account = Auth::guard('account')->user();
            $account->name = $request->name;
            $account->mobile = $request->mobile;
            $account->save();

            return redirect()->back()->with('flash_success','Profile Updated');
        }

        catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function password()
    {
        return view('account.account.change-password');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function password_update(Request $request)
    {

        $this->validate($request,[
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        try {

           $Account = Account::find(Auth::guard('account')->user()->id);

            if(password_verify($request->old_password, $Account->password))
            {
                $Account->password = bcrypt($request->password);
                $Account->save();

                return redirect()->back()->with('flash_success','Password Updated');
            }
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * account statements.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function statement($type = 'individual', $request = null){

        try{

            $page = 'Ride Statement';

            if($type == 'individual'){
                $page = 'Provider Ride Statement';
            }elseif($type == 'today'){
                $page = 'Today Statement - '. date('d M Y');
            }elseif($type == 'monthly'){
                $page = 'This Month Statement - '. date('F');
            }elseif($type == 'yearly'){
                $page = 'This Year Statement - '. date('Y');
            }elseif($type == 'range'){
                $page = 'Ride Statement from '.Carbon::createFromFormat('Y-m-d', $request->from_date)->format('d M Y').' to '.Carbon::createFromFormat('Y-m-d', $request->to_date)->format('d M Y');
            }

            $rides = UserRequests::with('payment')->orderBy('id','desc');
            $cancel_rides = UserRequests::where('status','CANCELLED');
            $revenue = UserRequestPayment::select(\DB::raw(
                           'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission' 
                       ));

            if($type == 'today'){

                $rides->where('created_at', '>=', Carbon::today());
                $cancel_rides->where('created_at', '>=', Carbon::today());
                $revenue->where('created_at', '>=', Carbon::today());

            }elseif($type == 'monthly'){

                $rides->where('created_at', '>=', Carbon::now()->month);
                $cancel_rides->where('created_at', '>=', Carbon::now()->month);
                $revenue->where('created_at', '>=', Carbon::now()->month);

            }elseif($type == 'yearly'){

                $rides->where('created_at', '>=', Carbon::now()->year);
                $cancel_rides->where('created_at', '>=', Carbon::now()->year);
                $revenue->where('created_at', '>=', Carbon::now()->year);

            }elseif ($type == 'range') {

                if($request->from_date == $request->to_date) {
                    $rides->whereDate('created_at', date('Y-m-d', strtotime($request->from_date)));
                    $cancel_rides->whereDate('created_at', date('Y-m-d', strtotime($request->from_date)));
                    $revenue->whereDate('created_at', date('Y-m-d', strtotime($request->from_date)));
                } else {
                    $rides->whereBetween('created_at',[Carbon::createFromFormat('Y-m-d', $request->from_date),Carbon::createFromFormat('Y-m-d', $request->to_date)]);
                    $cancel_rides->whereBetween('created_at',[Carbon::createFromFormat('Y-m-d', $request->from_date),Carbon::createFromFormat('Y-m-d', $request->to_date)]);
                    $revenue->whereBetween('created_at',[Carbon::createFromFormat('Y-m-d', $request->from_date),Carbon::createFromFormat('Y-m-d', $request->to_date)]);
                }
            }

            $rides = $rides->get();
            $cancel_rides = $cancel_rides->count();
            $revenue = $revenue->get();

            return view('account.providers.statement', compact('rides','cancel_rides','revenue'))
                    ->with('page',$page);

        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }


    /**
     * account statements today.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function statement_today(){
        return $this->statement('today');
    }

    /**
     * account statements today.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function statement_range(Request $request){
        return $this->statement('range', $request);
    }

    /**
     * account statements monthly.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function statement_monthly(){
        return $this->statement('monthly');
    }

     /**
     * account statements monthly.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function statement_yearly(){
        return $this->statement('yearly');
    }


    /**
     * account statements.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function statement_provider(){

        try{

            $Providers = Provider::all();

            foreach($Providers as $index => $Provider){

                $Rides = UserRequests::where('provider_id',$Provider->id)
                            ->where('status','<>','CANCELLED')
                            ->get()->pluck('id');

                $Providers[$index]->rides_count = $Rides->count();

                $Providers[$index]->payment = UserRequestPayment::whereIn('request_id', $Rides)
                                ->select(\DB::raw(
                                   'SUM(ROUND(fixed) + ROUND(distance)) as overall, SUM(ROUND(commision)) as commission' 
                                ))->get();
            }

            return view('account.providers.provider-statement', compact('Providers'))->with('page','Providers Statement');

        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}
