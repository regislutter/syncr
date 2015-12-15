<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;
use App\Project;
use App\File;
use App\Copydeck;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CopydeckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('copydeck.index', ['copydecks' => Copydeck::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $project_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($project_id)
    {
        return view('copydeck.create', ['project' => Project::find($project_id)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $project_id Project ID
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(Request $request, $project_id)
    {
        $this->validate($request, [
            'name' => 'required|unique:projects|max:255',
            'link' => 'required_without:tinycontent',
            'tinycontent' => 'not_with:link',
            'version1' => 'required',
            'version2' => 'required'
        ]);

        $copydeck = new Copydeck();
        $copydeck->name = $request->input('name');

        $version = floatval($request->input('version1').'.'.$request->input('version2'));

        $file = new File;
        $file->link = $request->input('link');
        $file->content = $request->input('tinycontent');
        $file->version = $version;
        $file->user_id = Auth::user()->id;

        DB::beginTransaction(); //Start transaction!
        try{
            //saving logic here
            Project::find($project_id)->copydecks()->save($copydeck);
            Copydeck::find($copydeck->id)->files()->save($file);
        }
        catch(\Exception $e)
        {
            //failed logic here
            DB::rollback();
            throw $e;
        }
        DB::commit();

        return redirect()->route('copydeck.show', $copydeck->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('copydeck.show', ['copydeck' => Copydeck::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('copydeck.edit', ['copydeck' => Copydeck::find($id)]);
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
        $this->validate($request, [
            'name' => 'required|unique:copydecks|max:255'
        ]);

        $copydeck = Copydeck::find($id);
        $copydeck->name = $request->input('name');
        $copydeck->save();

        return redirect()->route('copydeck.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ( $request->ajax() ) {
            Copydeck::destroy($id);
            return response(['msg' => 'Copydeck deleted', 'status' => 'success']);
        }
    }
}
