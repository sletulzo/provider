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
            $table->integer('tenant_id')->nullable()->after('id');
        });

        Schema::table('providers', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after('id');
        });
        
        Schema::table('unities', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after('id');
        }); 
        
        Schema::table('orders_waiting', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after('id');
        });
        
        Schema::table('orders_lines', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after('id');
        });
        
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('tenant_id')->nullable()->after('id');
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
            if (Schema::hasColumn('products', 'tenant_id')) {
                $table->dropColumn('tenant_id');
            }
        });
        
        Schema::table('providers', function (Blueprint $table) {
            if (Schema::hasColumn('providers', 'tenant_id')) {
                $table->dropColumn('tenant_id');
            }
        });
        
        Schema::table('unities', function (Blueprint $table) {
            if (Schema::hasColumn('unities', 'tenant_id')) {
                $table->dropColumn('tenant_id');
            }
        });
        
        Schema::table('orders_waiting', function (Blueprint $table) {
            if (Schema::hasColumn('orders_waiting', 'tenant_id')) {
                $table->dropColumn('tenant_id');
            }
        });
        
        Schema::table('orders_lines', function (Blueprint $table) {
            if (Schema::hasColumn('orders_lines', 'tenant_id')) {
                $table->dropColumn('tenant_id');
            }
        });
        
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'tenant_id')) {
                $table->dropColumn('tenant_id');
            }
        });
    }
};
