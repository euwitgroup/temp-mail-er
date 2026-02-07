<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Setting;

$enabled = Setting::where('key', 'cookie_consent_enabled')->value('value');
echo "Current Status: " . var_export($enabled, true) . "\n";

if (!$enabled) {
    echo "Enabling Cookie Consent...\n";
    Setting::updateOrCreate(['key' => 'cookie_consent_enabled'], ['value' => '1']);
    Setting::updateOrCreate(['key' => 'cookie_consent_message'], ['value' => 'We use cookies to ensure you get the best experience on our website.']);
    Setting::updateOrCreate(['key' => 'cookie_consent_agree'], ['value' => 'Accept']);
    Setting::updateOrCreate(['key' => 'cookie_consent_decline'], ['value' => 'Decline']);
    echo "Cookie Consent Enabled via Script.\n";
}
