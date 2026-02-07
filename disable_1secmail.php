<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Current Providers:\n";
echo str_repeat('-', 60) . "\n";

$providers = DB::table('providers')->get();

foreach ($providers as $provider) {
    echo sprintf(
        "ID: %d | %s (%s) | Active: %s\n",
        $provider->id,
        $provider->name,
        $provider->slug,
        $provider->is_active ? 'YES' : 'NO'
    );
}

echo "\n" . str_repeat('-', 60) . "\n";
echo "Disabling 1SecMail due to API 403 errors...\n";

DB::table('providers')
    ->where('slug', 'onesecmail')
    ->update(['is_active' => false]);

echo "1SecMail has been disabled.\n\n";

echo "Updated Providers:\n";
echo str_repeat('-', 60) . "\n";

$providers = DB::table('providers')->get();

foreach ($providers as $provider) {
    echo sprintf(
        "ID: %d | %s (%s) | Active: %s\n",
        $provider->id,
        $provider->name,
        $provider->slug,
        $provider->is_active ? 'YES' : 'NO'
    );
}
