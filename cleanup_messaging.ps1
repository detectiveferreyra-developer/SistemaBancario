$files = Get-ChildItem -Path 'CrediAgil\vista' -Filter *.php -Recurse;
foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw;
    
    # 1. Remove require lines (handle both single and double quotes, and possible variations)
    $content = $content -replace "require\('\.\./modelo/mConteoMensajesBandejaEntrada_MensajeriaInterna\.php'\);", "";
    $content = $content -replace "require\(\"\.\./modelo/mConteoMensajesBandejaEntrada_MensajeriaInterna\.php\"\);", "";
    $content = $content -replace "require\('\.\./modelo/mConteoMensajesBandejaEntrada_MensajeriaInterna_Secundario\.php'\);", "";
    $content = $content -replace "require\(\"\.\./modelo/mConteoMensajesBandejaEntrada_MensajeriaInterna_Secundario\.php\"\);", "";
    
    # 2. Remove messaging bell li block
    # This regex matches the <li> block that contains 'mensajeria-CrediAgil-usuarios'
    $content = $content -replace '(?s)<li class="nav-item dropdown notification_dropdown">\s*<a class="nav-link bell bell-link" href="[^"]*mensajeria-CrediAgil-usuarios[^"]*">.*?</a>\s*</li>', "";
    
    # 3. Remove Inbox link block from profile dropdown
    $content = $content -replace '(?s)<a href="[^"]*mensajeria-CrediAgil-usuarios[^"]*" class="dropdown-item ai-icon">.*?</a>', "";

    # 4. Remove any remaining require lines if they were slightly different (e.g. extra spaces)
    $content = $content -replace "require\s*\(\s*['\"]\.\./modelo/mConteoMensajesBandejaEntrada_MensajeriaInterna(_Secundario)?\.php['\"]\s*\)\s*;", "";

    Set-Content $file.FullName $content;
}
