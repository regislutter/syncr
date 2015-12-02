<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Client;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ClientController extends Controller
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
    public function create()
    {
        return view('clients.create');
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
            'name' => 'required|unique:clients|max:255',
        ]);

        $client = new Client;
        $client->name = $request->input('name');
        $client->save();

        return redirect('admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('clients.show', ['client' => Client::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('clients.edit', ['client' => Client::find($id)]);
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
            'name' => 'required|unique:clients|max:255',
        ]);

        $client = Client::find($id);
        $client->name = $request->input('name');
        $client->save();

        return redirect()->route('client.show', $id);
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
            Client::destroy($id);
            return response(['msg' => 'Client deleted', 'status' => 'success']);
        }
    }

    /**
     * Archive the client, it will appear anymore
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function archive($id){
        $client = Client::find($id);
        $client->archived = 1;
        $client->save();

        return redirect()->route('admin.clients');
    }

    /**
     * Republish the client
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function publish($id){
        $client = Client::find($id);
        $client->archived = 0;
        $client->save();

        return redirect()->route('admin.clients');
    }
}
