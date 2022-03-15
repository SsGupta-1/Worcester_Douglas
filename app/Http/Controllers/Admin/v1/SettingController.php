<?php

namespace App\Http\Controllers\Admin\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Toastr;
use App\Models\PriceSetting;

class SettingController extends Controller
{
    public function index()
    {
        $data['priceSettings'] = PriceSetting::all();
        return view('admin.setting.index', $data);
    }
    public function update(Request $request)
    {
        
        $input = $request->all();
        foreach($input['price_type'] as $key => $priceTypeVal){
            if($key == 0){
                for($i = 0; $i < count($request->weekId); $i++){
                    $query1 = PriceSetting::where('id', '=', $input['weekId'][$i])->first();
                    $query1->rang            = $input['rangWeek'][$i];
                    $query1->price_extension = isset($input['priceExtensionWeek'][$i]) ? $input['priceExtensionWeek'][$i] : '';
                    $query1->created_by      = auth()->user()->id;
                    $result= $query1->save();
                
                }
               
            }
            
            if($key == 1){
                for($i = 0; $i < count($request->monthId); $i++){
                    $query1 = PriceSetting::where('id', '=', $input['monthId'][$i])->first();
                    $query1->rang            = $input['rangMonth'][$i];
                    $query1->price_extension = isset($input['priceExtensionMonth'][$i]) ? $input['priceExtensionMonth'][$i] : '';
                    $query1->created_by      = auth()->user()->id;
                    $result= $query1->save();
                
                }
                
            }
           
            if($key == 2){
                for($i = 0; $i < count($request->annualId); $i++){
                    $query1 = PriceSetting::where('id', '=', $input['annualId'][$i])->first();
                    $query1->rang            = $input['rangAnnual'][$i];
                    $query1->price_extension = isset($input['priceExtensionAnnual'][$i]) ? $input['priceExtensionAnnual'][$i] : '';
                    $query1->created_by      = auth()->user()->id;
                    $result= $query1->save();
                
                }
                
            }

        }
        
    
        Toastr::success('Price Setting Updated Successfully', 'Success', ['timeOut' => 5000]);
        return redirect()->back();
    }
}
