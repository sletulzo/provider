<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->unsignedInteger('shipping_cost')->default(0)->after('email_content');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('shipping_cost')->default(0)->after('provider_id');
        });
    }

    public function down(): void
    {
        Schema::table('providers', function (Blueprint $table) {
            if (Schema::hasColumn('providers', 'shipping_cost')) {
                $table->dropColumn('shipping_cost');
            }
        });

        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'shipping_cost')) {
                $table->dropColumn('shipping_cost');
            }
        });
    }
};
