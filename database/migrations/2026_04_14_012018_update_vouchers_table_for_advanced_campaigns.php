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
        Schema::table('vouchers', function (Blueprint $table) {
            $table->string('type')->default('percent')->after('code');
            $table->decimal('discount_value', 15, 2)->default(0)->after('type');
            $table->decimal('max_discount', 15, 2)->nullable()->after('discount_value');
            $table->boolean('is_for_new_user')->default(false)->after('max_discount');
        });

        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn('discount_percent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn(['type', 'discount_value', 'max_discount', 'is_for_new_user']);
            $table->integer('discount_percent')->after('code');
        });
    }
};
