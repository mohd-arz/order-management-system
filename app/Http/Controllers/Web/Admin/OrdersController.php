<?php

namespace App\Http\Controllers\Web\Admin;

use App\Actions\Web\Orders\UpdateOrderAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Orders\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class OrdersController extends Controller
{
    public function index():View
    {
        return view('orders.index');
    }
    public function getOrders(Request $request)
    {
        $orders = Order::orderBy('id','desc')->get();
        return DataTables::of($orders)
        ->addIndexColumn()
        ->addColumn('product',function($row){
            return $row->getProduct->name ?? '-';
        })
        ->addColumn('status',function($row){
            $status = $row->getStatus->name;
            return $status == 'Pending' ? '<span class="badge bg-warning">Pending</span>' : ($status == 'Shipped' ? '<span class="badge bg-success">Shipped</span>' : ($status == 'Cancelled' ? '<span class="badge bg-danger">Cancelled</span>' : '<span class="badge bg-info">Delivered</span>'));
        })
        ->addColumn('ordered_by',function($row){
            return $row->getUser->name ?? '-';
        })
        ->addColumn('ordered_at',function($row){
            return $row->created_at->format('d-m-Y H:i:s');
        })
        ->addColumn('action',function($row){
            return '<a href="'.route('orders.edit',$row->id).'" class="btn btn-primary btn-sm">Edit</a>';
        })
        ->rawColumns(['status','action'])
        ->make(true);
    }
    public function edit(Order $order):View
    {
        $statuses = Status::all();
        return view('orders.edit',compact('order','statuses'));
    }
    public function update(UpdateOrderRequest $request,Order $order,UpdateOrderAction $action)
    {
        $response = $action->execute(collect($request->validated()),$order);
        if($response){
            return response()->json(['success'=>true,'message'=>'Order updated successfully','redirect_url'=>route('orders.index')]);
        }else{
            return response()->json(['success'=>false,'message'=>'Order updated failed']);
        }
    }
}
