<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('responded_at')->nullable()->after('is_refused');
            $table->text('provider_note')->nullable()->after('responded_at');
        });

        Schema::table('orders_lines', function (Blueprint $table) {
            $table->string('status', 20)->default('pending')->after('quantity');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'responded_at')) {
                $table->dropColumn('responded_at');
            }
            if (Schema::hasColumn('orders', 'provider_note')) {
                $table->dropColumn('provider_note');
            }
        });

        Schema::table('orders_lines', function (Blueprint $table) {
            if (Schema::hasColumn('orders_lines', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
