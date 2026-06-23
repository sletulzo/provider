<?php

return [

    /**
     * These are the keys for authentication (VAPID).
     * These keys must be safely stored and should not change.
     */
    'vapid' => [
        'subject' => env('VAPID_SUBJECT', env('APP_URL')),
        'public_key' => env('VAPID_PUBLIC_KEY'),
        'private_key' => env('VAPID_PRIVATE_KEY'),
        'pem_file' => env('VAPID_PEM_FILE'),
    ],

    /**
     * This is model that will be used to for push subscriptions.
     */
    'model' => \NotificationChannels\WebPush\PushSubscription::class,

    /**
     * Table used by the PushSubscription model shipped with this package.
     * Keep this in sync with the local migration.
     */
    'table_name' => 'push_subscriptions',

    /**
     * Use Laravel's default database connection. The migration intentionally
     * does not depend on this config value.
     */
    'database_connection' => null,

    /**
     * The Guzzle client options used by Minishlink\WebPush.
     */
    'client_options' => [],

    /**
     * Google Cloud Messaging.
     *
     * @deprecated
     */
    'gcm' => [
        'key' => env('GCM_KEY'),
        'sender_id' => env('GCM_SENDER_ID'),
    ],

];
