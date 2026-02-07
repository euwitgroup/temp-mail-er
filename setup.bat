@echo off
REM Mail-ER Application - Setup Script
REM This script creates all necessary files for the application

echo ========================================
echo Mail-ER Application Setup
echo ========================================
echo.

echo [1/10] Creating Migrations...
php artisan make:migration create_settings_table --quiet
php artisan make:migration create_temp_email_history_table --quiet
php artisan make:migration create_activity_logs_table --quiet
php artisan make:migration add_role_to_users_table --table=users --quiet

echo [2/10] Creating Models...
php artisan make:model Provider --quiet
php artisan make:model Setting --quiet
php artisan make:model TempEmailHistory --quiet
php artisan make:model ActivityLog --quiet

echo [3/10] Creating Admin Controllers...
php artisan make:controller Admin/DashboardController --quiet
php artisan make:controller Admin/ProviderController --resource --quiet
php artisan make:controller Admin/UserController --resource --quiet
php artisan make:controller Admin/SettingController --quiet
php artisan make:controller Admin/AdSenseController --quiet

echo [4/10] Creating User Controllers...
php artisan make:controller User/DashboardController --quiet
php artisan make:controller User/EmailHistoryController --quiet
php artisan make:controller User/ProfileController --quiet

echo [5/10] Creating Frontend Controllers...
php artisan make:controller Frontend/EmailController --quiet
php artisan make:controller Frontend/InboxController --quiet

echo [6/10] Creating Middleware...
php artisan make:middleware AdminMiddleware --quiet

echo [7/10] Creating Seeders...
php artisan make:seeder ProviderSeeder --quiet
php artisan make:seeder SettingSeeder --quiet
php artisan make:seeder AdminUserSeeder --quiet

echo [8/10] Creating Requests...
php artisan make:request Admin/ProviderRequest --quiet
php artisan make:request User/ProfileUpdateRequest --quiet

echo [9/10] Creating Services directory structure...
if not exist "app\Services\Providers" mkdir app\Services\Providers
if not exist "app\Services" mkdir app\Services

echo [10/10] Creating View directories...
if not exist "resources\views\admin\layouts" mkdir resources\views\admin\layouts
if not exist "resources\views\admin\providers" mkdir resources\views\admin\providers
if not exist "resources\views\admin\users" mkdir resources\views\admin\users
if not exist "resources\views\admin\settings" mkdir resources\views\admin\settings
if not exist "resources\views\admin\adsense" mkdir resources\views\admin\adsense
if not exist "resources\views\user\layouts" mkdir resources\views\user\layouts
if not exist "resources\views\user\history" mkdir resources\views\user\history
if not exist "resources\views\user\profile" mkdir resources\views\user\profile
if not exist "resources\views\frontend\layouts" mkdir resources\views\frontend\layouts

echo.
echo ========================================
echo Setup Complete!
echo ========================================
echo.
echo Next Steps:
echo 1. Review and update migration files
echo 2. Run: php artisan migrate
echo 3. Seed database: php artisan db:seed
echo.
pause
