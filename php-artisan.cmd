@echo off
rem Run Artisan with WinGet PHP 8.3 (avoids XAMPP PHP 8.0 on PATH). No Administrator required.
setlocal EnableExtensions
set "PHP_DIR=%LOCALAPPDATA%\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe"
set "PHP_EXE=%PHP_DIR%\php.exe"
if not exist "%PHP_EXE%" (
    echo [php-artisan] Missing: %PHP_EXE%
    echo Install PHP 8.3 via winget or edit PHP_DIR in php-artisan.cmd.
    exit /b 1
)
"%PHP_EXE%" "%~dp0artisan" %*
exit /b %ERRORLEVEL%
