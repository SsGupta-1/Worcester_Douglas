<?php

namespace App\Http\Controllers\Admin\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Subscription;
use Toastr;
use Carbon\Carbon;

class HotelController extends Controller
{
    public function index()
    {
        $details = User::all();
        return view('admin.hotel.manage-hotel',compact('details'));
    }


    public function view(Request $request, $id)
    {
        $result       = User::find($id); 
        $transDetails = Subscription::where('user_id',$id)->get();
        //dd($transDetails);
        $billingInfo  = Subscription::where('user_id',$id)->orderBy('created_at', 'desc')->first();
       
        $days = (isset($billingInfo->price_setting_id) && $billingInfo->price_setting_id == 1) ? "7" : ((isset($billingInfo->price_setting_id) && $billingInfo->price_setting_id == 2)  ? "30" : "360");
            $next = Carbon::now();
            isset( $billingInfo) ? $billingInfo->next_due_date =  $billingInfo->created_at->addDays($days) : $next;
        return view('admin.hotel.view-hotel',compact('result','transDetails', 'billingInfo'));
    }

    public function deletehotel(Request $request, $id){

       // dd($request->id);
        $deletehotel = User::where('id', $id)->delete();    
        Toastr::success('Hotel deleted successfully', 'Success', ['timeOut' => 5000]); 
        return redirect('admin/manage-hotel');
  
    }

    public function deactivate(Request $request, $id){
        $Activation = User::find($id);
        if($Activation->is_active == 1){
            $Activation->is_active = 0;
        }else{
            $Activation->is_active = 1;
        }

        $Activation->save();
        Toastr::success('Hotel Status update successfully', 'Success', ['timeOut' => 5000]);
        return back();
    }

    public function deleted(Request $request){
       
        $deletehotel = User::where('id', $request->id);    
        $deletehotel->delete();
        Toastr::success('Hotel deleted successfully', 'Success', ['timeOut' => 5000]); 
        return redirect('admin/manage-hotel');

    }

    
}
