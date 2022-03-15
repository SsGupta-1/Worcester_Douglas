<?php
namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserDevice;
use Validator;
use Carbon\Carbon;
use Hash;
use Session;
use Helper;
use Config;
use Image;
class AuthController extends Controller
{

    /*******************Sign up ***************/
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'   => 'required|min:1|max:70',
            'email'  => 'required|unique:users',
            'mobile' => 'required|unique:users',
            'dob'    => 'required',
            'gender' => 'required',
            'device_token' => 'required',
            'device_type' => 'required',
        ]);

        if ($validator->fails())
        {
            $errors = $validator->errors()->getMessages();
            $transformed = [];
            foreach ($errors as $field => $messages)
            {
                $transformed[$field] = $messages[0];
            }
            $result['data']=$transformed;
            return response()->json(
                [
                    'response_code' => 400,
                    'status' => 0,
                    'message' => 'Validation Error',
                    'result' =>$result
                ],
                200
            );
        }
        try
        {
            $data['name']             = strip_tags(trim($request->name));
            $data['mobile']           = strip_tags(trim($request->mobile));
            $data['email']            = strip_tags(trim($request->email));
            $data['dob']              = strip_tags(trim($request->dob));
            $data['gender']           = strip_tags(trim($request->gender));
            $data['image']            = 'avatar.png';
            $data['role_id']          = Config::get('constants.roles.Customer');

            $device['device_token']   = strip_tags(trim($request->device_token));
            $device['device_type']    = strip_tags(trim($request->device_type)); //1=ios, 0=android

            $user                     = User::create($data);
            $user_id                  = $user->id;
            /* Here call the otp function */
            $otp                      = $this->createOtp();
            User::where('id',$user_id)->update(['otp'=>$otp]);

            if(!empty($user_id))
            {
                $device['user_id']       = $user_id;
                $user_device             =UserDevice::create($device);
                $token                   = $user->createToken('authToken')->accessToken;
                $result['token']         = $token;
                $result['user_id']       = $user->id;
                $result['name']          = $user->name;
                $result['email']         = $user->email;
                $result['mobile']        = $user->mobile;
                $result['otp']           = $otp;
                $result['gender']        = $user->gender;
                $result['device_token']  = $user_device->device_token;
                $result['device_type']   = $user_device->device_type;
                $result['image']         = (isset($user->image)) ? url('/uploads/users').'/'.$user->image : asset('assets/avatar.png');
                $result['created_at']    = $user->created_at;

                return response()->json(['result' => $result,'message'=>"User Registered Successfully",'response_code' => 200], 200);   
            }
            else
            {
                return response()->json(['message' => 'Something went wrong','status' => 0,'response_code' => 500],200);
            }

        }
        catch (Exception $e)
        {
            return \Response::json(['error'=> ['message'=>$e->getMessdob()]], HttpResponse::HTTP_CONFLICT)->setCallback(Input::get('callback'));
        }
    }

    /******************* create Otp *******************/ 
    public function createOtp()
    {
        $digits     = 4;
        $otp_digits = rand(pow(10, $digits - 1) , pow(10, $digits) - 1);
        return $otp_digits;
    }

    /***************** Resend Otp *****************/

    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'user_id'   => 'required'
        ]);

        if ($validator->fails())
        {
            $errors = $validator->errors()->getMessages();
            $transformed = [];
            foreach ($errors as $field => $messages)
            {
                $transformed[$field] = $messages[0];
            }
            $result['data']=$transformed;
            return response()->json(
                [
                    'response_code' => 400,
                    'message' => 'Validation Error',
                    'result' =>$result
                ],
                200
            );
        }
        try
        {
            $user_id          = strip_tags(trim($request->user_id));

            $user_details    = User::where('id',$user_id);

            if(($user_details->count()) > 0)
            {
                /* Here call the otp function */
                $otp                      = $this->createOtp();
                User::where('id',$user_id)->update(['otp'=>$otp]);

                $result['otp'] =  $otp;
                $result['mobile']= $user_details->first()->mobile;

                return response()->json(['otp' => $otp,'message'=>"OTP Sends Successfully",'status'=>1,'response_code' => 200], 200);   
            }
            else
            {
                return response()->json(['result' =>'','message'=>"User Not Registered",'response_code' => 204], 200);
            }
        }
        catch (Exception $e)
        {
            return \Response::json(['error'=> ['message'=>$e->getMessdob()]], HttpResponse::HTTP_CONFLICT)->setCallback(Input::get('callback'));
        }
    }

    /*******************Verify Otp *****************/

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'user_id'    => 'required',
            'otp'     => 'required'
        ]);
        if($validator->fails())
        {
            $result['data'] = $validator->errors();
            return response()->json(
                [
                    'response_code' => 400,
                    'status' => 0,
                    'message' => 'Validation Error',
                    'result' =>$result
                ],
                200
            );
        }
        else
        {
            try
            {
                $user_id = strip_tags(trim($request->user_id));
                $otp =     strip_tags(trim($request->otp));
                $user =    User::where('id',$user_id)->first();
                if($user)
                {
                    $result = array();
                    $response = array();
                    if ($user->otp  == $otp)
                    {

                        $user->is_verified = 1;
                        $user->save();
                        $token             = $user->createToken('authToken')->accessToken;
                        $result['user_id'] = $user->id;
                        $result['name']    = $user->name;
                        $result['mobile']  = $user->mobile;
                        $result['role']    = $user->role_id;
                        $result['email']   = $user->email;
                        $result['image']   = (isset($user->image)) ? url('/uploads/users').'/'.$user->image : asset('assets/avatar.png');
                        $response['data'] = $result;

                        return response()->json(['token'=>$token,'result'=>$response,'message'=>"OTP verified successfully",'response_code' => 200], 200);
                    }
                    else
                    {
                        return response()->json(['message'=>"Wrong OTP",'response_code' => 401], 200);
                    }
                }
                else
                {
                    return response()->json(['message'=>"اUser does not exists",'status'=>0,'response_code' => 300], 200);
                }
            }
            catch (Exception $e)
            {
                return \Response::json(['error'=> ['message'=>$e->getMessdob()]], HttpResponse::HTTP_CONFLICT)->setCallback(Input::get('callback'));
            }
        }
    }


    /*******************Login  ***************/

    public function login(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'mobile' => 'required',
                'device_token' => 'required',
                'device_type' => 'required',
                'type'=>'required'
            ]);

            if ($validator->fails())
            {
                $errors = $validator->errors()->getMessages();
                $transformed = [];
                foreach ($errors as $field => $messages) {
                    $transformed[$field] = $messages[0];
                }
                $result['data']=$transformed;
                return response()->json(
                    [
                        'response_code' => 400,
                        'message' => 'Validation Error',
                        'result'  =>$result
                    ],
                    200
                );
            }

            // Parameters
            $mobile                  =  $request->get("mobile");
            $device['device_token']   = strip_tags(trim($request->device_token));
            $device['device_type']    = strip_tags(trim($request->device_type)); //1=ios, 0=android

            $detail        =  User::where('mobile',$mobile);
            $user_check    =  $detail->count();

            $type =$request->type;
            if($type == '1')
            {
                if($user_check > 0)
                {
                    $user    = $detail->where('is_active',1)->first();

                    if($user->is_active == 0)
                    {
                        return response()->json(['message'=>'Your Account is Inactive,Please contact to Adminstrator','response_code'=>403],200);
                    }
                    if(!empty($user->deleted_at))
                    {
                        return response()->json(['message'=>'Your Account is deactivated,Please contact to Adminstrator','response_code'=>404],200);
                    }

                    $otp                     = $this->createOtp();
                    $user->otp = $otp;
                    $user->save();

                    $device['user_id']       = $user->id;
                    $user_device             = UserDevice::create($device);
                    $token                   = $user->createToken('authToken')->accessToken;
                    $result['token']         = $token;
                    $result['user_id']       = $user->id;
                    $result['name']          = $user->name;
                    $result['email']         = $user->email;
                    $result['mobile']        = $user->mobile;
                    $result['otp']           = $otp;
                    $result['gender']        = $user->gender;
                    $result['device_token']  = $user_device->device_token;
                    $result['device_type']   = $user_device->device_type;
                    $result['image']         = (isset($user->image)) ? url('/uploads/users').'/'.$user->image : asset('assets/avatar.png');
                    $result['is_active']     =$user->is_active;
                    $result['created_at']    = $user->created_at;

            

                    return response()->json(['result' => $result,'message'=>"Login  Successfully",'response_code' => 200], 200);
                }
                else
                {
                 return response()->json(['message' => 'This Mobile Number is not exist,Please signup first.','status' => 0,'response_code' => 204],200); 
                }
            }
            else
            {
                $user_check    =  $detail->count();
                if($user_check > 0)
                {
                    return response()->json(['message' => 'This Number is already used ','status' => 0,'response_code' => 400],200); 

                }
                else
                {

                    $user = new User;
                    $user->role_id =Config::get('constants.roles.Customer');
                    $user->mobile=strip_tags(trim($request->mobile));
                    $user->image='avatar.jpg';
                    $user->save();

                    $user_id                  = $user->id;
                    /* Here call the otp function */
                    $otp                      = $this->createOtp();
                    User::where('id',$user_id)->update(['otp'=>$otp]);

                    if(!empty($user_id))
                    {
                        $device['user_id']       = $user_id;
                        $user_device             =UserDevice::create($device);
                        $token                   = $user->createToken('authToken')->accessToken;
                        $result['token']         = $token;
                        $result['user_id']       = $user->id;
                        $result['name']          = $user->name;
                        $result['email']         = $user->email;
                        $result['mobile']        = $user->mobile;
                        $result['otp']           = $otp;
                        $result['gender']        = $user->gender;
                        $result['device_token']  = $user_device->device_token;
                        $result['device_type']   = $user_device->device_type;
                        $result['image']         = (isset($user->image)) ? url('/uploads/users').'/'.$user->image : asset('assets/avatar.png');
                        $result['created_at']    = $user->created_at;

                        return response()->json(['result' => $result,'message'=>"Guest User  Registered Successfully",'response_code' => 200], 200);   
                    }

                }


            }

           
        }
        catch(Exception $e)
        {
            return Response::json(["line" => $e->getLine(), "msg" => $e->getMessage()], 500); 
        }
    }

    /*****************Logout ****************/

    public function logout(Request $request)
    {
        try
        {
            $user_id = auth('api')->user()->id;

            // Device type and ID will be deleted
            $userdevices = UserDevice::where(['user_id' => $user_id, 'status' => 1])->update(['status' => 2]);

            auth('api')->user()->token()->revoke();

            return response()->json(['message' => "User Logged Out Successfully.",'status'=>1, 'response_code' => 200], 200);
        }
        catch (Exception $e)
        {
            return \Response::json(['error'=> ['message'=>$e->getMessdob()]], HttpResponse::HTTP_CONFLICT)->setCallback(Input::get('callback'));
        }
    }


    /**************Profile details************/

    public function profileDetails(Request $request)
    {
        try
        {
            $user = auth('api')->user();
            if($user)
            {
                $result['user_id']     =   $user->id;
                $result['name']        =   $user->name;
                $result['email']       =   $user->email;
                $result['role']        =   $user->role_id;
                $result['mobile']      =   $user->mobile;
                $result['dob']         =   $user->dob;
                $result['gender']      =   $user->gender;
                $result['image']       =    (isset($user->image)) ? url('/uploads/users').'/'.$user->image : asset('assets/avatar.png');

                return response()->json(['result'=>$result,'message' => 'User Profiles fetched successfully.','response_code'=>200], 200);
            }
            else
            {
                return \Response::json(['message' => 'No User found','response_code'=>300,], 200);
            }
        }
        catch (Exception $e)
        {
            return \Response::json(['error'=> ['message'=>$e->getMessdob()]], HttpResponse::HTTP_CONFLICT)->setCallback(Input::get('callback'));
        }
    }

    /*******************Update Profile ***********/

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'   => 'required|min:1|max:70',
            'email'  => 'required',
            'mobile' => 'required',
            'dob'    => 'required',
            'gender' => 'required',
            'image'=>'sometimes|nullable'
        ]);

        if ($validator->fails())
        {
            $errors = $validator->errors()->getMessages();
            $transformed = [];
            foreach ($errors as $field => $messages)
            {
                $transformed[$field] = $messages[0];
            }
            $result['data']=$transformed;
            return response()->json(
                [
                    'response_code' => 400,
                    'message' => 'Validation Error',
                    'result' => $result
                ],
                200
            );
        }
        try
        {
            $user_id                  = auth('api')->user()->id;
            $data['name']             = strip_tags(trim($request->name));
            $data['mobile']           = strip_tags(trim($request->mobile));
            $data['email']            = strip_tags(trim($request->email));
            $data['dob']              = strip_tags(trim($request->dob));
            $data['gender']           = strip_tags(trim($request->gender));

            if($request->hasFile('image'))
            {
                $image_tmp =$request->file('image');
                if($image_tmp->isValid())
                {
                    $extension =$image_tmp->getClientOriginalExtension();
                    $filename =md5(time()).'.'.$extension;
                    $image_path = 'uploads/users/'.$filename;
                    //store images in images folder
                    Image::make($image_tmp)->save($image_path); 

                    $data['image']     =$filename;
                }
            }
            else
            {
                $data['image']     ='avatar.png';
            }

            User::findOrFail($user_id)->update($data);
            if(!empty($user_id))
            {
                $user = User::find($user_id);
                $result                  = array();
                $response                = array();
                $result['user_id']       = $user->id;
                $result['name']          = $user->name;
                $result['email']         = $user->email;
                $result['mobile']        = $user->mobile;
                $result['gender']        = $user->gender;
                $result['image']         = (isset($user->image)) ? url('/uploads/users').'/'.$user->image : asset('assets/avatar.png');
                $response                = $result;
                return response()->json(['result' => $response,'message'=>"User Profile Update Successfully",'response_code' => 200], 200);   
            }
            else
            {
                return response()->json(['message' => 'Something went wrong','status' => 0,'response_code' => 500],200);
            }

        }
        catch (Exception $e)
        {
            return \Response::json(['error'=> ['message'=>$e->getMessdob()]], HttpResponse::HTTP_CONFLICT)->setCallback(Input::get('callback'));
        }
    }

}