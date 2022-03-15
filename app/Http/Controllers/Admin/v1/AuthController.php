<?php

namespace App\Http\Controllers\Admin\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;
use Toastr;
use Config;
use Session;
use Cache;
use Mail;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        
        if($request->isMethod('post'))
        {
            $validator = Validator::make($request->all(),[
                'email'      => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                'password'   =>'required',
            ],

            [
                'email.required'    => 'Please enter email.',
                
                'password.required'    => 'Please enter password.',
            ]
        );

        if ($validator->fails())
        {
            $messages = $validator->messages();
            foreach ($messages->all() as $message)
            {
                Toastr::error($message, 'Failed', ['timeOut' => 5000]);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }else {
                $cred['email'] = $request->email;
                $cred['password'] = $request->password;
                $cred['role_id'] = Config::get('constants.roles.SuperAdmin');
                $userData = User::where('email', $request->email)->first();
                
                if($userData == null){
                    Toastr::error('Email is not registered with us', 'Error', ['timeOut' => 5000]);
                    return redirect()->back()->withInput();
                }
                if(!(Hash::check(request('password'), $userData->password))){
                    Toastr::error('Your password is incorrect', 'Error', ['timeOut' => 5000]);
                    return redirect()->back()->withInput();
                }
                if (Auth::attempt($cred))
                {
                    // Toastr::success('Login Successfully', 'Success', ['timeOut' => 5000]);
                    return redirect('admin/dashboard');
                }
                else
                {
                    Toastr::error('Invalid crediantials', 'Error', ['timeOut' => 5000]);
                    return redirect()->back();
                }

            }
        }
        
        return view('admin.auth.login');
    }

    /********************Logout *************************/
    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        Cache::flush();
        return redirect('/admin');
    }

    /*******************Forgot Pasword**********************/
    public function forgotPassword(Request $request)
    {
        if($request->isMethod('post'))
        {
            $validator = Validator::make($request->all(),[
                    'email'=>'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                ],
                [
                    'email.required'    => 'Please enter your email id.',
                    
                ]
            );

            if ($validator->fails())
            {
                $messages = $validator->messages();
                foreach ($messages->all() as $message)
                {
                    Toastr::error($message, 'Failed', ['timeOut' => 5000]);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }
           
            $email = $request->email;
            $count = User::where(['email' => $email,'role_id'=>Config::get('constants.roles.SuperAdmin')])->count();
           
            if ($count > 0)
            { 
                $user                = User::where('email',$email)->first();
                
                /* Here call the otp function */
                $otp                 = $this->createOtp();

                /* Set up the  email data */

                $data                = ['otp' => $otp, 'user_name' => $user->name, 'email' => $user->email];
                $view                = 'mail.send_otp';
                $subject             = 'Forgot Password OTP';

                /* Send Mail */
                try
                {
                    Mail::send($view, $data, function($message) use ($data,$subject) {
                        $message->to($data['email'])->subject($subject.' | Worcester Team');
                    });
                }
                catch(Exception $e)
                {
                    return $e->getMessage();
                }

                User::where('email', $email)->update(['otp'=>$otp, 'is_verified'=>0, 'email_verified_at'=>date('Y-m-d H:i:s')]);
                Session::put('session_email', $email);
                Session::put('user_id', $user->id);
                Toastr::success('OTP is sent to registered email', 'Success', ['timeOut' => 5000]);
                return redirect('admin/verify-otp');
            }
            else
            {
                Toastr::error('The email is not registered!', 'Error', ['timeOut' => 5000]);

                return redirect()->back();
            }

        }else{
            return view('admin.auth.forgot');
        }
    }

    /******************* create Otp *******************/ 
    public function createOtp()
    {
        $digits     = 6;
        $otp_digits = rand(pow(10, $digits - 1) , pow(10, $digits) - 1);
        
        return $otp_digits;
    }

    /*******************Verify Otp**********************/
    public function verifyOtp(Request $request)
    {
        if($request->isMethod('post'))
        {
            $validator = Validator::make($request->all(),[
                'email' => 'required',
                ]
            );

            if ($validator->fails())
            {
                $messages = $validator->messages();
                foreach ($messages->all() as $message)
                {
                    Toastr::error($message, 'Failed', ['timeOut' => 5000]);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $email               = $request->get('email');
            $otp                 = $request->otp;
            $string              = implode("", $request->otp);

            $user_details        = User::where(['email' => $email, 'is_active' => 1])->first();
            
            if($string == $user_details->otp)
            {
                if ($user_details->email_verified_at < date('Y-m-d H:i:s', strtotime('-10 minutes'))) {
                    Toastr::error('OTP Expired!', 'Error', ['timeOut' => 5000]);
                    return redirect('admin/verify-otp');
                }
                User::where('email',$email)->update(['otp' => $string, 'is_verified' => 1]);
                Toastr::success('OTP verified Successfully', 'Success', ['timeOut' => 5000]); 

                Session::put('session_email', $email);
                Session::put('user_id', $user_details->id);

                return redirect('admin/change-password');
            }
            else
            {
                Toastr::error('Incorrect OTP', 'Error', ['timeOut' => 5000]);
                return redirect('admin/verify-otp');
            }
        }
        else
        {
            return view('admin.auth.forgototp');
        }
    }

    /*******************Resend Otp**********************/
    public function resendOtp(Request $request)
    {
        $email = Session::get('session_email');

        $count = User::where(['email' => $email,'role_id'=>Config::get('constants.roles.SuperAdmin')])->count();
            
        if ($count > 0)
        { 
            $user                = User::where('email',$email)->first();

            /* Here call the otp function */
            $otp                 = $this->createOtp();

            /* Set up the  email data */

            $data                = ['otp' => $otp, 'user_name' => $user->name, 'email' => $user->email];
            $view                = 'mail.send_otp';
            $subject             = 'Forgot Password OTP';

            /* Send Mail */
            try
            {
                Mail::send($view, $data, function($message) use ($data,$subject) {
                    $message->to($data['email'])->subject($subject.' |  Worcester Team');
                });
            }
            catch(Exception $e)
            {
                return $e->getMessage();
            }

            User::where('email', $email)->update(['otp' => $otp, 'is_verified' => 0, 'email_verified_at'=>date('Y-m-d H:i:s')]);
            Session::put('session_email', $email);
            Session::put('user_id', $user->id);
            Toastr::success('OTP is sent to registered email', 'Success', ['timeOut' => 5000]);
            return redirect('admin/verify-otp');
        }
        else
        {
            Toastr::success('Invalid Email', 'Error', ['timeOut' => 5000]);

            return redirect()->back();
        }
    }


    /*******************Change Pasword**********************/
    public function changePassword(Request $request)
    {
        if($request->isMethod('post'))
        {
            
            $validator = Validator::make($request->all(),[
                    'email'=>'required',
                    'new_password'=>'required',
                    'confirm_password'=>'required|same:new_password'

                ],
                [
                    'new_password.required'    => 'Please enter your new password',
                    'confirm_password.required'     => 'Please enter confirm password',

                ]
            );
            
            if ($validator->fails())
            { 
                $messages = $validator->messages();
                foreach ($messages->all() as $message)
                {
                    
                    Toastr::error($message, 'Failed', ['timeOut' => 5000]);
                }
                
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $email = $request->email;
            $new_password = $request->new_password;
            
            User::where(['email' => $email, 'role_id' => Config::get('constants.roles.SuperAdmin')])->update(['password' => bcrypt($new_password)]);
            Toastr::success('Password changes successfully.','Success');
            return view('admin.auth.password_reset_success');
        }
        return view('admin.auth.resetpassword');
    }

    /*******************profile update password**********************/
    public function updatePassword(Request $request){

        $validator = Validator::make($request->all(),[
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'confirm_password' => ['required','same:new_password'],
        ]);
        
        if ($validator->fails())
        { 
            $messages = $validator->messages();
            foreach ($messages->all() as $message)
            {

            }
            return response()->json(['status' => 400,'message'=>$validator->errors()->all()]);
            // return response()->json(['status' => 400, 'message'=>'Something has wrong']);
        }
        
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        Toastr::success('Password change successfully.', 'Success', ['timeOut' => 5000]);
        Auth::logout();
        return response()->json(['status' => 200, 'message'=>'Password change successfully.']);
        
       
    }
}
