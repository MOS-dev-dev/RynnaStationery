<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTimeline extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'title', 'description'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
