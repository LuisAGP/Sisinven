<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\OrderDetail;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }

}
