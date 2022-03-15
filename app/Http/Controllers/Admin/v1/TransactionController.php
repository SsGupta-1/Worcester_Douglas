<?php

namespace App\Http\Controllers\Admin\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription;

class TransactionController extends Controller
{
    public function index()
    { 
        $subscription =  DB::table('subscriptions')
                            ->leftjoin('users', 'subscriptions.user_id', '=', 'users.id')
                            ->select('subscriptions.*', 'users.hotel_name')
                            ->get();
       return view('admin.transactions.index',compact('subscription'));
    }

    
    public function download(Request $request)
    {
        
        $fileName = 'transections.csv';
        if($request->priceType == 0){
            $subscription =  DB::table('subscriptions')
                                ->leftjoin('users', 'subscriptions.user_id', '=', 'users.id')
                                ->select('subscriptions.*', 'users.hotel_name')
                                ->get();
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );
            $columns = array('Hotel Name', 'Date', 'Time', 'Transection ID', 'Amount');

            $callback = function() use($subscription, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($subscription as $value) {
                    $row['Hotel Name']      = $value->hotel_name;
                    $row['Date']            = date('d-m-Y', strtotime($value->created_at));
                    $row['Time']            = date('H:i:s A', strtotime($value->created_at));
                    $row['Transection ID']  = $value->transection_id;
                    $row['Amount']          = $value->amount;

                    fputcsv($file, array($row['Hotel Name'], $row['Date'], $row['Time'], $row['Transection ID'], $row['Amount']));
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        }else{
            $subscription = DB::table('subscriptions')
                            ->where('subscriptions.price_setting_id',$request->priceType)
                            ->leftjoin('users', 'subscriptions.user_id', '=', 'users.id')
                            ->select('subscriptions.*', 'users.hotel_name')
                            ->get();
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );
            $columns = array('Hotel Name', 'Date', 'Time', 'Transection ID', 'Amount');

            $callback = function() use($subscription, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($subscription as $value) {
                    $row['Hotel Name']      = $value->hotel_name;
                    $row['Date']            = date('d-m-Y', strtotime($value->created_at));
                    $row['Time']            = date('H:i:s A', strtotime($value->created_at));
                    $row['Transection ID']  = $value->transection_id;
                    $row['Amount']          = $value->amount;

                    fputcsv($file, array($row['Hotel Name'], $row['Date'], $row['Time'], $row['Transection ID'], $row['Amount']));
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }
    }
    
    // public function list(Request $request){
       
        
    //     $subscription =  DB::table('subscriptions')
    //                             ->leftjoin('users', 'subscriptions.user_id', '=', 'users.id')
    //                             ->select('subscriptions.*', 'users.hotel_name');
	// 	if(!empty($request->value) || $request->value!=0){
	// 		$subscription =$subscription->where('subscriptions.price_setting_id', $request->value);
	// 	}						
		
	// 	if(!empty($request->searchVal)){
	// 		//echo $request->searchVal; die();
	// 		$subscription =$subscription
	// 					->orWhere('subscriptions.amount', 'LIKE', "%{$request->searchVal}%")
	// 					->orWhere('users.hotel_name', 'LIKE', "%{$request->searchVal}%")
	// 					->orWhere('subscriptions.transection_id', 'LIKE', "%{$request->searchVal}%");
	// 	}
								
    //     $subscription =$subscription->get();
    //     return view('admin.transactions.transactionlist',compact('subscription'));	
    // }

    public function list(Request $request){
        if($request->value == 0){
            $subscription =  DB::table('subscriptions')
                                ->leftjoin('users', 'subscriptions.user_id', '=', 'users.id')
                                ->select('subscriptions.*', 'users.hotel_name')
                                ->get();
        }else{
          $subscription =  DB::table('subscriptions')
                              ->leftjoin('users', 'subscriptions.user_id', '=', 'users.id')
                              ->select('subscriptions.*', 'users.hotel_name')
                              ->where('subscriptions.price_setting_id', $request->value)
                              ->get();
        }
        return view('admin.transactions.transactionlist',compact('subscription'));
    }
}
