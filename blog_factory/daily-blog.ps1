# daily-blog.ps1 — Automated daily blog generation for AppVerra
#
# Scheduled via Windows Task Scheduler to run daily.
# Uses Claude Code CLI to pick the next topic and run the full pipeline.
#
# Setup:
#   1. Open Task Scheduler
#   2. Create Basic Task → "AppVerra Daily Blog"
#   3. Trigger: Daily at 10:00 AM
#   4. Action: Start a program
#      Program: powershell.exe
#      Arguments: -ExecutionPolicy Bypass -File "C:\appverra\appVerra\blog_factory\daily-blog.ps1"
#   5. Settings: check "Run task as soon as possible after a scheduled start is missed"
#
# Or create via PowerShell (run as admin):
#   $action = New-ScheduledTaskAction -Execute "powershell.exe" `
#     -Argument '-ExecutionPolicy Bypass -File "C:\appverra\appVerra\blog_factory\daily-blog.ps1"'
#   $trigger = New-ScheduledTaskTrigger -Daily -At "10:00AM"
#   $settings = New-ScheduledTaskSettingsSet -StartWhenAvailable -DontStopIfGoingOnBatteries -AllowStartIfOnBatteryPower
#   Register-ScheduledTask -TaskName "AppVerra Daily Blog" -Action $action -Trigger $trigger -Settings $settings

$ErrorActionPreference = "Stop"
$repoRoot = "C:\appverra\appVerra"
$date = Get-Date -Format "yyyyMMdd-HHmmss"
$logDir = Join-Path $repoRoot "blog_factory\runs"
$logFile = Join-Path $logDir "daily-$date.log"

if (-not (Test-Path $logDir)) { New-Item -ItemType Directory -Path $logDir -Force | Out-Null }

# Check for kill switch
$killFile = Join-Path $repoRoot "blog_factory\.auto-publish-disabled"
if (Test-Path $killFile) {
    "$(Get-Date -Format 'o') [SKIPPED] Auto-publish disabled via kill switch" | Out-File $logFile -Encoding utf8
    exit 0
}

$prompt = @'
You are in the appVerra repo at C:\appverra\appVerra.

Your task: generate the next blog post from the topic backlog.

1. Read blog_factory/queue/topics.yaml
2. Read blog_factory/queue/published.json (create [] if missing)
3. Pick the first topic NOT already in published.json
4. If no topics left, print "No topics remaining in backlog" and stop
5. Run /publish-blog with that topic — this invokes the full 5-agent pipeline (researcher, keyword strategist, drafter, SEO packager, editor)
6. The pipeline will commit and push automatically if QC passes

This is an automated daily run. Do not ask for confirmation — proceed through the full pipeline.
'@

"$(Get-Date -Format 'o') [START] Daily blog generation" | Out-File $logFile -Encoding utf8

try {
    claude -p $prompt --cwd $repoRoot 2>&1 | Out-File $logFile -Append -Encoding utf8
    "$(Get-Date -Format 'o') [DONE] Pipeline finished" | Out-File $logFile -Append -Encoding utf8
} catch {
    "$(Get-Date -Format 'o') [ERROR] $($_.Exception.Message)" | Out-File $logFile -Append -Encoding utf8
    exit 1
}
