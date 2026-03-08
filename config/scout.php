<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Scout Driver
    |--------------------------------------------------------------------------
    |
    | This option controls which search driver will be used by Scout when
    | indexing and searching models. By default, we support database
    | driver which uses traditional LIKE queries.
    |
    */
    'driver' => env('SCOUT_DRIVER', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Index Prefix
    |--------------------------------------------------------------------------
    |
    | Here you may specify a prefix that will be applied to all search index
    | names used by Scout. This prefix may be useful if you have multiple
    | "Scout" indexed databases and wish to avoid naming collisions.
    |
    */
    'prefix' => env('SCOUT_PREFIX', ''),

    /*
    |--------------------------------------------------------------------------
    | Queue Data Syncing
    |--------------------------------------------------------------------------
    |
    | This option allows you to control if the operations that sync your
    | models into your search indexes are queued. This greatly improves
    | the performance of applications by allowing a single job to
    | handle any number of model syncs in a single process.
    |
    */
    'queue' => env('SCOUT_QUEUE', false),

    /*
    |--------------------------------------------------------------------------
    | Database Syncing
    |--------------------------------------------------------------------------
    |
    | These configuration options determine how models are synchronized
    | with your search indexes. Since these provide raw database queries,
    | you should feel free to modify these settings based on your needs.
    |
    */
    'database' => [
        'engine' => env('SCOUT_ENGINE', 'like'),
    ],
];
