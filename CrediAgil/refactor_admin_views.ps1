$dir = "c:\laragon\www\SistemaBancario\CrediAgil\vista\Administradores"
$files = Get-ChildItem -Path $dir -Filter "*.php" | Where-Object { $_.Name -notmatch "temp_" }

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw -Encoding UTF8
    $modified = $false

    # 1. Remove dashboard bar (module title)
    # The regex targets <div class="dashboard_bar">...</div> and any internal spaces/tags robustly.
    $patternTitle = '(?s)<div class="dashboard_bar">.*?</div>'
    if ($content -match $patternTitle) {
        $content = $content -replace $patternTitle, ''
        $modified = $true
    }

    # 2. Remove inbox option
    # Targets the <a> tag containing "mensajeria-CrediAgil-usuarios" down to its closing </a>
    $patternInbox = '(?s)<a href="[^"]*mensajeria-CrediAgil-usuarios"[^>]*>.*?</a>'
    if ($content -match $patternInbox) {
        $content = $content -replace $patternInbox, ''
        $modified = $true
    }

    # 3. Inject Navbar and body class
    # Find <body ...> and make it <body class="has-topnav" ...>
    if (-not ($content -match 'has-topnav') -and ($content -match '<body(>|\s+[^>]*>)')) {
        $content = $content -replace '<body', '<body class="has-topnav"'
        
        # Inject require after <div id="main-wrapper">
        $patternWrapper = '(?s)(<div id="main-wrapper">)'
        $injection = "`$1`n`t`t`t<?php require('../vista/MenuNavegacion/navbar-administradores.php'); ?>`n"
        $content = $content -replace $patternWrapper, $injection
        $modified = $true
    }

    if ($modified) {
        Set-Content -Path $file.FullName -Value $content -Encoding UTF8
        Write-Host "Updated $($file.Name)"
    }
}
Write-Host "Done refactoring admin views."
