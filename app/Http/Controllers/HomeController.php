<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;

use App\Client;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->input('status');
        if(!isset($status)){
            $status = 'all';
        }

        $filesUpdate = \Auth::user()->subscribedFiles($status);
        return view('home', ['filesUpdate' => $filesUpdate, 'status' => $status]);
    }

    public function admin(){
        return view('admin.index');
    }
}
