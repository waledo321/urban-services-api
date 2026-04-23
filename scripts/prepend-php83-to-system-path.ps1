<#
.SYNOPSIS
  Puts WinGet PHP 8.3 before XAMpp in the *Machine* PATH (requires Administrator).

.DESCRIPTION
  Windows searches System PATH before User PATH. If C:\xampp\php is in System PATH,
  it wins over a User-level PHP 8.3 entry. This script prepends the WinGet PHP 8.3
  folder so `php -v` and `php artisan` use PHP >= 8.2.

  Run once: Right-click PowerShell -> Run as administrator, then:
    Set-Location 'D:\StudioProjects\urban-services-api'
    .\scripts\prepend-php83-to-system-path.ps1
#>
#Requires -RunAsAdministrator

$wingetPhpDir = Join-Path $env:LOCALAPPDATA 'Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe'
$phpExe = Join-Path $wingetPhpDir 'php.exe'

if (-not (Test-Path -LiteralPath $phpExe)) {
    Write-Error "PHP 8.3 not found at: $phpExe`nInstall PHP 8.3 via winget or adjust `$wingetPhpDir in this script."
    exit 1
}

$machinePath = [Environment]::GetEnvironmentVariable('Path', 'Machine')
$segments = @()
if (-not [string]::IsNullOrWhiteSpace($machinePath)) {
    $segments = $machinePath -split ';' |
        ForEach-Object { $_.Trim() } |
        Where-Object { $_ -ne '' -and $_ -ne $wingetPhpDir }
}

$newMachinePath = ($wingetPhpDir + ';' + ($segments -join ';')).TrimEnd(';')
[Environment]::SetEnvironmentVariable('Path', $newMachinePath, 'Machine')

Write-Host 'Machine PATH updated. WinGet PHP 8.3 is now first among system entries.'
Write-Host 'Close and reopen all terminals, then run: php -v'
