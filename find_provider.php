<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Looking for OneSecMail provider...\n\n";

// Try different possible slug names
$possibleSlugs = ['onesecmail', '1secmail', 'one-sec-mail', 'onesec-mail'];

foreach ($possibleSlugs as $slug) {
    $provider = DB::table('providers')->where('slug', $slug)->first();
    if ($provider) {
        echo "FOUND with slug '$slug':\n";
        print_r($provider);
        echo "\n";
    }
}

// Just show all providers with details
echo "\nAll Providers with full details:\n";
echo str_repeat('=', 80) . "\n";

$all = DB::table('providers')->get();
foreach ($all as $p) {
    echo "ID: {$p->id}\n";
    echo "Name: {$p->name}\n";
    echo "Slug: {$p->slug}\n";
    echo "Driver: {$p->driver_class}\n";
    echo "Active: " . ($p->is_active ? 'YES' : 'NO') . "\n";
    echo str_repeat('-', 80) . "\n";
}
