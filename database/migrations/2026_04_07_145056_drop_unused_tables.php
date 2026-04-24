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
        Schema::dropIfExists('articles');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('wishlists');
        Schema::dropIfExists('product_imports');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Re-creating tables is complex, but we can leave it empty or minimal for this scope.
        // It's a cleanup migration.
    }
};
