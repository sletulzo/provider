<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_types', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('name')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('user_type_id')->default(1)->nullable()->after('tenant_id');
        });

        DB::table('users_types')->insert([
            [
                'slug' => 'customer',
                'name' => 'Client',
                'created_at' => carbon(),
                'updated_at' => carbon(),
            ],
            [
                'slug' => 'provider',
                'name' => 'Fournisseur',
                'created_at' => carbon(),
                'updated_at' => carbon(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'user_type_id')) {
                $table->dropColumn('user_type_id');
            }
        });

        Schema::dropIfExists('users_types');
    }
};
