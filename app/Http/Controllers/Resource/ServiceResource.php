<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Setting;
use Exception;
use App\Helpers\Helper;

use App\ServiceType;

class ServiceResource extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('demo', ['only' => [ 'store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = ServiceType::all();
        if($request->ajax()) {
            return $services;
        } else {
            return view('admin.service.index', compact('services'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:255',
            'provider_name' => 'required|max:255',
            'capacity' => 'required|numeric',
            'fixed' => 'required|numeric',
            'price' => 'required|numeric',
            'minute' => 'required|numeric',
            'distance' => 'required|numeric',
            'calculator' => 'required|in:MIN,HOUR,DISTANCE,DISTANCEMIN,DISTANCEHOUR',
            'image' => 'mimes:ico,png'
        ]);

        try {
            $service = $request->all();

            if($request->hasFile('image')) {
                $service['image'] = Helper::upload_picture($request->image);
            }

            $service = ServiceType::create($service);

            return back()->with('flash_success','Service Type Saved Successfully');
        } catch (Exception $e) {
            dd("Exception", $e);
            return back()->with('flash_error', 'Service Type Not Found');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return ServiceType::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Service Type Not Found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $service = ServiceType::findOrFail($id);
            return view('admin.service.edit',compact('service'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Service Type Not Found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $this->validate($request, [
            'name' => 'required|max:255',
            'provider_name' => 'required|max:255',
            'fixed' => 'required|numeric',
            'price' => 'required|numeric',
            'image' => 'mimes:ico,png'
        ]);

        try {

            $service = ServiceType::findOrFail($id);

            if($request->hasFile('image')) {
                if($service->image) {
                    Helper::delete_picture($service->image);
                }
                $service->image = Helper::upload_picture($request->image);
            }

            $service->name = $request->name;
            $service->provider_name = $request->provider_name;
            $service->fixed = $request->fixed;
            $service->price = $request->price;
            $service->minute = $request->minute;
            $service->distance = $request->distance;
            $service->calculator = $request->calculator;
            $service->capacity = $request->capacity;
            $service->save();

            return redirect()->route('admin.service.index')->with('flash_success', 'Service Type Updated Successfully');    
        } 

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Service Type Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        try {
            ServiceType::find($id)->delete();
            return back()->with('message', 'Service Type deleted successfully');
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Service Type Not Found');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Service Type Not Found');
        }
    }
}