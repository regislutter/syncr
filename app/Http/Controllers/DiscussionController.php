<?php

namespace App\Http\Controllers;

use App\Copydeck;
use App\Project;
use App\Discussion;
use App\Message;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
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
        //
    }

    public function createProject($projectId){
        return view('discussion.create', ['project' => Project::find($projectId)]);
    }

    public function createCopydeck($projectId, $copydeckId){
        return view('discussion.create', ['project' => Project::find($projectId), 'copydeck' => Copydeck::find($copydeckId)]);
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

    public function storeProject($projectId, Request $request){
        $this->validate($request, [
            'title' => 'required|max:255',
            'tinycontent' => 'required',
        ]);

        $discussion = new Discussion;
        $discussion->title = $request->input('title');
        $discussion->project_id = $projectId;
        $discussion->user_id = Auth::user()->id;
        $discussion->save();

        $message = new Message;
        $message->content = $request->input('tinycontent');
        $message->discussion_id = $discussion->id;
        $message->user_id = Auth::user()->id;
        $message->save();

        return redirect()->route('discussion.show', $discussion->id);
    }

    public function storeCopydeck($projectId, $copydeckId, Request $request){
        $this->validate($request, [
            'title' => 'required|max:255',
            'tinycontent' => 'required',
        ]);

        $discussion = new Discussion;
        $discussion->title = $request->input('title');
        $discussion->project_id = $projectId;
        $discussion->copydeck_id = $copydeckId;
        $discussion->user_id = Auth::user()->id;
        $discussion->save();

        $message = new Message;
        $message->content = $request->input('tinycontent');
        $message->discussion_id = $discussion->id;
        $message->user_id = Auth::user()->id;
        $message->save();

        return redirect()->route('discussion.show', $discussion->id);
    }

    // Create message

    public function createMessage($discussionId){
        return view('discussion.message.create', ['discussion' => Discussion::find($discussionId)]);
    }

    public function storeMessage($discussionId, Request $request){
        $this->validate($request, [
            'tinycontent' => 'required',
        ]);

        $message = new Message;
        $message->content = $request->input('tinycontent');
        $message->discussion_id = $discussionId;
        $message->user_id = Auth::user()->id;
        $message->save();

        return redirect()->route('discussion.show', $discussionId);
    }

    // Respond to message

    public function createResponse($discussionId, $messageId){
        return view('discussion.message.respond', ['discussion' => Discussion::find($discussionId), 'message' => Message::find($messageId)]);
    }

    public function storeResponse($discussionId, $messageId, Request $request){
        $this->validate($request, [
            'tinycontent' => 'required',
        ]);

        $message = new Message;
        $message->content = $request->input('tinycontent');
        $message->discussion_id = $discussionId;
        $message->message_id = $messageId;
        $message->user_id = Auth::user()->id;
        $message->save();

        return redirect()->route('discussion.show', $discussionId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('discussion.show', ['discussion' => Discussion::find($id)]);
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
        //
    }
}
