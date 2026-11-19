<#
.SYNOPSIS
  Switch Laravel's default database connection between local (XAMPP) and remote (InfinityFree).

.DESCRIPTION
  Only the single DB_CONNECTION line in .env is rewritten:
    local  -> DB_CONNECTION=mysql    (DB_*        -> 127.0.0.1 / root)
    remote -> DB_CONNECTION=remote   (DB_REMOTE_* -> sql110.infinityfree.com / if0_41802168)

  Both connections stay configured at all times, so in code you can always use:
    DB::table(...)                // whichever is the default
    DB::connection('mysql')       // always local
    DB::connection('remote')      // always remote

.EXAMPLE
  powershell -ExecutionPolicy Bypass -File switch-db.ps1 local
  powershell -ExecutionPolicy Bypass -File switch-db.ps1 remote
#>
param(
    [Parameter(Mandatory = $true, Position = 0)]
    [ValidateSet('local', 'remote')]
    [string]$Target
)

$envFile = Join-Path $PSScriptRoot '.env'
if (-not (Test-Path $envFile)) {
    Write-Error ".env not found at $envFile"
    exit 1
}

$content = [System.IO.File]::ReadAllText($envFile)

# local = the built-in "mysql" connection (DB_*), remote = the "remote" connection (DB_REMOTE_*)
$connection = if ($Target -eq 'local') { 'mysql' } else { 'remote' }

$pattern = '(?m)^DB_CONNECTION=[^\r\n]*'
if (-not [regex]::IsMatch($content, $pattern)) {
    Write-Error 'Could not find the DB_CONNECTION line inside .env - no changes made.'
    exit 1
}

$newContent = [regex]::Replace($content, $pattern, "DB_CONNECTION=$connection")
[System.IO.File]::WriteAllText($envFile, $newContent)

Write-Host "Default database connection switched to: $Target (DB_CONNECTION=$connection)" -ForegroundColor Green
if ($Target -eq 'local') {
    Write-Host '  -> 127.0.0.1 / root / if0_41802168_vichu'
} else {
    Write-Host '  -> sql110.infinityfree.com / if0_41802168 / if0_41802168_vichu'
}
Write-Host "Both connections remain available: DB::connection('mysql') = local, DB::connection('remote') = remote."
