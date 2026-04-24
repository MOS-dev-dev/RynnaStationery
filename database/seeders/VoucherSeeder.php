<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voucher;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Xoá voucher cũ để tạo mới (tránh trùng lặp nếu chạy nhiều lần)
        Voucher::truncate();

        $vouchers = [
            [
                'code' => 'FREESHIP150',
                'type' => 'freeship',
                'discount_value' => 30000, // phí ship giả định
                'max_discount' => 30000,
                'min_order_value' => 150000,
                'usage_limit' => 100,
                'used_count' => 0,
                'is_for_new_user' => 0,
                'expires_at' => now()->addDays(30),
            ],
            [
                'code' => 'SALE10',
                'type' => 'percent',
                'discount_value' => 10,
                'max_discount' => 50000,
                'min_order_value' => 300000,
                'usage_limit' => 100,
                'used_count' => 0,
                'is_for_new_user' => 0,
                'expires_at' => now()->addDays(30),
            ],
            [
                'code' => 'SALE20',
                'type' => 'percent',
                'discount_value' => 20,
                'max_discount' => 100000,
                'min_order_value' => 500000,
                'usage_limit' => 50,
                'used_count' => 0,
                'is_for_new_user' => 0,
                'expires_at' => now()->addDays(30),
            ],
            [
                'code' => 'VIP150K',
                'type' => 'amount',
                'discount_value' => 150000,
                'max_discount' => 150000,
                'min_order_value' => 1000000,
                'usage_limit' => 20,
                'used_count' => 0,
                'is_for_new_user' => 0,
                'expires_at' => now()->addDays(30),
            ],
            [
                'code' => 'WELCOME50K',
                'type' => 'amount',
                'discount_value' => 50000,
                'max_discount' => 50000,
                'min_order_value' => 0, // Dành cho người mới, không yêu cầu TT tối thiểu
                'usage_limit' => 1000,
                'used_count' => 0,
                'is_for_new_user' => 1,
                'expires_at' => now()->addDays(365),
            ]
        ];

        foreach ($vouchers as $v) {
            Voucher::create($v);
        }
    }
}
