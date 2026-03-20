@echo off
color 0A
echo ================================================
echo   ExpenseTracker - Starting Server
echo   Open: http://localhost:8000
echo   Login: admin / admin123
echo   Press Ctrl+C to stop
echo ================================================
php artisan serve
pause
