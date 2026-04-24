<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal', 15, 2)->after('user_id')->nullable();
            $table->decimal('shipping_fee', 15, 2)->after('subtotal')->default(0);
            $table->decimal('discount_amount', 15, 2)->after('shipping_fee')->default(0);
            $table->string('voucher_code')->after('discount_amount')->nullable();
        });

        if (Schema::hasColumn('orders', 'customer_address')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->renameColumn('customer_address', 'shipping_address');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'shipping_fee', 'discount_amount', 'voucher_code']);
            
            if (Schema::hasColumn('orders', 'shipping_address')) {
                $table->renameColumn('shipping_address', 'customer_address');
            }
        });
    }
};
