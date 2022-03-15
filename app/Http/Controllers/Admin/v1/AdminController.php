<?php

namespace App\Http\Controllers\Admin\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription;
use Validator;
use Toastr;
use Config;
use Session;
use Cache;

use function PHPSTORM_META\map;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $data['monthWiseHotels'] = $this->totalHotelMonthWise();
        $data['monthWiseRevenue'] = $this->revenueMonthWise();

        return view('admin.dashboard', $data);
    }

    private function totalHotelMonthWise(){
        $period = now()->subMonths(11)->monthsUntil(now());
		//print_r($period); die();
        $month = [];
        $dataCount = [];
        $no = 0;
        foreach ($period as $date)
        {			
            if ($no == 12) {
                $no++;
                continue;
            }
            $coutHotel=  User::whereYear('created_at',$date->year)
              ->whereMonth('created_at', $date->month)
              ->count();
			  
            $month[] = $date->shortMonthName.'-'.$date->year;
            $dataCount[] = $coutHotel;
            $no++;
        }
		
        return ['month'=>$month,'dataCount'=>$dataCount]; 
    }

    private function revenueMonthWise(){
        $period = now()->subMonths(11)->monthsUntil(now());
        $month = [];
        $monthRevenue = [];
        $no = 0;
        foreach ($period as $date)
        {
            if ($no == 12) {
                $no++;
                continue;
            }
            $coutHotel=  Subscription::whereYear('created_at', '=', $date->year)
              ->whereMonth('created_at', '=', $date->month)
              ->value(DB::raw('SUM(amount)'));
            $monthRevenue[] = !empty($coutHotel) ? $coutHotel : 0;
            $no++;
        }
        return ['monthlyRevenue'=>$monthRevenue];
    }
}
