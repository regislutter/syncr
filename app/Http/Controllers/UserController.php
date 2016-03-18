<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Hash;
use Snowfire\Beautymail\Beautymail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        $roles = Role::all();
        return view('user.index', ['users' => $users, 'roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create', ['roles' => Role::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate user data
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'title' => 'max:255',
            'phone' => 'digits:10',
            'phonepost' => 'digits:3',
            'avatar' => 'max:512|image'
        ]);

        $avatar = $request->file('avatar');
        if (isset($avatar) && $avatar->isValid()) {
            $fileName = 'user'.$id.'.'.$avatar->getClientOriginalExtension();
            $request->file('avatar')->move('./../public/images/users', $fileName);
        }

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->title = $request->input('title');
        $user->phone = $request->input('phone');
        $user->password = Hash::make('W0nd3rfu1TempPassword');
        $user->phonepost = $request->input('phonepost');
        $user->hobbies = $request->input('hobbies');
        if(isset($fileName)){
            $user->avatar = $fileName;
        }
        $user->save();
        $user->roles()->sync($request->get('roles'));

        // Send email to user
        $this->welcomeMail($user);

        return redirect()->route('admin.users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('user.show', ['user' => User::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('user.edit', ['user' => User::find($id), 'roles' => Role::all()]);
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
            'email' => 'required|email',
            'title' => 'max:255',
            'phone' => 'digits:10',
            'phonepost' => 'digits:3',
            'avatar' => 'max:512|image'
        ]);

        $avatar = $request->file('avatar');
        if (isset($avatar) && $avatar->isValid()) {
            $fileName = 'user'.$id.'.'.$avatar->getClientOriginalExtension();
            $request->file('avatar')->move('./../public/images/users', $fileName);
        }

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->title = $request->input('title');
        $user->phone = $request->input('phone');
        $user->phonepost = $request->input('phonepost');
        $user->hobbies = $request->input('hobbies');
        if(isset($fileName)){
            $user->avatar = $fileName;
        }

        $user->save();
        $user->roles()->sync($request->get('roles'));

        return redirect()->route('admin.users');
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

    /**
     * Send an e-mail reminder to the user.
     *
     * @param  User  $user
     * @return Response
     */
    public function welcomeMail($user)
    {
        $beautymail = app()->make(Beautymail::class);
        $beautymail->send('mails.user.welcome', ['user' => $user], function($message) use ($user)
        {
            $message
//                ->from('syncr@lemieuxbedard.com')
                ->from('regis.lutter@gmail.com')
                ->to($user->email, $user->name)
                ->subject('Welcome on Syncr!');
        });
    }

    /**
     * Send an e-mail reminder to the user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
//    public function sendEmailReminder(Request $request, $id)
//    {
//        $user = User::findOrFail($id);
//
//        Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
//            $m->from('hello@app.com', 'Your Application');
//
//            $m->to($user->email, $user->name)->subject('Your Reminder!');
//        });
//    }
}
