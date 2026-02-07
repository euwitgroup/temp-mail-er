<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($request = Illuminate\Http\Request::capture());

echo "================================\n";
echo "Mail-ER Pre-Deployment Check\n";
echo "================================\n\n";

$issues = [];
$warnings = [];
$success = [];

// 1. Check Environment
echo "[1/10] Checking Environment...\n";
if (env('APP_ENV') === 'production' && env('APP_DEBUG') === true) {
    $issues[] = "⚠️ APP_DEBUG is TRUE in production! Set to FALSE immediately.";
} else {
    $success[] = "✓ Environment configuration OK";
}

// 2. Check APP_KEY
echo "[2/10] Checking APP_KEY...\n";
if (empty(env('APP_KEY'))) {
    $issues[] = "❌ APP_KEY not set! Run: php artisan key:generate";
} else {
    $success[] = "✓ APP_KEY configured";
}

// 3. Check Database Connection
echo "[3/10] Checking Database...\n";
try {
    \Illuminate\Support\Facades\DB::connection()->getPdo();
    $success[] = "✓ Database connection successful";
} catch (\Exception $e) {
    $issues[] = "❌ Database connection failed: " . $e->getMessage();
}

// 4. Check Providers
echo "[4/10] Checking Providers...\n";
$providers = \App\Models\Provider::where('is_active', true)->count();
if ($providers === 0) {
    $warnings[] = "⚠️ No active providers found. Seed database: php artisan db:seed";
} else {
    $success[] = "✓ {$providers} active provider(s) configured";
}

// 5. Check Storage Link
echo "[5/10] Checking Storage...\n";
if (!file_exists(public_path('storage'))) {
    $warnings[] = "⚠️ Storage link missing. Run: php artisan storage:link";
} else {
    $success[] = "✓ Storage linked";
}

// 6. Check Permissions
echo "[6/10] Checking Permissions...\n";
$storagePath = storage_path();
if (!is_writable($storagePath)) {
    $issues[] = "❌ Storage directory not writable! Run: chmod -R 775 storage";
} else {
    $success[] = "✓ Storage permissions OK";
}

// 7. Check Routes
echo "[7/10] Checking Routes...\n";
try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes()->count();
    $success[] = "✓ {$routes} routes registered";
} catch (\Exception $e) {
    $warnings[] = "⚠️ Route check failed";
}

// 8. Check Admin User
echo "[8/10] Checking Admin User...\n";
$adminExists = \App\Models\User::where('role', 'admin')->exists();
if (!$adminExists) {
    $warnings[] = "⚠️ No admin user found. Create one via tinker.";
} else {
    $success[] = "✓ Admin user exists";
}

// 9. Check Pages
echo "[9/10] Checking Content Pages...\n";
$pages = \App\Models\Page::count();
if ($pages === 0) {
    $warnings[] = "⚠️ No pages found. Seed: php artisan db:seed --class=MainPageSeeder";
} else {
    $success[] = "✓ {$pages} page(s) configured";
}

// 10. Check Debug Files
echo "[10/10] Checking for Debug Files...\n";
$debugFiles = [
    'check_providers.php',
    'check_providers_debug.php',
    'fix_cookie_settings.php',
    'fix_duplicate_provider.php',
    'fix_settings.php',
    'check_db.php'
];

$foundDebugFiles = [];
foreach ($debugFiles as $file) {
    if (file_exists(__DIR__ . '/' . $file)) {
        $foundDebugFiles[] = $file;
    }
}

if (!empty($foundDebugFiles)) {
    $warnings[] = "⚠️ Debug files found (should be removed): " . implode(', ', $foundDebugFiles);
} else {
    $success[] = "✓ No debug files found";
}

// Print Results
echo "\n================================\n";
echo "RESULTS\n";
echo "================================\n\n";

if (!empty($success)) {
    echo "✅ PASSED (" . count($success) . "):\n";
    foreach ($success as $msg) {
        echo "   " . $msg . "\n";
    }
    echo "\n";
}

if (!empty($warnings)) {
    echo "⚠️ WARNINGS (" . count($warnings) . "):\n";
    foreach ($warnings as $msg) {
        echo "   " . $msg . "\n";
    }
    echo "\n";
}

if (!empty($issues)) {
    echo "❌ CRITICAL ISSUES (" . count($issues) . "):\n";
    foreach ($issues as $msg) {
        echo "   " . $msg . "\n";
    }
    echo "\n";
    echo "⚠️ Please fix these issues before deploying to production!\n\n";
    exit(1);
}

if (empty($warnings) && empty($issues)) {
    echo "🎉 All checks passed! Your application is ready for deployment.\n\n";
} else {
    echo "✅ No critical issues, but please review warnings.\n\n";
}

echo "================================\n";
echo "Next Steps:\n";
echo "================================\n";
echo "1. Review DEPLOYMENT_GUIDE.md\n";
echo "2. Update .env for production\n";
echo "3. Run: php artisan config:cache\n";
echo "4. Test all features\n";
echo "5. Deploy to live server\n";
echo "\n";
