<?php
require 'c:/laragon/www/SistemaBancario/CrediAgil/vendor/autoload.php';
$tp = new \PhpOffice\PhpWord\TemplateProcessor('c:/laragon/www/SistemaBancario/CrediAgil/vista/Administradores/FormatosContratos/Contrato_PersonaNatural_Auto.docx');
$tp->setValue('CLIENTE_NOMBRE_COMPLETO', 'Test Name');
$tp->saveAs('c:/laragon/www/SistemaBancario/CrediAgil/tmp_contratos/test_tp.docx');
echo "Done";
