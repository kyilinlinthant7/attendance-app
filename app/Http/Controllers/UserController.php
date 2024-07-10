<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use App\Models\Employee;
use App\LoginUser;
use Validator;
use Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addUser()
    {
        $emps = Employee::pluck('name','id');
        return view('hrms.users.add', compact('emps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveUser(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            'name' =>'required',
            'role'=>'required',
            'password' =>'required',
        ]);

        if($validator->fails()){
            \Session::flash('flash_message', 'Name And Password Are Required');
            return redirect()->back();
        }
        
         $datas=LoginUser::where('emp_id',$request->name)->first();

        if($datas) {
            \Session::flash('flash_message', 'User Already Exist');
            return redirect()->back();
        } else {
            $emps = Employee::where('id',$request->name)->select('name')->first();   
            $user = LoginUser::create([
                'emp_id'=>$request->name,
                'role'=>$request->role,
                'default_password' =>Hash::make($request->password),
                'email'=>$emps->name
            ]);

            \Session::flash('flash_message', 'User successfully added!');
            return redirect()->back();
        }
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function listUser()
    {
         $users=LoginUser::orderby('id','DESC')->paginate(15);

        return view('hrms.users.list', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        $emps = Employee::pluck('name','id'); //for select option
        $users = LoginUser::findOrFail($id); //for update id
        $user =Employee::where('id',$users->emp_id)->select('name','id')->first(); //for selectbox value

        return view('hrms.users.edit', compact('emps','users','user'));
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
        $user = LoginUser::findOrFail($id);
        $emps=Employee::where('id',$request->name)->select('name')->first();
        $user->update([
            'emp_id'=>$request->name,
            'role'=>$request->role,
            'default_password' =>Hash::make($request->password),
            'email'=>$emps->name
        ]);

        \Session::flash('flash_message', 'User successfully updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       LoginUser::destroy($id);

       \Session::flash('flash_message', 'User successfully Deleted!');
        return redirect()->back();
    }

    public function randomPass(){
        $pass = str_random(8);
        log::info($pass);
        $emps = Employee::pluck('name','id');
        return view('hrms.users.add', compact('pass','emps'));
    }
}
