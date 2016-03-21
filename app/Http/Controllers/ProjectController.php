<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Client;
use App\Project;
use App\DesignChart;
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
            'client' => 'required|integer|min:1',

            'font_serif' => 'max:255',
            'font_sans_serif' => 'max:255',
            'font_size' => 'integer|min:1|max:255',
            'line_height' => 'integer|min:1|max:255',

            'background_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'primary_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'secondary_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'info_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'success_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'warning_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'alert_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',

            'title_h1_font' => 'max:255',
            'title_h1_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'title_h1_font-size' => 'integer|min:1|max:255',
            'title_h1_line-height' => 'integer|min:1|max:255',

            'title_h2_font' => 'max:255',
            'title_h2_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'title_h2_font-size' => 'integer|min:1|max:255',
            'title_h2_line-height' => 'integer|min:1|max:255',

            'title_h3_font' => 'max:255',
            'title_h3_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'title_h3_font-size' => 'integer|min:1|max:255',
            'title_h3_line-height' => 'integer|min:1|max:255',

            'title_h4_font' => 'max:255',
            'title_h4_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'title_h4_font-size' => 'integer|min:1|max:255',
            'title_h4_line-height' => 'integer|min:1|max:255',

            'title_h5_font' => 'max:255',
            'title_h5_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'title_h5_font-size' => 'integer|min:1|max:255',
            'title_h5_line-height' => 'integer|min:1|max:255',

            'title_h6_font' => 'max:255',
            'title_h6_color' => 'max:6|regex:^[a-f0-9]{6}^',
            'title_h6_font-size' => 'integer|min:1|max:255',
            'title_h6_line-height' => 'integer|min:1|max:255',

            'text_font' => 'max:255',
            'text_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'text_font_size' => 'integer|min:1|max:255',
            'text_line_height' => 'integer|min:1|max:255',

            'breakpoint_mobile' => 'integer|min:320|max:2048',
            'breakpoint_tablet' => 'integer|min:320|max:2048',
            'breakpoint_desktop' => 'integer|min:320|max:2048',
        ]);

        $designChart = DesignChart::create($request->all());

        $project = new Project;
        $project->name = $request->input('name');
        $project->client_id = $request->input('client');
        $project->designchart_id = $designChart->id;
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
        $project = Project::find($id);
        return view('projects.show', ['project' => $project, 'designchart' => $project->designchart()->first()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get all clients
        $clientsList = [0 => 'Select a client'];
        foreach(Client::all() as $client){
            $clientsList[$client->id] = $client->name;
        }

        // Get project
        $project = Project::find($id);

        // Copy the design chart data in the project Model to automatically fill the form
        $designchart = $project->designchart()->first();
        if($designchart){
            $attrs = $designchart->getAttributes();
            foreach($attrs as $name => $value) {
                if($name != 'id'){
                    $project->$name = $value;
                }
            }
        }

        // Load view
        return view('projects.edit', ['project' => $project, 'clientsList' => $clientsList]);
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
            'name' => 'required|max:255|unique:projects,id,'.$id,
            'client' => 'required|integer|min:1',

            'font_serif' => 'max:255',
            'font_sans_serif' => 'max:255',
            'font_size' => 'integer|min:1|max:255',
            'line_height' => 'integer|min:1|max:255',

            'background_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'primary_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'secondary_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'info_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'success_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'warning_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'alert_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',

            'title_h1_font' => 'max:255',
            'title_h1_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'title_h1_font-size' => 'integer|min:1|max:255',
            'title_h1_line-height' => 'integer|min:1|max:255',

            'title_h2_font' => 'max:255',
            'title_h2_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'title_h2_font-size' => 'integer|min:1|max:255',
            'title_h2_line-height' => 'integer|min:1|max:255',

            'title_h3_font' => 'max:255',
            'title_h3_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'title_h3_font-size' => 'integer|min:1|max:255',
            'title_h3_line-height' => 'integer|min:1|max:255',

            'title_h4_font' => 'max:255',
            'title_h4_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'title_h4_font-size' => 'integer|min:1|max:255',
            'title_h4_line-height' => 'integer|min:1|max:255',

            'title_h5_font' => 'max:255',
            'title_h5_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'title_h5_font-size' => 'integer|min:1|max:255',
            'title_h5_line-height' => 'integer|min:1|max:255',

            'title_h6_font' => 'max:255',
            'title_h6_color' => 'max:6|regex:^[a-f0-9]{6}^',
            'title_h6_font-size' => 'integer|min:1|max:255',
            'title_h6_line-height' => 'integer|min:1|max:255',

            'text_font' => 'max:255',
            'text_color' => 'max:6|regex:^[a-fA-F0-9]{6}^',
            'text_font_size' => 'integer|min:1|max:255',
            'text_line_height' => 'integer|min:1|max:255',

            'breakpoint_mobile' => 'integer|min:320|max:2048',
            'breakpoint_tablet' => 'integer|min:320|max:2048',
            'breakpoint_desktop' => 'integer|min:320|max:2048',
        ]);

        // Find project
        $project = Project::find($id);

        // Update project design chart
        $designchart = $project->designchart()->first();
        if($designchart){
            $designchart->update($request->all());
        }else{
            $designchart = DesignChart::create($request->all());
        }

        // Update project
        $project->name = $request->input('name');
        $project->client_id = $request->input('client');
        $project->designchart_id = $designchart->id;
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
