<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Vinkla\Pusher\Facades\Pusher;
use Session;

class ChatController extends Controller
{

    public function chat()
    {
     	return view('chat');
    }

     public function auth(Request $request)
    {
    	Session::flush();
		$request->session()->put('name', 'Lin Ko');
		$request->session()->put('user_id', time());


		if ($request->session()->has('name') && $request->isMethod('post')) 
		{
			$user_data = array('name' => $request->session()->get('name'));
			$user_id = $request->session()->get('user_id');
    		return Pusher::presence_auth($request->channel_name, $request->socket_id, $user_id, $user_data);
    	}
    	else
    	{
    		return redirect('/');	
    	}
    }
}
