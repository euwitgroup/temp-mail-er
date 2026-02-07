<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\TempEmailHistory;
use Illuminate\Support\Facades\Session;

echo "Testing TempEmailHistory insertion...\n";

try {
    // Mock session ID if needed, though we are passing string 'test_session'
    $data = [
        'email_address' => 'debug_' . time() . '@example.com',
        'provider_slug' => 'debug-provider',
        'session_id' => 'debug_session_' . uniqid(),
        'generated_at' => now(),
        'messages_count' => 0
    ];

    echo "Attempting to create record with data:\n";
    print_r($data);

    $history = TempEmailHistory::create($data);

    echo "Success! Created record with ID: " . $history->id . "\n";

} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
