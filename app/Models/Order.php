<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'total_price', 'status', 
        'customer_name', 'customer_phone', 'shipping_address',
        'subtotal', 'shipping_fee', 'discount_amount', 'voucher_code',
        'payment_method', 'payment_status'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function timelines()
    {
        return $this->hasMany(OrderTimeline::class)->orderBy('created_at', 'desc');
    }
}
