<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('price')->nullable()->after('quantity_min');
        });
        
        Schema::table('orders_waiting', function (Blueprint $table) {
            $table->bigInteger('price')->nullable()->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'price')) {
                $table->dropColumn('price');
            }
        });
        
        Schema::table('orders_waiting', function (Blueprint $table) {
            if (Schema::hasColumn('orders_waiting', 'price')) {
                $table->dropColumn('price');
            }
        });
    }
};
