<?php
require_once __DIR__ . '/../vendor/autoload.php';

$template_path = realpath(__DIR__ . '/../Templates/CONTRATO - PRENDA AUTO - PERSONA.docx');
if (!$template_path)
    die("Template not found");

\PhpOffice\PhpWord\Settings::setPdfRendererPath(realpath(__DIR__ . '/../vendor/tecnickcom/tcpdf'));
\PhpOffice\PhpWord\Settings::setPdfRendererName('TCPDF');

$phpWord = \PhpOffice\PhpWord\IOFactory::load($template_path);
$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
$xmlWriter->save(__DIR__ . '/test_tcpdf.pdf');

echo "Saved to test_tcpdf.pdf\n";
