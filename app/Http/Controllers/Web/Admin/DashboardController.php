<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index():View
    {
        $total_orders = Order::count();
        $total_orders_by_status = Order::with('getStatus')->get()->countBy('getStatus.name');
        $total_revenue = Order::with('getProduct')->whereHas('getStatus',function($query){
            $query->where('name','Delivered');
        })->get()->sum(function($order) {
            return $order->getProduct->price * $order->quantity;
        });
        return view('dashboard.index',compact('total_orders','total_orders_by_status','total_revenue'));
    }
}
