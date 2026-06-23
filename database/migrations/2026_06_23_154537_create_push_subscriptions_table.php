<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('webpush.database_connection'))->create(config('webpush.table_name'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('subscribable');
            $table->string('endpoint', 500);
            $table->string('public_key')->nullable();
            $table->string('auth_token')->nullable();
            $table->string('content_encoding')->nullable();
            $table->timestamps();
        });

        // Index sur préfixe : l'endpoint complet dépasse la limite d'index utf8mb4 (1000 octets).
        // L'unicité réelle est garantie au niveau applicatif (findByEndpoint).
        $connection = config('webpush.database_connection');
        if (Schema::connection($connection)->getConnection()->getDriverName() === 'mysql') {
            $tableName = config('webpush.table_name');
            Schema::connection($connection)
                ->getConnection()
                ->statement("ALTER TABLE `{$tableName}` ADD INDEX `push_subscriptions_endpoint_index` (`endpoint`(191))");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('webpush.database_connection'))->dropIfExists(config('webpush.table_name'));
    }
}
