# daily-blog.ps1 — Hardened daily blog generation for AppVerra
# Entry point for the Windows Scheduled Task "AppVerra Daily Blog".
# Thin wrapper: timeout-guarded auth preflight -> timeout-guarded claude -p ->
# outcome markers -> watchdog. EVERY claude call runs under a wall-clock timeout
# with a real process-tree kill, so a hang can never produce a [START]-only log.

$ErrorActionPreference = "Stop"
$repoRoot   = "C:\appverra\appVerra"
$engineRoot = "C:\appverra\growth-engine"
$py         = Join-Path $engineRoot ".venv\Scripts\python.exe"
$date       = Get-Date -Format "yyyyMMdd-HHmmss"
$logDir     = Join-Path $repoRoot "blog_factory\runs"
$logFile    = Join-Path $logDir "daily-$date.log"

# `claude` on this machine is an npm PowerShell shim (claude.ps1) which
# Start-Process CANNOT launch ("%1 is not a valid Win32 application"). The .cmd
# shim IS launchable. Resolve it once; fall back to PATH.
$claudeCmd = (Get-Command claude.cmd -ErrorAction SilentlyContinue).Source
if (-not $claudeCmd) { $claudeCmd = "claude.cmd" }

if (-not (Test-Path $logDir)) { New-Item -ItemType Directory -Path $logDir -Force | Out-Null }
function Log($line) { "$(Get-Date -Format 'o') $line" | Out-File $logFile -Append -Encoding utf8 }

# Run claude under a hard wall-clock timeout with a REAL tree kill (claude spawns
# node/MCP children that Stop-Job would orphan). The prompt is fed via STDIN (a
# temp file) — NOT as an argument — so multi-line prompts can't be mangled by
# Windows command-line / cmd-shim arg parsing. Returns @{ TimedOut; Output }.
function Invoke-ClaudeWithTimeout {
    param([string]$PromptText, [string[]]$Flags, [int]$TimeoutSec)
    $promptFile = New-TemporaryFile
    $out = New-TemporaryFile
    $err = New-TemporaryFile
    try {
        Set-Content -Path $promptFile.FullName -Value $PromptText -Encoding utf8
        $p = Start-Process -FilePath $claudeCmd -ArgumentList $Flags -PassThru -NoNewWindow `
            -RedirectStandardInput $promptFile.FullName `
            -RedirectStandardOutput $out.FullName -RedirectStandardError $err.FullName
        $timedOut = -not $p.WaitForExit($TimeoutSec * 1000)
        if ($timedOut) {
            & taskkill /PID $p.Id /T /F 2>&1 | Out-Null   # kill claude + node/MCP tree
            try { $p.WaitForExit(5000) | Out-Null } catch {}
        }
        $text = (Get-Content $out.FullName -Raw -ErrorAction SilentlyContinue)
        $text += (Get-Content $err.FullName -Raw -ErrorAction SilentlyContinue)
        return @{ TimedOut = $timedOut; Output = [string]$text }
    } finally {
        Remove-Item $promptFile.FullName -Force -ErrorAction SilentlyContinue
        Remove-Item $out.FullName -Force -ErrorAction SilentlyContinue
        Remove-Item $err.FullName -Force -ErrorAction SilentlyContinue
    }
}

# --- kill switch ---
if (Test-Path (Join-Path $repoRoot "blog_factory\.auto-publish-disabled")) {
    "$(Get-Date -Format 'o') [SKIPPED] Auto-publish disabled via kill switch" | Out-File $logFile -Encoding utf8
    exit 0
}

"$(Get-Date -Format 'o') [START] Daily blog generation" | Out-File $logFile -Encoding utf8

Push-Location $repoRoot
try {
    # --- 1. preflight auth check — GUARDED by a 90s timeout (must never silent-hang) ---
    $pre = Invoke-ClaudeWithTimeout -PromptText "Reply with the single word READY and nothing else." -Flags @("-p", "--max-turns", "1") -TimeoutSec 90
    if ($pre.TimedOut) { Log "[TIMEOUT] auth preflight exceeded 90s, killed"; exit 3 }
    if ($pre.Output -notmatch "READY" -or $pre.Output -match "Not logged in") {
        Log "[AUTH-FAIL] Preflight auth check failed. Output: $($pre.Output.Trim())"
        exit 2
    }

    # --- 2. record HEAD, run the pipeline under a 25-min wall-clock timeout ---
    $headBefore = (& git rev-parse HEAD).Trim()

    $prompt = @'
You are in the appVerra repo at C:\appverra\appVerra.
Task: generate the next blog post from the topic backlog.
1. Read blog_factory/queue/topics.yaml and blog_factory/queue/published.json (create [] if missing).
2. Pick the first topic NOT already in published.json.
3. If no topics left, print "No topics remaining in backlog" and stop.
4. Run /publish-blog with that topic (full 5-agent pipeline). It commits and pushes if QC passes.
This is an automated run. Do not ask for confirmation.
'@

    $run = Invoke-ClaudeWithTimeout -PromptText $prompt -Flags @("-p", "--dangerously-skip-permissions", "--max-turns", "40") -TimeoutSec 1500
    $run.Output | Out-File $logFile -Append -Encoding utf8
    if ($run.TimedOut) { Log "[TIMEOUT] claude -p exceeded 1500s, killed"; exit 3 }

    # --- 3. did a commit land? ---
    $headAfter = (& git rev-parse HEAD).Trim()
    if ($headAfter -ne $headBefore) { Log "[COMMITTED $headAfter]" } else { Log "[NO-COMMIT]" }
    Log "[DONE] Pipeline finished"
}
catch {
    Log "[ERROR] $($_.Exception.Message)"
    exit 1
}
finally {
    Pop-Location
    # --- 4. always let the watchdog assess + alert on this run (runs even on exit N) ---
    if (Test-Path $py) { & $py (Join-Path $engineRoot "watchdog.py") 2>&1 | Out-File $logFile -Append -Encoding utf8 }
}
