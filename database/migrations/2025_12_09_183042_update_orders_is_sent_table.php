<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_sent')->default(false)->after('user_id');
            $table->boolean('is_accepted')->default(false)->after('is_sent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'is_sent')) {
                $table->dropColumn('is_sent');
            }
            
            if (Schema::hasColumn('orders', 'is_accepted')) {
                $table->dropColumn('is_accepted');
            }
        });
    }
};
