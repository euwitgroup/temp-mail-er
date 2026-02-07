@echo off
echo ================================
echo Mail-ER Production Setup
echo ================================
echo.

echo [1/6] Clearing caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
echo Done!
echo.

echo [2/6] Running migrations...
php artisan migrate --force
echo Done!
echo.

echo [3/6] Seeding database...
php artisan db:seed --class=DatabaseSeeder --force
php artisan db:seed --class=MainPageSeeder --force
echo Done!
echo.

echo [4/6] Creating storage link...
php artisan storage:link
echo Done!
echo.

echo [5/6] Optimizing for production...
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo Done!
echo.

echo [6/6] Cleanup complete!
echo.

echo ========================================
echo Production setup complete!
echo ========================================
echo.
echo Next steps:
echo 1. Update .env file with database credentials
echo 2. Run: php artisan key:generate
echo 3. Create admin user
echo 4. Test the application
echo.
echo Admin Panel: /admin/login
echo.
pause
