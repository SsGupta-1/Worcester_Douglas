<?php
function Activehotels(){
    $totalActive_hotels = App\Models\User::all()->where('is_active',1)->count();
    return  $totalActive_hotels;
}

function Inactivehotels(){
    $totalinactive_hotels = App\Models\User::all()->where('is_active',0)->count();
    return  $totalinactive_hotels;
}

function RevenueAll(){
    $Total_Revenue = App\Models\Subscription::sum('amount');
   
    return $Total_Revenue;
}
?>