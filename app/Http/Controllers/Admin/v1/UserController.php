<?php

namespace App\Http\Controllers\Admin\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Country;
use Validator;
use Toastr;
use Config;
use Session;
use Cache;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role_id', Config::get('constants.roles.Customer'))
            ->whereIn('is_active', [Config::get('constants.status.Active'), Config::get('constants.status.Inactive')])
            ->orderby('name', 'ASC')
            ->get();

        if ($users->count()) {
            for ($i=0; $i < $users->count(); $i++) { 
                $address = UserAddress::where(['user_id' => $users[$i]['id'], 'status' => Config::get('constants.status.Active')])->first();
                if($address){
                    $users[$i]['address'] = $address['street_no'].", ".$address['city'];
                }else{
                    $users[$i]['address'] = "";
                }
            }
        }

        $data['list'] = $users;

        return view('admin.user.index', $data);
    }

    public function add(Request $request)
    {
        if($request->isMethod('post')) {
            $validator = Validator::make($request->all(),[
                'name'   => 'required|min:1|max:70',
                'email'  => ['required', 'email', Rule::unique('users')->where(function ($query) use ($request) { return $query->whereIn('is_active', [Config::get('constants.status.Active'), Config::get('constants.status.Inactive')])->where('email', $request->email); })],
                'mobile' => ['required', Rule::unique('users')->where(function ($query) use ($request) { return $query->whereIn('is_active', [Config::get('constants.status.Active'), Config::get('constants.status.Inactive')])->where('mobile', $request->mobile); })],
                'dob'    => 'required',
                'gender' => 'required'
            ]);

            if ($validator->fails())
            {
                $messages = $validator->messages();
                foreach ($messages->all() as $message)
                {
                    Toastr::error($message, 'Failed', ['timeOut' => 5000]);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $addr = array();
            if ($request->country_id || $request->city || $request->street_no || $request->building_no) {
                $validator = Validator::make($request->all(),[
                    'city'   => 'required|min:1|max:70',
                    'street_no'  => 'required',
                    'building_no' => 'required',
                    'country_id' => 'required'
                ]);

                if ($validator->fails())
                {
                    $messages = $validator->messages();
                    foreach ($messages->all() as $message)
                    {
                        Toastr::error($message, 'Failed', ['timeOut' => 5000]);
                    }
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $addr['first_name'] = $request->name;
                $addr['country_id'] = $request->country_id;
                $addr['city'] = $request->city;
                $addr['street_no'] = $request->street_no;
                $addr['building_no'] = $request->building_no;
                $addr['mobile'] = $request->mobile;
                $addr['country_id'] = $request->country_id;
                $addr['status'] = Config::get('constants.status.Active');
            }

            $data['name']             = strip_tags(trim($request->name));
            $data['mobile']           = strip_tags(trim($request->mobile));
            $data['email']            = strip_tags(trim($request->email));
            $data['dob']              = strip_tags(trim($request->dob));
            $data['gender']           = strip_tags(trim($request->gender));
            $data['image']            = 'avatar.png';
            $data['role_id']          = Config::get('constants.roles.Customer');

            $user                     = User::create($data);
            $user_id                  = $user->id;

            if(count($addr) > 0){
                $addr['user_id'] = $user_id;

                UserAddress::create($addr);
            }

            Toastr::success('User Created Successfully', 'Success', ['timeOut' => 5000]);
            return redirect('admin/user/view/'.$user_id);
        } else {
            $data['country'] = Country::select('id', 'country_name')->get();
            return view('admin.user.add', $data);
        }
    }

    public function edit(Request $request, $id)
    {
        if($request->isMethod('post')) {
            $validator = Validator::make($request->all(),[
                'name'   => 'required|min:1|max:70',
                'email'  => ['required', 'email', Rule::unique('users')->where(function ($query) use ($request) { return $query->where('id', '!=', $request->id)->whereIn('is_active', [Config::get('constants.status.Active'), Config::get('constants.status.Inactive')])->where('email', $request->email); })],
                'mobile'  => ['required', Rule::unique('users')->where(function ($query) use ($request) { return $query->where('id', '!=', $request->id)->whereIn('is_active', [Config::get('constants.status.Active'), Config::get('constants.status.Inactive')])->where('mobile', $request->mobile); })],
                'dob'    => 'required',
                'gender' => 'required'
            ]);

            if ($validator->fails())
            {
                $messages = $validator->messages();
                foreach ($messages->all() as $message)
                {
                    Toastr::error($message, 'Failed', ['timeOut' => 5000]);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $addr = array();
            if ($request->country_id || $request->city || $request->street_no || $request->building_no) {
                $validator = Validator::make($request->all(),[
                    'city'   => 'required|min:1|max:70',
                    'street_no'  => 'required',
                    'building_no' => 'required',
                    'country_id' => 'required'
                ]);

                if ($validator->fails())
                {
                    $messages = $validator->messages();
                    foreach ($messages->all() as $message)
                    {
                        Toastr::error($message, 'Failed', ['timeOut' => 5000]);
                    }
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                if ($request->address_id != "") {
                    $addr = UserAddress::where('id', '=', $request->address_id)->first();

                    $addr->first_name = $request->name;
                    $addr->country_id = $request->country_id;
                    $addr->city = $request->city;
                    $addr->street_no = $request->street_no;
                    $addr->building_no = $request->building_no;
                    $addr->mobile = $request->mobile;
                    $addr->country_id = $request->country_id;

                    $addr->save();
                }else{
                    $addr['first_name'] = $request->name;
                    $addr['country_id'] = $request->country_id;
                    $addr['city'] = $request->city;
                    $addr['street_no'] = $request->street_no;
                    $addr['building_no'] = $request->building_no;
                    $addr['mobile'] = $request->mobile;
                    $addr['country_id'] = $request->country_id;
                    $addr['user_id'] = $id;

                    UserAddress::create($addr);
                }
            }

            $user = User::where('id', '=', $id)->first();

            $user->name             = strip_tags(trim($request->name));
            $user->mobile           = strip_tags(trim($request->mobile));
            $user->email            = strip_tags(trim($request->email));
            $user->dob              = strip_tags(trim($request->dob));
            $user->gender           = strip_tags(trim($request->gender));
            $user->image            = 'avatar.png';
            $user->role_id          = Config::get('constants.roles.Customer');

            $user->save();

            Toastr::success('User Updated Successfully', 'Success', ['timeOut' => 5000]);
            return redirect('admin/user/edit/'.$user_id);
        } else {
            $data['country'] = Country::select('id', 'country_name')->get();
            $data['user'] = User::where('id', $id)->first();
            $data['address'] = UserAddress::select('user_addresses.*', 'countries.country_name')->leftjoin('countries', 'user_addresses.country_id', '=', 'countries.id')->where(['user_id' => $id, 'status' => Config::get('constants.status.Active')])->first();
            return view('admin.user.edit', $data);
        }
    }

    public function view(Request $request, $id)
    {
        $data['user'] = User::where('id', $id)->first();
        $data['address'] = UserAddress::select('user_addresses.*', 'countries.country_name')->leftjoin('countries', 'user_addresses.country_id', '=', 'countries.id')->where(['user_id' => $id, 'status' => Config::get('constants.status.Active')])->first();

        return view('admin.user.view', $data);
    }

    public function delete(Request $request, $id)
    {
        $user = User::where('id', '=', $id)->first();

        $user->is_active = Config::get('constants.status.Deleted');

        $user->save();

        Toastr::success('User Deleted Successfully', 'Success', ['timeOut' => 5000]);
        return redirect('admin/users');
    }
}
