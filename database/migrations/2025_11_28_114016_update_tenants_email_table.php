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
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('smtp_email')->nullable()->after('name');
            $table->text('smtp_password')->nullable()->after('smtp_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            if (Schema::hasColumn('tenants', 'smtp_email')) {
                $table->dropColumn('smtp_email');
            }
            
            if (Schema::hasColumn('tenants', 'smtp_password')) {
                $table->dropColumn('smtp_password');
            }
        });
    }
};
