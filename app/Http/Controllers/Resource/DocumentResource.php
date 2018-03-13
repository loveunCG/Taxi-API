<?php

namespace App\Http\Controllers\Resource;

use App\Document;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Setting;

class DocumentResource extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('demo', ['only' => ['store' ,'update', 'destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Document::orderBy('created_at' , 'desc')->get();
        return view('admin.document.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.document.create');
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
            'type' => 'required|in:VEHICLE,DRIVER',
        ]);

        try{

            Document::create($request->all());
            return redirect()->route('admin.document.index')->with('flash_success','Document Saved Successfully');

        } 

        catch (Exception $e) {
            return back()->with('flash_error', 'Document Not Found');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Document  $providerDocument
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return Document::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $providerDocument
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $document = Document::findOrFail($id);
            return view('admin.document.edit',compact('document'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $providerDocument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'type' => 'required|in:VEHICLE,DRIVER',
        ]);

        try {
            Document::where('id',$id)->update([
                    'name' => $request->name,
                    'type' => $request->type,
                ]);
            return redirect()->route('admin.document.index')->with('flash_success', 'Document Updated Successfully');    
        } 

        catch (Exception $e) {
            return back()->with('flash_error', 'Document Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $providerDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Document::find($id)->delete();
            return back()->with('message', 'Document deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Document Not Found');
        }
    }
}
