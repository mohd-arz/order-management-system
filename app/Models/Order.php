<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function getProduct()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function getUser()
    {
        return $this->belongsTo(User::class,'ordered_by');
    }
    public function getStatus()
    {
        return $this->belongsTo(Status::class,'status_id');
    }
}
