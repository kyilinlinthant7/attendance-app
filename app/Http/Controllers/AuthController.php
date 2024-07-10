<?php

    namespace App\Http\Controllers;

    use App\Models\Event;
    use App\Models\Meeting;
    use App\Models\Role;
    use App\User;
    use App\LoginUser;
    use App\Models\Employee;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Contracts\Mail\Mailer;
    use App\Http\Requests;
    use Illuminate\Support\Facades\Hash;
    use Log;
    use Validator;
    use App\Models\AttendanceFilename;
    use App\Models\LeaveApply;
    use App\OverTime;

    class AuthController extends Controller
    {
        public function __construct(Mailer $mailer)
        {
            $this->mailer = $mailer;
        }

        public function showLogin()
        {
            return view('hrms.auth.login');
        }

        public function doLogin(Request $request)
        {

            
            $validator = Validator::make($request->all(),[
                'email' =>'required',
                'password' =>'required',
            ]);
    
            if($validator->fails()) {
                Session::flash('class', 'alert-danger');
                \Session::flash('message', 'Hi');
            }
            
            $name = $request->email;
            $password = $request->password;
            
            log::info($name);
            log::info($password);
        
            $users = Employee::select('id','name')->get();
    
            $i = 0;
            $data = [];
            foreach ($users as $user) {
                $data[$i] = $user->name;
                $i++;
            }

            if (in_array($name, $data)) {

                foreach ($users as $user) {
                    
                    if ($user->name == $name) {
                        
                        log::info($user->name);
                        $users = User::where('emp_id', $user->id)->first();
                        
                        log::info($users);

                        if ($users) {

                            if (\Auth::attempt(['email' => $name, 'default_password' => $password])) {
                                if (Hash::check($password,$users->default_password)) {
                                    return redirect()->to('welcome');
                                } elseif (Hash::check($password,$users->updated_password)) {
                                    return redirect()->to('welcome');  
                                } else {
                                    \Session::put('class','alert-danger');
                                    \Session::put('message','User Name And password does not match!');
                                    return redirect()->intended('/logout');
                                }
                            } else {
                                \Session::flash('class', 'alert-danger');
                                \Session::flash('message', 'User Name And password does not match!');
                                return redirect()->to('/');
                            }
                        } else {     
                            \Session::flash('class', 'alert-danger');
                            \Session::flash('message', 'User does not have');
                            return redirect()->to('/');
                        }
                    }
                }
            } elseif ($name == "Administrator") {
                if (\Auth::attempt(['email' => $name, 'default_password' => $password])) {
                    $check_user = User::where('id', 1)->first();
                    log::info($check_user);
                    if (\Hash::check($password,$check_user->default_password)) {
                        return redirect()->to('welcome');
                    } elseif (\Hash::check($password,$check_user->updated_password)) {
                        return redirect()->to('welcome');  
                    } else {
                        \Session::put('class','alert-success');
                        \Session::put('message','User Name And password!');
                        return redirect()->intended('/logout');
                    }
                } else {
                    \Session::flash('class', 'alert-success');
                    \Session::flash('message', '2User Name And password does not match!');
                    return redirect()->to('/');
                }
            } else {
                \Session::flash('class', 'alert-danger');
                \Session::flash('message', 'User account does not have!');
                return redirect()->to('/');
            }
        }

        public function doLogout()
        {
            \Auth::logout();

            return redirect()->to('/');
        }

        public function dashboard()
        {
            $events   = $this->convertToArray(Event::where('date', '>', Carbon::now())->orderBy('date', 'desc')->take(3)->get());
            $meetings = $this->convertToArray(Meeting::where('date', '>', Carbon::now())->orderBy('date', 'desc')->take(3)->get());
            
            $totalAttendance = AttendanceFilename::count();
            $totalLeaves = LeaveApply::count();
            $totalAbsence =LeaveApply::where('leave_type', 'Absent')->count();
            $totalManpowers = Employee::count();
            
            // overtime hours calculate
            $overtimeRecords = OverTime::all();
            $overtimeNormalRecords = OverTime::where('ot_type', 0)->get();
            $overtimeDayoffRecords = OverTime::where('ot_type', 1)->get();
            $overtimeHolidayRecords = OverTime::where('ot_type', 2)->get();
            $totalOvertimeHours = 0;
            $totalNormalOvertimeHours = 0;
            $totalDayoffOvertimeHours = 0;
            $totalHolidayOvertimeHours = 0;
            
            // total OT
            foreach ($overtimeRecords as $overtime) {
                $fromTime = Carbon::parse($overtime->fromtime);
                $toTime = Carbon::parse($overtime->totime);
                $overtimeHours = $toTime->diffInHours($fromTime);
                $totalOvertimeHours += $overtimeHours;
            }
            
            // normal OT
            foreach ($overtimeNormalRecords as $overtime) {
                $fromTime = Carbon::parse($overtime->fromtime);
                $toTime = Carbon::parse($overtime->totime);
                $overtimeHours = $toTime->diffInHours($fromTime);
                $totalNormalOvertimeHours += $overtimeHours;
            }
            
            // dayoff OT
            foreach ($overtimeDayoffRecords as $overtime) {
                $fromTime = Carbon::parse($overtime->fromtime);
                $toTime = Carbon::parse($overtime->totime);
                $overtimeHours = $toTime->diffInHours($fromTime);
                $totalDayoffOvertimeHours += $overtimeHours;
            }
            
            // public holiday OT
            foreach ($overtimeHolidayRecords as $overtime) {
                $fromTime = Carbon::parse($overtime->fromtime);
                $toTime = Carbon::parse($overtime->totime);
                $overtimeHours = $toTime->diffInHours($fromTime);
                $totalHolidayOvertimeHours += $overtimeHours;
            }
            
            $totalResigns = Employee::where('status', 'Resign')->count();

            return view('hrms.dashboard', compact('events', 'meetings', 'totalAttendance', 'totalLeaves', 'totalAbsence', 'totalManpowers', 'totalOvertimeHours', 'totalNormalOvertimeHours', 'totalDayoffOvertimeHours', 'totalHolidayOvertimeHours', 'totalResigns'));
        }

        public function welcome()
        {
            return view('hrms.auth.welcome');
        }


        public function notFound()
        {
            return view('hrms.auth.not_found');
        }

        public function showRegister()
        {
            return view('hrms.auth.register');
        }

        public function doRegister(Request $request)
        {
            return view('hrms.auth.register');
        }

        public function calendar()
        {
            return view('hrms.auth.calendar');
        }

        public function changePassword()
        {
            return view('hrms.auth.change');
        }

        public function processPasswordChange(Request $request)
        {
            $password = $request->old;
            $user     = User::where('id', \Auth::user()->id)->first();

            log::info($user->default_password);

            if (Hash::check($password, $user->default_password)) {
                $user->updated_password = Hash::make($request->new);
                $user->save();
                \Auth::logout();
                \Session::flash('class', 'alert-success');
                \Session::flash('message', 'Password updated! LOGIN again with updated password.');
                return redirect()->to('/');

            }elseif(Hash::check($password, $user->updated_password)){
                $user->updated_password=Hash::make($request->new);

                $user->save();
                \Auth::logout();

                \Session::flash('class', 'alert-success');
                \Session::flash('message', 'Password updated! LOGIN again with updated password.');
                return redirect()->to('/');
            } else {
                \Auth::logout();
                \Session::flash('class', 'alert-danger');
                \Session::flash('message', 'The supplied password does not matches with the one we have in records');
                return redirect()->to('/');
                
            }
        }

        public function resetPassword()
        {
            return view('hrms.auth.reset');
        }

        public function processPasswordReset(Request $request)
        {
            $email = $request->email;
            $user  = User::where('email', $email)->first();

            if ($user) {
                $string = strtolower(str_random(6));


                $this->mailer->send('hrms.auth.reset_password', ['user' => $user, 'string' => $string], function ($message) use ($user) {
                    $message->from('no-reply@dipi-ip.com', 'Digital IP Insights');
                    $message->to($user->email, $user->name)->subject('Your new password');
                });

                \DB::table('users')->where('email', $email)->update(['password' => bcrypt($string)]);

                return redirect()->to('/')->with('message', 'Login with your new password received on your email');
            } else {
                return redirect()->to('/')->with('message', 'Your email is not registered');
            }

        }

        public function convertToArray($values)
        {
            $result = [];
            foreach ($values as $key => $value) {
                $result[$key] = $value;
            }
            return $result;
        }

    }
