@echo off
color 0A
echo ================================================
echo   ExpenseTracker - Setup
echo ================================================
echo.

echo [1/6] Checking PHP...
php -v >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: PHP not found! Add C:\xampp\php to PATH.
    pause & exit /b 1
)
echo PHP OK!

echo [2/6] Checking Composer...
composer -v >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: Composer not found! Download from getcomposer.org
    pause & exit /b 1
)
echo Composer OK!

echo [3/6] Installing dependencies...
composer install --no-interaction --prefer-dist
if %errorlevel% neq 0 ( echo ERROR: composer install failed! & pause & exit /b 1 )

echo [4/6] Setting up .env...
if not exist .env ( copy .env.example .env >nul )
php artisan key:generate

echo [5/6] Database setup...
echo.
echo Make sure XAMPP MySQL is STARTED!
echo Create database "expensetracker" in phpMyAdmin first:
echo   http://localhost/phpmyadmin
echo   Click New - type expensetracker - click Create
echo.
set /p dbpass="Enter MySQL password (press ENTER if blank): "
powershell -Command "(gc .env) -replace 'DB_PASSWORD=.*', 'DB_PASSWORD=%dbpass%' | Out-File -encoding ASCII .env"
powershell -Command "(gc .env) -replace 'DB_DATABASE=.*', 'DB_DATABASE=expensetracker' | Out-File -encoding ASCII .env"

echo [6/6] Running migrations and seeding...
php artisan migrate --force
php artisan db:seed --force

php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo.
echo ================================================
echo   SETUP COMPLETE!
echo   Open: http://localhost:8000
echo   Login: admin / admin123
echo ================================================
php artisan serve
pause
