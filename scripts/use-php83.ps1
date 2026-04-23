# Prepends WinGet PHP 8.3 to PATH for THIS PowerShell session only (no Administrator).
# Usage from project root:
#   . .\scripts\use-php83.ps1
#   php artisan migrate

$dir = Join-Path $env:LOCALAPPDATA 'Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe'
$phpExe = Join-Path $dir 'php.exe'

if (-not (Test-Path -LiteralPath $phpExe)) {
    Write-Error "PHP not found at: $phpExe`nInstall PHP 8.3 with winget or edit this script."
    return
}

$env:Path = "$dir;$env:Path"
Write-Host "Active PHP: $((Get-Command php).Source)"
& $phpExe -v
