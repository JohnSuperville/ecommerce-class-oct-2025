<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('points_exchanged')->after('billing_address_id')->default(0);
            $table->integer('points_discount_applied')->after('points_exchanged')->default(0);
            $table->integer('points_gained')->after('points_discount_applied')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
