$ErrorActionPreference = "Stop"

# Paths
$phpPath = "C:\xampp\php\php.exe"
$mysqlPath = "C:\xampp\mysql\bin\mysql.exe"
$mysqldPath = "C:\xampp\mysql\bin\mysqld.exe"
$baseDir = "C:\xampp\mysql" 
$dataDir = "$baseDir\data"
$port = 3307

Write-Host "Checking requirements..."
if (!(Test-Path $phpPath)) { Write-Error "PHP not found at $phpPath" }
if (!(Test-Path $mysqldPath)) { Write-Error "MySQL Server not found at $mysqldPath" }

# Start MySQL on custom port
Write-Host "Starting MySQL on port $port..."
$mysqlProc = Start-Process -FilePath $mysqldPath -ArgumentList "--port=$port", "--console", "--basedir=$baseDir", "--datadir=$dataDir" -PassThru -NoNewWindow
Start-Sleep -Seconds 5

# Check if MySQL is running
$check = $null
try {
    # Check simple connection
    & $mysqlPath --port=$port -u root -e "SELECT 1" 2>&1 | Out-Null
    $check = $true
} catch {
    $check = $false
}

if (!$check) {
    Write-Warning "MySQL didn't respond immediately. Waiting more..."
    Start-Sleep -Seconds 5
}

# Create DB and Import
Write-Host "Setting up Database 'onlineshop'..."
try {
    & $mysqlPath --port=$port -u root -e "CREATE DATABASE IF NOT EXISTS onlineshop;"
    if ($LASTEXITCODE -eq 0) {
        Write-Host "Database created/verified."
        # Check if tables exist (simple check)
        $tables = & $mysqlPath --port=$port -u root -N -e "USE onlineshop; SHOW TABLES;"
        if (!$tables) {
            Write-Host "Importing schema..."
            $sqlFile = "database/onlineshop.sql"
            if (Test-Path $sqlFile) {
                # Setup cmd for redirection
                cmd /c "$mysqlPath --port=$port -u root onlineshop < $sqlFile"
                Write-Host "Import complete."
            } else {
                Write-Warning "SQL file not found at $sqlFile"
            }
        } else {
            Write-Host "Tables already exist. Skipping import."
        }
    }
} catch {
    Write-Error "Failed to setup database: $_"
}

# Start PHP Server
Write-Host "Starting PHP Server on localhost:8000..."
$phpJob = Start-Process -FilePath $phpPath -ArgumentList "-S", "localhost:8000" -PassThru -NoNewWindow

# Open Browser
Start-Process "http://localhost:8000"

Write-Host "App is running! Press Enter to stop servers and exit."
Read-Host
Stop-Process -Id $phpJob.Id -ErrorAction SilentlyContinue
Stop-Process -Id $mysqlProc.Id -ErrorAction SilentlyContinue
Write-Host "Stopped."
