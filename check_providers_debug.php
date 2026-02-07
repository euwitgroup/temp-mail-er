<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Provider;

echo "=== CURRENT PROVIDERS ===\n";
$providers = Provider::all();
foreach ($providers as $p) {
    echo "Name: " . $p->name . "\n";
    echo "Slug: " . $p->slug . "\n";
    echo "Active: " . ($p->is_active ? 'YES' : 'NO') . "\n";
    echo "Priority: " . $p->priority . "\n";
    echo "Driver: " . $p->driver_class . "\n";
    echo "---\n";
}

echo "\n=== TESTING DOMAIN FETCH ===\n";
$service = app(\App\Services\TempMail\TempMailService::class);
try {
    $domains = $service->getAvailableDomains();
    echo "Total domains: " . count($domains) . "\n";

    // Group by provider
    $byProvider = [];
    foreach ($domains as $d) {
        $byProvider[$d['provider_name']][] = $d['domain'];
    }

    foreach ($byProvider as $provName => $doms) {
        echo "\n" . $provName . ": " . count($doms) . " domains\n";
        echo "  - " . implode("\n  - ", array_slice($doms, 0, 3)) . "\n";
        if (count($doms) > 3) {
            echo "  ... (" . (count($doms) - 3) . " more)\n";
        }
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
