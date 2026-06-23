<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TABLE = 'push_subscriptions';

    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('subscribable');
            $table->string('endpoint', 500);
            $table->string('public_key')->nullable();
            $table->string('auth_token')->nullable();
            $table->string('content_encoding')->nullable();
            $table->timestamps();
        });

        $connection = Schema::getConnection();

        if ($connection->getDriverName() === 'mysql') {
            $tableName = str_replace('`', '``', $connection->getTablePrefix() . self::TABLE);

            // Index sur préfixe : l'endpoint complet peut dépasser la limite d'index utf8mb4.
            // L'unicité réelle reste garantie par updatePushSubscription/findByEndpoint.
            $connection->statement(
                "ALTER TABLE `{$tableName}` ADD INDEX `push_subscriptions_endpoint_index` (`endpoint`(191))"
            );
        }
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
};
