<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Hash;
use Session;
use Helper;
use Config;
use Image;
use Auth;
use App\Models\User;
use App\Models\UserCard;
use App\Models\UserAddress;
use App\Models\Country;


class UserController extends Controller
{


    /**************Add Cards **************/
    public function listCard(Request $request)
    {
        try
        {

            $user_id = auth('api')->user()->id;
            $list_card = UserCard::where(['user_id' => $user_id, 'status' => 1])->get();
            $response = array();

            if(count($list_card) > 0)
            {
                 
                $response[]= $list_card;
                
                return response()->json(['result' => $response,'message'=>"Card list get successfully",'response_code' => 200], 200);   
            }
            else
            {
                return response()->json(['result' => $response,'message' => 'Card not Found','response_code' => 204],200);
            }
        }
        catch (Exception $e)
        {
            return \Response::json(['error'=> ['message'=>$e->getMessdob()]], HttpResponse::HTTP_CONFLICT)->setCallback(Input::get('callback'));
        }
    }
    /**************Add Cards **************/
    public function addCard(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'card_holder'   => 'required|min:1|max:70',
            'card_number'  => 'required|unique:user_cards',
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
            $data['user_id']               = auth('api')->user()->id;
            $data['card_holder']           = strip_tags(trim($request->card_holder));
            $data['card_number']           = strip_tags(trim($request->card_number));

            $card                     = UserCard::create($data);
            $card_id                  = $card->id;

            if(!empty($card_id))
            {
                $result['card_id']         = $card->id;
                $result['card_holder']     = $card->card_holder;
                $result['card_number']     = $card->card_number;
                $result['created_at']      = $card->created_at;

                return response()->json(['result' => $result,'message'=>"Card Added Successfully",'response_code' => 200], 200);   
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

    /*************** Add Address *********/
    public function addAddress(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name'   => 'required|min:1|max:70',
            'last_name'  => 'required|min:1|max:70',
            'country_id'=>'required',
            'city'=>'required',
            'street_no'=>'required',
            'building_no'=>'required',
            'mobile'=>'required',
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
            $data['user_id']               = auth('api')->user()->id;
            $data['first_name']            = strip_tags(trim($request->first_name));
            $data['last_name']             = strip_tags(trim($request->last_name));
            $data['city']                  = strip_tags(trim($request->city));
            $data['country_id']            = strip_tags(trim($request->country_id));
            $data['street_no']             = strip_tags(trim($request->street_no));
            $data['building_no']           = strip_tags(trim($request->building_no));
            $data['mobile']                = strip_tags(trim($request->mobile));

            $address                       = UserAddress::create($data);
            $address_id                    = $address->id;

            if(!empty($address_id))
            {

                $result['address_id']      = $address->id;
                $result['first_name']      = $address->first_name;
                $result['last_name']       = $address->last_name;
                $result['city']            = $address->city;
                $result['country_id']      = $address->country_id;
                $result['street_no']       = $address->street_no;
                $result['building_no']     = $address->building_no;
                $result['mobile_no']       = $address->mobile_no;
                $result['created_at']      = $address->created_at;

                return response()->json(['result' => $result,'message'=>"User Address Added Successfully",'response_code' => 200], 200);   
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

    /***************List Address ***********/
    public function listAddress(Request $request)
    {
        try
        {

            $user_id                            = auth('api')->user()->id;
            $list_address                       = UserAddress::where(['user_id' => $user_id, 'status' => 1])->get();
            $response                           = array();

            if(count($list_address) > 0)
            {

                foreach($list_address as $address)
                {
                    $result['address_id']      = $address->id;
                    $result['first_name']      = $address->first_name;
                    $result['last_name']       = $address->last_name;
                    $result['city']            = $address->city;
                    $result['country_id']      = $address->country_id;
                    $result['street_no']       = $address->street_no;
                    $result['building_no']     = $address->building_no;
                    $result['mobile']          = $address->mobile;
                    $result['created_at']      = $address->created_at;
                    $response[]                = $result;

                }

                return response()->json(['result' => $response,'message'=>"User Address Added Successfully",'response_code' => 200], 200);   
            }
            else
            {
                return response()->json(['result' => $response,'message' => 'Address not Found','response_code' => 204],200);
            }

        }
        catch (Exception $e)
        {
            return \Response::json(['error'=> ['message'=>$e->getMessdob()]], HttpResponse::HTTP_CONFLICT)->setCallback(Input::get('callback'));
        }
    }

    /***************Delete Address ***********/

    public function deleteAddress(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'address_id'=>'required'
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
            $user_id                       = auth('api')->user()->id;
            $address_id                    = strip_tags(trim($request->address_id));

            $address                       = UserAddress::where(['user_id'=>$user_id,'id'=>$address_id])->update(['status' => 2]);

            if(!empty($address))
            {
                return response()->json(['message'=>"Address deleted Successfully",'response_code' => 200], 200);   
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

    /******************Update Address **********/
    public function updateAddress(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|min:1|max:70',
            'last_name' => 'required|min:1|max:70',
            'country_id' => 'required',
            'city' => 'required',
            'street_no' => 'required',
            'building_no' => 'required',
            'mobile' => 'required',
            'address_id' => 'required'
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

            $data['user_id']               = auth('api')->user()->id;
            $data['first_name']            = strip_tags(trim($request->first_name));
            $data['last_name']             = strip_tags(trim($request->last_name));
            $data['city']                  = strip_tags(trim($request->city));
            $data['country_id']            = strip_tags(trim($request->country_id));
            $data['street_no']             = strip_tags(trim($request->street_no));
            $data['building_no']           = strip_tags(trim($request->building_no));
            $data['mobile']                = strip_tags(trim($request->mobile));

            $address_id                    = $request->address_id;
            $address                       = UserAddress::find($address_id);

            if(!empty($address))
            {
                $address->update($data);

                $result['address_id']      = $address->id;
                $result['first_name']      = $address->first_name;
                $result['last_name']       = $address->last_name;
                $result['city']            = $address->city;
                $result['country_id']      = $address->country_id;
                $result['street_no']       = $address->street_no;
                $result['building_no']     = $address->building_no;
                $result['mobile_no']       = $address->mobile;
                $result['updated_at']      = $address->updated_at;

                return response()->json(['result' => $result,'message'=>"User Address Updated Successfully",'response_code' => 200], 200);   
            }
            else
            {
                return response()->json(['message' => 'Incorrect address id','status' => 0,'response_code' => 400],200);
            }

        }
        catch (Exception $e)
        {
            return \Response::json(['error'=> ['message'=>$e->getMessdob()]], HttpResponse::HTTP_CONFLICT)->setCallback(Input::get('callback'));
        }
    }

}