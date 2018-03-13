<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserRequests;
use App\UserRequestPayment;
use App\RequestFilter;
use App\Provider;
use Carbon\Carbon;
use App\Http\Controllers\ProviderResources\TripController;

class ProviderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('provider');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('provider.index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function incoming(Request $request)
    {
        return (new TripController())->index($request);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function accept(Request $request, $id)
    {
        return (new TripController())->accept($request, $id);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function reject($id)
    {
        return (new TripController())->destroy($id);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        return (new TripController())->update($request, $id);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function rating(Request $request, $id)
    {
        return (new TripController())->rate($request, $id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function earnings()
    {
        $provider = Provider::where('id',\Auth::guard('provider')->user()->id)
                    ->with('service','accepted','cancelled')
                    ->get();

        $weekly = UserRequests::where('provider_id',\Auth::guard('provider')->user()->id)
                    ->with('payment')
                    ->where('created_at', '>=', Carbon::now()->subWeekdays(7))
                    ->get();

        $weekly_sum = UserRequestPayment::whereHas('request', function($query) {
                        $query->where('provider_id',\Auth::guard('provider')->user()->id);
                        $query->where('created_at', '>=', Carbon::now()->subWeekdays(7));
                    })
                        ->sum('provider_pay');

        $today = UserRequests::where('provider_id',\Auth::guard('provider')->user()->id)
                    ->where('created_at', '>=', Carbon::today())
                    ->count();

        $fully = UserRequests::where('provider_id',\Auth::guard('provider')->user()->id)
                    ->with('payment','service_type')
                    ->get();

        $fully_sum = UserRequestPayment::whereHas('request', function($query) {
                        $query->where('provider_id', \Auth::guard('provider')->user()->id);
                        })
                        ->sum('provider_pay');

        return view('provider.payment.earnings',compact('provider','weekly','fully','today','weekly_sum','fully_sum'));
    }

    /**
     * available.
     *
     * @return \Illuminate\Http\Response
     */
    public function available(Request $request)
    {
        (new ProviderResources\ProfileController)->available($request);
        return back();
    }

    /**
     * Show the application change password.
     *
     * @return \Illuminate\Http\Response
     */
    public function change_password()
    {
        return view('provider.profile.change_password');
    }

    /**
     * Change Password.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request)
    {
        $this->validate($request, [
                'password' => 'required|confirmed',
                'old_password' => 'required',
            ]);

        $Provider = \Auth::user();

        if(password_verify($request->old_password, $Provider->password))
        {
            $Provider->password = bcrypt($request->password);
            $Provider->save();

            return back()->with('flash_success','Password changed successfully!');
        } else {
            return back()->with('flash_error','Please enter correct password');
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function location_edit()
    {
        return view('provider.location.index');
    }

    /**
     * Update latitude and longitude of the user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function location_update(Request $request)
    {
        $this->validate($request, [
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

        if($Provider = \Auth::user()){

            $Provider->latitude = $request->latitude;
            $Provider->longitude = $request->longitude;
            $Provider->save();

            return back()->with(['flash_success' => 'Location Updated successfully!']);

        } else {
            return back()->with(['flash_error' => 'Provider Not Found!']);
        }
    }

    /**
     * upcoming history.
     *
     * @return \Illuminate\Http\Response
     */
    public function upcoming_trips()
    {
        $fully = (new ProviderResources\TripController)->upcoming_trips();
        return view('provider.payment.upcoming',compact('fully'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function cancel(Request $request) {
        try{
            (new TripController)->cancel($request);
            return back();
        } catch (ModelNotFoundException $e) {
            return back()->with(['flash_error' => "Something Went Wrong"]);
        }
    }
}