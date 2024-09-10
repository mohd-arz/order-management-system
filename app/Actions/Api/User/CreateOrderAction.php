<?php

namespace App\Actions\Api\User;

use App\Models\Order;
use App\Models\Status;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreateOrderAction{
  public function execute(Collection $collection){
    try{
      DB::beginTransaction();
      $status = Status::where('name','Pending')->first();
      if(!$status){
        throw new Exception('Status not found');
      }
      $product_ids = $collection['product_id'];
      $quantities = $collection['quantity'];

      foreach($product_ids as $key => $p_id){
        $order = new Order();
        $order->order_no = $p_id.'/'.auth()->user()->id.'/'.Carbon::parse(now())->format('YmdHis');
        $order->product_id = $p_id;
        $order->quantity = $quantities[$key];
        $order->status_id = $status->id;
        $order->ordered_by = auth()->user()->id;
        $order->save();
      }
      DB::commit();
      return true;
    }catch(Throwable $th){
      info($th);
      DB::rollback();
      return false;
    }
  }
}
