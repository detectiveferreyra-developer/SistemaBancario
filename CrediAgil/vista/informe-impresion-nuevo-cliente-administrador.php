<?php
if (empty($_SESSION['NombresCliente'])) {

} else {
    require('../FPDF/fpdf.php');
    // DATOS DE LOCALIZACION -> IDIOMA ESPAÑOL -> ZONA HORARIA EL SALVADOR (UTC-6)
    setlocale(LC_TIME, "spanish");
    date_default_timezone_set('America/El_Salvador');
    // INICIO REPORTE
    class PDF extends FPDF
    {
        // CABECERA DE DOCUMENTO
        function Header()
        {
            $this->Image('../vista/images/modelo-informes/cabecera-simple.png', 10, 9, 190);
        }

        // PIE DE PAGINA
        function Footer()
        {
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial', 'I', 8);
            // Número de página
            //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }
    // CREACION DE INSTANCIA DE CLASE
    $pdf = new PDF();
    $pdf->SetTitle("Informe nuevos usuarios - CrediAgil");
    $pdf->AliasNbPages();
    $pdf->AddPage();
    // CONTENIDO DE REPORTE [DOCUMENTO]
    $pdf->SetFont('Arial', '', 10);
    $pdf->Ln(50);
    $pdf->MultiCell(190, 5, utf8_decode("San Salvador, " . formatearFechaReal(null, false)), '', 'R');
    $pdf->Ln(5);
    $pdf->MultiCell(190, 5, utf8_decode("Estimado(a) cliente " . $_SESSION['NombresCliente'] . " " . $_SESSION['ApellidosCliente']) . ".");
    $pdf->Ln(5);
    $pdf->MultiCell(190, 5, utf8_decode("Nos complace mucho por haber confiado en nosotros como su institución financiera de preferencia, le doy la más cordial bienvenida a nombre de todo el personal que labora en esta institución y muy particularmente del mío y nos ponemos a sus órdenes para atenderle de una manera especial."));
    $pdf->Ln(5);
    $pdf->MultiCell(190, 5, utf8_decode("Nuestra institución cuenta con las mejores opciones financieras, tasas de interés, seguridad y manejo confidencial de todos sus datos personales. Siéntase seguro que todos los movimientos que reporte a nuestra institución, son debidamente registrados y verificados por nuestro sistema, y cada uno de nuestro personal autorizado en el área."));
    $pdf->Ln(5);
    $pdf->MultiCell(190, 5, utf8_decode("Permítame darle a conocer sus respectivos datos de acceso a nuestro sistema, en base al producto que usted eligió adquirir con nosotros."));
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Ln(1);
    $pdf->MultiCell(190, 5, utf8_decode("Usuario único / correo: "), '1', 'C');
    $pdf->Ln(1);
    $pdf->SetTextColor(194, 8, 8);
    $pdf->MultiCell(190, 5, utf8_decode($_SESSION['CodigoUsuarioCliente']) . " / " . $_SESSION['CorreoNuevoCliente'], '', 'C');
    $pdf->Ln(1);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell(190, 5, utf8_decode("Contraseña: "), '1', 'C');
    $pdf->SetTextColor(194, 8, 8);
    $pdf->Ln(1);
    $pdf->MultiCell(190, 5, utf8_decode($_SESSION['ContraseniaCliente']), '', 'C');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(190, 5, utf8_decode("Le recordamos que con respecto a la contraseña, es temporal; al momento de iniciar sesión por primera vez, el sistema automáticamente lo detectará y le pedirá que ingrese una nueva contraseña para el próximo inicio de sesión, debe tomar en cuenta que el mínimo de extensión de su contraseña son 8 carácteres, dígitos, símbolos especiales, etc. Esto es de carácter obligatorio para todos los nuevos clientes que accedan por primera vez. De igual manera tiene la libertad de cambiar su nombre de usuario solamente por una vez, al realizar el cambio, su usuario queda bloqueado y no será posible cambiarlo posteriormente por su cuenta. Para ello deberá presentar una causa justificada en nuestras instalaciones, explicando los motivos del por qué desea realizar otro cambio y quedando sujeto a su aprobación o rechazo de su solicitud."));
    $pdf->Ln(5);
    $pdf->MultiCell(190, 5, utf8_decode("Por favor guarde este comprobante en un lugar seguro, si por algún motivo pierde este comprobante. Por favor comuníquese inmediatamente a nuestra línea de atención al cliente explicando lo anterior para proceder inmediatamente al bloqueo de su cuenta temporalmente mientras se resuelve nuevamente su nuevo acceso."));
    $pdf->Ln(5);
    $pdf->MultiCell(190, 5, utf8_decode("Una vez finalizado todo el proceso, destruya este comprobante y desechelo tomando en cuenta las buenas prácticas que ayuden a conservar nuestro medio ambiente."));
    $pdf->Ln(5);
    $pdf->MultiCell(190, 5, utf8_decode("Sin más que agregar, nos complace tenerlo como cliente a usted y esperamos cumplir y suplir todas sus espectativas con nosotros."));
    $pdf->Ln(5);
    $pdf->MultiCell(190, 5, utf8_decode("ATENTAMENTE"));
    $pdf->Image('../vista/images/fotofirmas/142352_614119bb59898_00445234-2_0611-080999-112-2_firma.png', 75, 251, 55);
    $pdf->MultiCell(190, 5, utf8_decode("Gte. General CrediAgil S.A de C.V"));
    $pdf->Output();
}
?>