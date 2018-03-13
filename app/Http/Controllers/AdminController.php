<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\Helper;

use Auth;
use Setting;
use Exception;
use \Carbon\Carbon;
use App\Http\Controllers\SendPushNotification;

use App\User;
use App\Fleet;
use App\Admin;
use App\Provider;
use App\UserPayment;
use App\ServiceType;
use App\UserRequests;
use App\ProviderService;
use App\UserRequestRating;
use App\UserRequestPayment;
use App\CustomPush;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('demo', ['only' => [
                'settings_store', 
                'settings_payment_store',
                'profile_update',
                'password_update',
                'send_push',
            ]]);
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

            return view('admin.dashboard',compact('providers','fleet','scheduled_rides','service','rides','user_cancelled','provider_cancelled','cancel_rides','revenue'));
        }
        catch(Exception $e){
            return redirect()->route('admin.user.index')->with('flash_error','Something Went Wrong with Dashboard!');
        }
    }


    /**
     * Heat Map.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function heatmap()
    {
        try{
            $rides = UserRequests::has('user')->orderBy('id','desc')->get();
            $providers = Provider::take(10)->orderBy('rating','desc')->get();
            return view('admin.heatmap',compact('providers','rides'));
        }
        catch(Exception $e){
            return redirect()->route('admin.user.index')->with('flash_error','Something Went Wrong with Dashboard!');
        }
    }

    /**
     * Map of all Users and Drivers.
     *
     * @return \Illuminate\Http\Response
     */
    public function map_index()
    {
        return view('admin.map.index');
    }

    /**
     * Map of all Users and Drivers.
     *
     * @return \Illuminate\Http\Response
     */
    public function map_ajax()
    {
        try {

            $Providers = Provider::where('latitude', '!=', 0)
                    ->where('longitude', '!=', 0)
                    ->with('service')
                    ->get();

            $Users = User::where('latitude', '!=', 0)
                    ->where('longitude', '!=', 0)
                    ->get();

            for ($i=0; $i < sizeof($Users); $i++) { 
                $Users[$i]->status = 'user';
            }

            $All = $Users->merge($Providers);

            return $All;

        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        return view('admin.settings.application');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function settings_store(Request $request)
    {
        $this->validate($request,[
                'site_title' => 'required',
                'site_icon' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
                'site_logo' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            ]);

        if($request->hasFile('site_icon')) {
            $site_icon = Helper::upload_picture($request->file('site_icon'));
            Setting::set('site_icon', $site_icon);
        }

        if($request->hasFile('site_logo')) {
            $site_logo = Helper::upload_picture($request->file('site_logo'));
            Setting::set('site_logo', $site_logo);
        }

        if($request->hasFile('site_email_logo')) {
            $site_email_logo = Helper::upload_picture($request->file('site_email_logo'));
            Setting::set('site_email_logo', $site_email_logo);
        }

        Setting::set('site_title', $request->site_title);
        Setting::set('store_link_android', $request->store_link_android);
        Setting::set('store_link_ios', $request->store_link_ios);
        Setting::set('provider_select_timeout', $request->provider_select_timeout);
        Setting::set('provider_search_radius', $request->provider_search_radius);
        Setting::set('sos_number', $request->sos_number);
        Setting::set('contact_number', $request->contact_number);
        Setting::set('contact_email', $request->contact_email);
        Setting::set('site_copyright', $request->site_copyright);
        Setting::set('social_login', $request->social_login);
        Setting::set('manual_request', $request->manual_request == 'on' ? 1 : 0 );
        Setting::set('broadcast_request', $request->broadcast_request == 'on' ? 1 : 0 );
        Setting::set('track_distance', $request->track_distance == 'on' ? 1 : 0 );
        Setting::save();
        
        return back()->with('flash_success','Settings Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function settings_payment()
    {
        return view('admin.payment.settings');
    }

    /**
     * Save payment related settings.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function settings_payment_store(Request $request)
    {

        $this->validate($request, [
                'CARD' => 'in:on',
                'CASH' => 'in:on',
                'stripe_secret_key' => 'required_if:CARD,on|max:255',
                'stripe_publishable_key' => 'required_if:CARD,on|max:255',
                'daily_target' => 'required|integer|min:0',
                'tax_percentage' => 'required|numeric|min:0|max:100',
                'surge_percentage' => 'required|numeric|min:0|max:100',
                'commission_percentage' => 'required|numeric|min:0|max:100',
                'provider_commission_percentage' => 'required|numeric|min:0|max:100',
                'surge_trigger' => 'required|integer|min:0',
                'currency' => 'required'
            ]);

        Setting::set('CARD', $request->has('CARD') ? 1 : 0 );
        Setting::set('CASH', $request->has('CASH') ? 1 : 0 );
        Setting::set('stripe_secret_key', $request->stripe_secret_key);
        Setting::set('stripe_publishable_key', $request->stripe_publishable_key);
        Setting::set('daily_target', $request->daily_target);
        Setting::set('tax_percentage', $request->tax_percentage);
        Setting::set('surge_percentage', $request->surge_percentage);
        Setting::set('commission_percentage', $request->commission_percentage);
        Setting::set('provider_commission_percentage', $request->provider_commission_percentage);
        Setting::set('surge_trigger', $request->surge_trigger);
        Setting::set('currency', $request->currency);
        Setting::set('booking_prefix', $request->booking_prefix);
        Setting::save();

        return back()->with('flash_success','Settings Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('admin.account.profile');
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
            'email' => 'required|max:255|email|unique:admins',
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
        ]);

        try{
            $admin = Auth::guard('admin')->user();
            $admin->name = $request->name;
            $admin->email = $request->email;
            
            if($request->hasFile('picture')){
                $admin->picture = $request->picture->store('admin/profile');  
            }
            $admin->save();

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
        return view('admin.account.change-password');
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

           $Admin = Admin::find(Auth::guard('admin')->user()->id);

            if(password_verify($request->old_password, $Admin->password))
            {
                $Admin->password = bcrypt($request->password);
                $Admin->save();

                return redirect()->back()->with('flash_success','Password Updated');
            }
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function payment()
    {
        try {
             $payments = UserRequests::where('paid', 1)
                    ->has('user')
                    ->has('provider')
                    ->has('payment')
                    ->orderBy('user_requests.created_at','desc')
                    ->get();
            
            return view('admin.payment.payment-history', compact('payments'));
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function help()
    {
        try {
            $str = file_get_contents('http://appoets.com/help.json');
            $Data = json_decode($str, true);
            return view('admin.help', compact('Data'));
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * User Rating.
     *
     * @return \Illuminate\Http\Response
     */
    public function user_review()
    {
        try {
            $Reviews = UserRequestRating::where('user_id', '!=', 0)->has('user', 'provider')->get();
            return view('admin.review.user_review',compact('Reviews'));
        } catch(Exception $e) {
            return redirect()->route('admin.setting')->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * Provider Rating.
     *
     * @return \Illuminate\Http\Response
     */
    public function provider_review()
    {
        try {
            $Reviews = UserRequestRating::where('provider_id','!=',0)->with('user','provider')->get();
            return view('admin.review.provider_review',compact('Reviews'));
        } catch(Exception $e) {
            return redirect()->route('admin.setting')->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProviderService
     * @return \Illuminate\Http\Response
     */
    public function destory_provider_service($id){
        try {
            ProviderService::find($id)->delete();
            return back()->with('message', 'Service deleted successfully');
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * Testing page for push notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function push_index()
    {

        $data = \PushNotification::app('IOSUser')
            ->to('3911e9870e7c42566b032266916db1f6af3af1d78da0b52ab230e81d38541afa')
            ->send('Hello World, i`m a push message');
        dd($data);
    }

    /**
     * Testing page for push notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function push_store(Request $request)
    {
        try {
            ProviderService::find($id)->delete();
            return back()->with('message', 'Service deleted successfully');
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * privacy.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */

    public function privacy(){
        return view('admin.pages.static')
            ->with('title',"Privacy Page")
            ->with('page', "privacy");
    }

    /**
     * pages.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function pages(Request $request){
        $this->validate($request, [
                'page' => 'required|in:page_privacy',
                'content' => 'required',
            ]);

        Setting::set($request->page, $request->content);
        Setting::save();

        return back()->with('flash_success', 'Content Updated!');
    }

    /**
     * account statements.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function statement($type = 'individual'){

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

            }

            $rides = $rides->get();
            $cancel_rides = $cancel_rides->count();
            $revenue = $revenue->get();

            return view('admin.providers.statement', compact('rides','cancel_rides','revenue'))
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
                                   'SUM(ROUND(provider_pay)) as overall, SUM(ROUND(provider_commission)) as commission' 
                                ))->get();
            }

            return view('admin.providers.provider-statement', compact('Providers'))->with('page','Providers Statement');

        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function translation(){

        try{
            return view('admin.translation');
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
    public function push(){

        try{
            $Pushes = CustomPush::orderBy('id','desc')->get();
            return view('admin.push',compact('Pushes'));
        }

        catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }


    /**
     * pages.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function send_push(Request $request){


        $this->validate($request, [
                'send_to' => 'required|in:ALL,USERS,PROVIDERS',
                'user_condition' => ['required_if:send_to,USERS','in:ACTIVE,LOCATION,RIDES,AMOUNT'],
                'provider_condition' => ['required_if:send_to,PROVIDERS','in:ACTIVE,LOCATION,RIDES,AMOUNT'],
                'user_active' => ['required_if:user_condition,ACTIVE','in:HOUR,WEEK,MONTH'],
                'user_rides' => 'required_if:user_condition,RIDES',
                'user_location' => 'required_if:user_condition,LOCATION',
                'user_amount' => 'required_if:user_condition,AMOUNT',
                'provider_active' => ['required_if:provider_condition,ACTIVE','in:HOUR,WEEK,MONTH'],
                'provider_rides' => 'required_if:provider_condition,RIDES',
                'provider_location' => 'required_if:provider_condition,LOCATION',
                'provider_amount' => 'required_if:provider_condition,AMOUNT',
                'message' => 'required|max:100',
            ]);

        try{

            $CustomPush = new CustomPush;
            $CustomPush->send_to = $request->send_to;
            $CustomPush->message = $request->message;

            if($request->send_to == 'USERS'){

                $CustomPush->condition = $request->user_condition;

                if($request->user_condition == 'ACTIVE'){
                    $CustomPush->condition_data = $request->user_active;
                }elseif($request->user_condition == 'LOCATION'){
                    $CustomPush->condition_data = $request->user_location;
                }elseif($request->user_condition == 'RIDES'){
                    $CustomPush->condition_data = $request->user_rides;
                }elseif($request->user_condition == 'AMOUNT'){
                    $CustomPush->condition_data = $request->user_amount;
                }

            }elseif($request->send_to == 'PROVIDERS'){

                $CustomPush->condition = $request->provider_condition;

                if($request->provider_condition == 'ACTIVE'){
                    $CustomPush->condition_data = $request->provider_active;
                }elseif($request->provider_condition == 'LOCATION'){
                    $CustomPush->condition_data = $request->provider_location;
                }elseif($request->provider_condition == 'RIDES'){
                    $CustomPush->condition_data = $request->provider_rides;
                }elseif($request->provider_condition == 'AMOUNT'){
                    $CustomPush->condition_data = $request->provider_amount;
                }
            }

            if($request->has('schedule_date') && $request->has('schedule_time')){
                $CustomPush->schedule_at = date("Y-m-d H:i:s",strtotime("$request->schedule_date $request->schedule_time"));
            }

            $CustomPush->save();

            if($CustomPush->schedule_at == ''){
                $this->SendCustomPush($CustomPush->id);
            }

            return back()->with('flash_success', 'Message Sent to all '.$request->segment);
        }

        catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }


    public function SendCustomPush($CustomPush){

        try{

            \Log::notice("Starting Custom Push");

            $Push = CustomPush::findOrFail($CustomPush);

            if($Push->send_to == 'USERS'){

                $Users = [];

                if($Push->condition == 'ACTIVE'){

                    if($Push->condition_data == 'HOUR'){

                        $Users = User::whereHas('trips', function($query) {
                            $query->where('created_at','>=',Carbon::now()->subHour());
                        })->get();
                        
                    }elseif($Push->condition_data == 'WEEK'){

                        $Users = User::whereHas('trips', function($query){
                            $query->where('created_at','>=',Carbon::now()->subWeek());
                        })->get();

                    }elseif($Push->condition_data == 'MONTH'){

                        $Users = User::whereHas('trips', function($query){
                            $query->where('created_at','>=',Carbon::now()->subMonth());
                        })->get();

                    }

                }elseif($Push->condition == 'RIDES'){

                    $Users = User::whereHas('trips', function($query) use ($Push){
                                $query->where('status','COMPLETED');
                                $query->groupBy('id');
                                $query->havingRaw('COUNT(*) >= '.$Push->condition_data);
                            })->get();


                }elseif($Push->condition == 'LOCATION'){

                    $Location = explode(',', $Push->condition_data);

                    $distance = Setting::get('provider_search_radius', '10');
                    $latitude = $Location[0];
                    $longitude = $Location[1];

                    $Users = User::whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                            ->get();

                }


                foreach ($Users as $key => $user) {
                    (new SendPushNotification)->sendPushToUser($user->id, $Push->message);
                }

            }elseif($Push->send_to == 'PROVIDERS'){


                $Providers = [];

                if($Push->condition == 'ACTIVE'){

                    if($Push->condition_data == 'HOUR'){

                        $Providers = Provider::whereHas('trips', function($query){
                            $query->where('created_at','>=',Carbon::now()->subHour());
                        })->get();
                        
                    }elseif($Push->condition_data == 'WEEK'){

                        $Providers = Provider::whereHas('trips', function($query){
                            $query->where('created_at','>=',Carbon::now()->subWeek());
                        })->get();

                    }elseif($Push->condition_data == 'MONTH'){

                        $Providers = Provider::whereHas('trips', function($query){
                            $query->where('created_at','>=',Carbon::now()->subMonth());
                        })->get();

                    }

                }elseif($Push->condition == 'RIDES'){

                    $Providers = Provider::whereHas('trips', function($query) use ($Push){
                               $query->where('status','COMPLETED');
                                $query->groupBy('id');
                                $query->havingRaw('COUNT(*) >= '.$Push->condition_data);
                            })->get();

                }elseif($Push->condition == 'LOCATION'){

                    $Location = explode(',', $Push->condition_data);

                    $distance = Setting::get('provider_search_radius', '10');
                    $latitude = $Location[0];
                    $longitude = $Location[1];

                    $Providers = Provider::whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                            ->get();

                }


                foreach ($Providers as $key => $provider) {
                    (new SendPushNotification)->sendPushToProvider($provider->id, $Push->message);
                }

            }elseif($Push->send_to == 'ALL'){

                $Users = User::all();
                foreach ($Users as $key => $user) {
                    (new SendPushNotification)->sendPushToUser($user->id, $Push->message);
                }

                $Providers = Provider::all();
                foreach ($Providers as $key => $provider) {
                    (new SendPushNotification)->sendPushToProvider($provider->id, $Push->message);
                }

            }
        }

        catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }


}
