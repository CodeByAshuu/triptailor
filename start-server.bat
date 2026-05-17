@echo off
set "PHPRC=D:\php84"
set "PATH=D:\php84;%PATH%"
cd /d "D:\apna college notes\laravel\triptailor"

if not exist "D:\php84\php.exe" (
  echo PHP not found at D:\php84\php.exe
  pause
  exit /b 1
)

REM Ensure composer.phar exists in the project root for consistent PHP 8.4 usage
if not exist "composer.phar" (
    echo Downloading composer.phar...
    powershell -Command "Invoke-WebRequest -UseBasicParsing https://getcomposer.org/composer-stable.phar -OutFile composer.phar"
    if errorlevel 1 (
      echo Failed to download composer.phar
      pause
      exit /b 1
    )
)

REM Always check if vendor exists, if not or if specifically needed, run install.
REM To force a fresh install, delete the vendor folder and run this script.
if not exist "vendor\autoload.php" (
  echo Running composer install with PHP 8.4...
  "D:\php84\php.exe" composer.phar install --no-interaction --prefer-dist
  if errorlevel 1 (
    echo Composer install failed.
    pause
    exit /b 1
  )
)

echo Starting Laravel server with PHP 8.4...
"D:\php84\php.exe" artisan serve --host=127.0.0.1 --port=8000
pause