<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Client;
use App\Project;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
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
    public function create(Request $request)
    {
        $clientsList = [0 => 'Select a client'];
        foreach(Client::all() as $client){
            $clientsList[$client->id] = $client->name;
        }
        $clientId = $request->input('client');
        if(!isset($clientId)){
            $clientId = 0;
        }
        return view('projects.create', ['clientsList' => $clientsList, 'clientId' => $clientId]);
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
            'name' => 'required|unique:projects|max:255',
            'client' => 'required|integer|min:1'
        ]);

        $project = new Project;
        $project->name = $request->input('name');
        $project->client_id = $request->input('client');
        $project->save();

        return redirect()->route('project.show', $project->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('projects.show', ['project' => Project::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clientsList = [0 => 'Select a client'];
        foreach(Client::all() as $client){
            $clientsList[$client->id] = $client->name;
        }
        return view('projects.edit', ['project' => Project::find($id), 'clientsList' => $clientsList]);
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
            'name' => 'required|unique:projects|max:255',
            'client' => 'required|integer|min:1'
        ]);

        $project = Project::find($id);
        $project->name = $request->input('name');
        $project->client_id = $request->input('client');
        $project->save();

        return redirect()->route('project.show', $id);
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
            Project::destroy($id);
            return response(['msg' => 'Project deleted', 'status' => 'success']);
        }
    }

    /**
     * Archive the project, it will appear anymore
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function archive($id){
        $project = Project::find($id);
        $project->archived = 1;
        $project->save();

        return redirect()->route('client.show', $project->client->id);
    }

    /**
     * Republish the project
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function publish($id){
        $project = Project::find($id);
        $project->archived = 0;
        $project->save();

        return redirect()->route('client.show', $project->client->id);
    }
}
