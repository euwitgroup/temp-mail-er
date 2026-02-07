<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\TempEmailHistory;
use App\Models\User;

echo "Checking Database...\n\n";

echo "1. Users count: " . User::count() . "\n";
echo "2. TempEmailHistory count: " . TempEmailHistory::count() . "\n";

if (TempEmailHistory::count() > 0) {
    echo "\nLatest Email History:\n";
    $latest = TempEmailHistory::latest()->first();
    print_r($latest->toArray());
} else {
    echo "\nNo history found. Try generating an email on the frontend first.\n";
}

echo "\nChecking Users table columns:\n";
$columns = \Illuminate\Support\Facades\Schema::getColumnListing('users');
print_r($columns);
