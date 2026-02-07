<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Provider;

echo "=== DELETING DUPLICATE MAILSAC ===\n";
// Delete the one with wrong driver (MailTmDriver instead of MailsacDriver)
$duplicate = Provider::where('slug', 'mailsacs')->first();
if ($duplicate) {
    echo "Found duplicate: " . $duplicate->name . " (slug: " . $duplicate->slug . ")\n";
    echo "Driver: " . $duplicate->driver_class . "\n";
    $duplicate->delete();
    echo "✓ Deleted!\n";
} else {
    echo "No duplicate found with slug 'mailsacs'\n";
}

echo "\n=== REMAINING PROVIDERS ===\n";
$providers = Provider::all();
foreach ($providers as $p) {
    echo $p->name . " (" . $p->slug . ") - " . $p->driver_class . "\n";
}
