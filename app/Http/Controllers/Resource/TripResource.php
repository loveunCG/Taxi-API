<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserRequests;
use Auth;
use Setting;

class TripResource extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('demo', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $requests = UserRequests::RequestHistory()->get();
            return view('admin.request.index', compact('requests'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function Fleetindex()
    {
        try {
            $requests = UserRequests::RequestHistory()
                        ->whereHas('provider', function($query) {
                            $query->where('fleet', Auth::user()->id );
                        })->get();
            return view('fleet.request.index', compact('requests'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function scheduled()
    {
        try{
            $requests = UserRequests::where('status' , 'SCHEDULED')
                        ->RequestHistory()
                        ->get();

            return view('admin.request.scheduled', compact('requests'));
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Fleetscheduled()
    {
        try{
            $requests = UserRequests::where('status' , 'SCHEDULED')
                         ->whereHas('provider', function($query) {
                            $query->where('fleet', Auth::user()->id );
                        })
                        ->get();

            return view('fleet.request.scheduled', compact('requests'));
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $request = UserRequests::findOrFail($id);
            return view('admin.request.show', compact('request'));
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function Fleetshow($id)
    {
        try {
            $request = UserRequests::findOrFail($id);
            return view('fleet.request.show', compact('request'));
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function Accountshow($id)
    {
        try {
            $request = UserRequests::findOrFail($id);
            return view('account.request.show', compact('request'));
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $Request = UserRequests::findOrFail($id);
            $Request->delete();
            return back()->with('flash_success','Request Deleted!');
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function Fleetdestroy($id)
    {
        try {
            $Request = UserRequests::findOrFail($id);
            $Request->delete();
            return back()->with('flash_success','Request Deleted!');
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}
