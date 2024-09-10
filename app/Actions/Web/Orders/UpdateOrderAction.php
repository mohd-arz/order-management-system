<?php
namespace App\Actions\Web\Orders;

use App\Models\Order;
use App\Models\Status;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UpdateOrderAction{
  public function execute(Collection $collection,Order $order)
  {
    try{
      DB::beginTransaction();
      $status_id = $collection->get('status_id');
      $status = Status::find($status_id);
      $order->canceled_by = null;
      if($status->name == 'Cancelled'){
        $order->canceled_by = auth()->user()->id;
      }
      $order->status_id = $status_id;
      $order->save();
      DB::commit();
      return true;
    }catch(\Throwable $th){
      info($th);
      DB::rollBack();
      return false;
    }
  }
}