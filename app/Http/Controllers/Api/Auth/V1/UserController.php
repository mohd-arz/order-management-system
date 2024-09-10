<?php

namespace App\Http\Controllers\Api\Auth\V1;

use App\Actions\Api\User\CreateOrderAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\CreateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getProducts(){
        $products = Product::orderBy('id','desc')->get();
        return response()->json([
            'data'=>ProductResource::collection($products)
        ]);
    }
    public function createOrders(CreateOrderRequest $request,CreateOrderAction $action){
        $response = $action->execute(collect($request->validated()));
        if ($response) {
            return response()->json([
                'message' => 'Order placed successfully!',
            ]);
        }
        return response()->json([
            'message' => 'Something went wrong!',
        ], 500);
    }

    public function getOrders(){
        $orders = Order::where('ordered_by',auth()->user()->id)->get();
        return response()->json([
            'data'=>OrderResource::collection($orders)
        ]);
    }
}
