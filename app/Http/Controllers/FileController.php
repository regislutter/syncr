<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Auth;
use App\Copydeck;
use App\File;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($project_id, $copydeck_id)
    {
        return view('files.create', ['copydeck' => Copydeck::find($copydeck_id)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $project_id, $copydeck_id)
    {
        $this->validate($request, [
            'link' => 'required',
            'version1' => 'required',
            'version2' => 'required'
        ]);

        // TODO Block previous versions for non-admin

        $version = floatval($request->input('version1').'.'.$request->input('version2'));

        $file = new File;
        $file->link = $request->input('link');
        $file->version = $version;
        $file->user_id = Auth::user()->id;
        Copydeck::find($copydeck_id)->files()->save($file);

        return redirect()->route('copydeck.show', $copydeck_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($copydeck_id, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($copydeck_id, $id)
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
    public function update(Request $request, $copydeck_id, $id)
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
        //
    }

    public function changeStatus($id, $status){
        $file = File::find($id);
        $file->status = $status;
        $file->status_updated_at = Carbon::now();
        $file->save();

        // TODO Send mails to subscribers

        return redirect()->route('copydeck.show', $file->copydeck->id);
    }
}
