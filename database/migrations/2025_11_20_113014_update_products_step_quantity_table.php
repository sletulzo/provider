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
            $table->integer('quantity_min')->nullable()->after('name');
            $table->integer('quantity_step')->nullable()->after('name');
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
            if (Schema::hasColumn('products', 'quantity_min')) {
                $table->dropColumn('quantity_min');
            }
            if (Schema::hasColumn('products', 'quantity_step')) {
                $table->dropColumn('quantity_step');
            }
        });
    }
};
