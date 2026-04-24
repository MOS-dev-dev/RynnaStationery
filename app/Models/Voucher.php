<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'type', 'discount_value', 'max_discount', 'min_order_value', 'usage_limit', 'used_count', 'is_for_new_user', 'expires_at'
    ];
}
