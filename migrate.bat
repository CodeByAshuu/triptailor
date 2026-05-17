@echo off
set "PHPRC=D:\php84"
set "PATH=D:\php84;%PATH%"
cd /d "D:\apna college notes\laravel\triptailor"

if not exist "D:\php84\php.exe" (
  echo PHP not found at D:\php84\php.exe
  pause
  exit /b 1
)

echo Running database migrations...
"D:\php84\php.exe" artisan migrate

pause