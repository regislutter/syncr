<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Ticket;
use App\User;

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
        $usersList = [0 => 'Select a user'];
        foreach(User::all() as $user){
            $usersList[$user->id] = $user->name;
        }
        return view('ticket.create', ['categories' => Ticket::CATEGORIES, 'priorities' => Ticket::PRIORITIES, 'estimates' => Ticket::ESTIMATES, 'users' => $usersList]);
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
            'user_id' => 'required'
        ]);

        Ticket::create($request->all());

//        $ticket = new Ticket;
//        $ticket->name = $request->input('name');
        return redirect()->route('ticket.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        return view('ticket.edit', ['ticket' => $ticket, 'statuses' => Ticket::STATUSES, 'categories' => Ticket::CATEGORIES, 'priorities' => Ticket::PRIORITIES, 'estimates' => Ticket::ESTIMATES, 'users' => $usersList]);
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
            'user_id' => 'required'
        ]);

        $ticket = Ticket::find($id);
        $ticket->update($request->all());

        return redirect()->route('ticket.show', $id);
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

    public function kanban()
    {
        return view('kanban.index');
    }
}
