<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Ticket;
use App\User;
use App\Project;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ticket.index', ['tickets' => Ticket::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $usersList = [0 => 'Select a user'];
//        foreach(User::all() as $user){
//            $usersList[$user->id] = $user->name;
//        }
        $projectsList = ['' => 'Select a project'];
        foreach(Project::all() as $project){
            $projectsList[$project->id] = $project->name;
        }
        return view('ticket.create', ['projects' => $projectsList, 'categories' => Ticket::$CATEGORIES, 'priorities' => Ticket::$PRIORITIES, 'estimates' => Ticket::$ESTIMATES]); // 'users' => $usersList,
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
            'category' => 'required',
            'date_start' => 'date|date_format:Y-n-j',
            'date_end' => 'date|date_format:Y-n-j'
        ]);

        Ticket::create($request->all());

        return redirect()->route('kanban');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('ticket.show', ['ticket' => Ticket::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::find($id);

        $usersList = [0 => 'Select a user'];
        foreach(User::all() as $user){
            $usersList[$user->id] = $user->name;
        }
        $projectsList = ['' => 'Select a project'];
        foreach(Project::all() as $project){
            $projectsList[$project->id] = $project->name;
        }
        return view('ticket.edit', ['ticket' => $ticket, 'users' => $usersList, 'projects' => $projectsList, 'statuses' => Ticket::$STATUSES, 'categories' => Ticket::$CATEGORIES, 'priorities' => Ticket::$PRIORITIES, 'estimates' => Ticket::$ESTIMATES]);
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
            'name' => 'required|max:255',
            'category' => 'required',
            'date_start' => 'date|date_format:Y-n-j',
            'date_end' => 'date|date_format:Y-n-j'
        ]);

        $ticket = Ticket::find($id);
        $ticket->update($request->all());

        return redirect()->route('kanban');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        $ticket->destroy($id);

        return redirect()->route('ticket.index');
    }

    public function kanban($refresh = false)
    {
        $users = User::hasAccessToKanban();
        $ticketsBacklog = Ticket::unassigned();
        $tickets = Ticket::assigned();
        $statuses = Ticket::$STATUSES;
        unset($statuses[Ticket::STATUS_BACKLOG]);

        return view('kanban.index', ['ticketsbacklog' => $ticketsBacklog, 'tickets' => $tickets, 'users' => $users, 'statuses' => $statuses, 'refresh' => ($refresh == 'refresh')]);
    }

    public function changeStatusOrUser(Request $request){
        if(\Request::ajax()){
            $ticket = Ticket::find($request['id']);
            if($ticket){
                $ticket->status = $request['status'];
                $ticket->user_id = $request['user'];
                if($ticket->save()){
                    return 1;
                }
            }
            return 0;
        }
    }
}
