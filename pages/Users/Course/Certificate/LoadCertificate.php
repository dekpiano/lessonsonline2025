<?php session_start();

require('../../../../plugins/fpdf/fpdf.php');

$pdf=new FPDF( 'L' , 'mm' ,'A4');
$pdf->AddFont('THSarabunNew','','THSarabunNew.php');
$pdf->AddFont('THSarabunNew','B','THSarabunNew_b.php');
$pdf->AddPage();
$pdf->Image("../../../../dist/img/certificate/cf".$_GET['CourseID'].".png",0,0,300,0,'','');
$pdf->SetXY(10,90);
$pdf->SetFont('THSarabunNew','b',36);
$pdf->Cell( 0  , 15 , iconv('UTF-8', 'cp874', $_SESSION['FullName']), 0 , 1 , 'C' );
$pdf->AddPage();
$pdf->Image("../../../../dist/img/certificate/cg".$_GET['CourseID'].".png",0,0,300,0,'','');

// กำหนดชื่อไฟล์ที่ต้องการดาวน์โหลด
$filename = $_SESSION['FullName'];

// กำหนด header เพื่อให้ดาวน์โหลดด้วยชื่อไฟล์ที่กำหนด
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . rawurlencode($filename) . '"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');

// ส่ง PDF ไปยังเบราว์เซอร์
$pdf->Output('I', rawurlencode('เกียรติบัตรของ '.$filename));
?>