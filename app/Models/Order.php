<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['invoice', 'amount', 'status', 'user_id'];

    public function order_details()
    {
        return $this->belongsTo(OrderDetail::class);
    }
}
