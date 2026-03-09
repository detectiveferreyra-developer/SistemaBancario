<?php
require 'c:/laragon/www/SistemaBancario/CrediAgil/vendor/autoload.php';

$template_path = 'c:/laragon/www/SistemaBancario/CrediAgil/Templates/CONTRATO - PRENDA AUTO - PERSONA.docx';
$tmp_dir = 'c:/laragon/www/SistemaBancario/CrediAgil/tmp_contratos/';
$tmp_filename = $tmp_dir . 'test_tp2.docx';
$pdf_filename = $tmp_dir . 'test_tp2.pdf';

$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($template_path);
$templateProcessor->setValue('NOMBRE_CLIENTE', 'Prueba VBScript');
$templateProcessor->saveAs($tmp_filename);

echo "Docx guardado. ";

// Intentar convertir
$vbs_path = $tmp_dir . 'convert.vbs';
$command = "cscript //nologo \"$vbs_path\" \"$tmp_filename\" \"$pdf_filename\"";
$output = shell_exec($command);

echo "Resultado VBScript: $output";
if (file_exists($pdf_filename)) {
    echo " -> PDF CREADO!";
} else {
    echo " -> FALLÓ PDF.";
}
