<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vinkla\Pusher\Facades\Pusher;
use Session;
use App\User;
use App\Models\Team;
use App\Convarsation;
use App\Http\Requests;

class ConversationsController extends Controller
{
    
	public function conversation()
	{
		$user_id = auth()->user()->id;
		$user  =  User::find($user_id);

		$role = $user->role;
		$role_arr = array(3,7,9,15,26,30,36,38,40);

		if(in_array($role->role_id, $role_arr)){
			$teams = Team::where('manager_id',$user_id)->select('name','team_id')->get();
		// }elseif($role->role_id == 5){
		// 	$teams = Team::where('leader_id',$user_id)->select('name','team_id')->get();
		}else{
			$teams = Team::where('member_id',$user_id)->select('name','team_id')->get();
		}

		$groups = $teams->unique('team_id');

		return view('hrms.conversations.show_conversation',compact('groups'));
	}

	public function conversationauth(Request $request)
	{
		$user_name = auth()->user()->name;
		$user_id = auth()->user()->id;
		$user  =  User::find($user_id);

		$role = $user->role;

		$role_arr = array(3,7,9,15,26,30,36,38,40);

		if(in_array($role->role_id, $role_arr)){
			$teams = Team::where('manager_id',$user_id)->select('team_id')->first();
		// }elseif($role->role_id == 5){
		// 	$teams = Team::where('leader_id',$user_id)->select('team_id')->first();
		}else{
			$teams = Team::where('member_id',$user_id)->select('team_id')->first();
		}


		if ($request->isMethod('post')) 
		{
			$user_data = array('user_id' => $user,'name' => $user_name,'team'=> $teams->team_id);
    		return Pusher::presence_auth($request->channel_name, $request->socket_id, $user_id, $user_data);
    	}
    	else
    	{
    		return redirect('/');	
    	}
	}

	public function set_message(Request $request)
	{
		$conversation = new Convarsation;
		$conversation->message = $request->message;
		$conversation->user_id = $request->user_id;
		$conversation->team_id = $request->team_id;
		$conversation->save();

		return "true";
	}

	public function get_message(Request $request)
	{
		$conversations = Convarsation::where('convarsations.team_id',$request->team_id)
									->join('users','convarsations.user_id','=','users.id')
									->select('convarsations.*','users.name')
									->get();
		return $conversations;
	}

	public function get_member(Request $request)
	{
		$users = Team::where('team_id',$request->team_id)->select('manager_id','member_id')->get();
		foreach($users as $user){
			$member[] = $user->manager_id;
			$member[] = $user->member_id;
		}

		$members = array_unique($member);

		foreach($members as $mem)
		{
			$user = User::find($mem);
			$userr[]  = array(
				'name' 	=> $user->name,
				'id' 	=> $user->id

			);
		}

		return $userr;
	}

}
