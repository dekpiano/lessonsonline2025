<?php
include_once '../../../php/Database/Database.php'; 
require '../../../plugins/spreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

$database = new Database();
$pdo = $database->getConnection();

try {

    // ดึงข้อมูลจากฐานข้อมูล
    $stmt = $pdo->query('SELECT
        tb_users.UserID,
        tb_users.UserCode,
        tb_users.UserGender,
        tb_users.UserPrefix,
        tb_users.UserFirstName,
        tb_users.UserLastName,
        tb_users.UserIdCard,
        tb_users.UserRangeAge,
        tb_users.UserLevelEdu,
        tb_users.UserTypeService,
        tb_users.UserBirthday,
        tb_users.UserPhone,
        tb_users.Email,
        tb_range_age.rangeage_title,
        tb_type_service.typeser_title,
        tb_level_edu.edu_title
    FROM
    tb_users
    INNER JOIN tb_range_age ON tb_range_age.rangeage_id = tb_users.UserRangeAge
    INNER JOIN tb_type_service ON tb_type_service.typeser_id = tb_users.UserTypeService
    INNER JOIN tb_level_edu ON tb_level_edu.edu_id = tb_users.UserLevelEdu
    '); 
        // แก้ไขให้ตรงกับตารางและคอลัมน์ที่ต้องการ
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // สร้าง Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('Y')->setAutoSize(true);
    $sheet->getColumnDimension('Z')->setAutoSize(true);
    $sheet->getColumnDimension('AA')->setAutoSize(true);

    $sheet->getColumnDimension('E')->setWidth(5);  // เพศ ชาย
    $sheet->getColumnDimension('F')->setWidth(5);  // เพศ หญิง
    $sheet->getColumnDimension('G')->setWidth(5); // อายุ ต่ำกว่า 15
    $sheet->getColumnDimension('H')->setWidth(5); // อายุ 16-30
    $sheet->getColumnDimension('I')->setWidth(5); // อายุ 31-50
    $sheet->getColumnDimension('J')->setWidth(5); // อายุ 51-59
    $sheet->getColumnDimension('K')->setWidth(5); // อายุ 60 ปีขึ้นไป
    $sheet->getColumnDimension('L')->setWidth(5); // ไม่จบประถมศึกษา
    $sheet->getColumnDimension('M')->setWidth(5); // จบประถมศึกษา
    $sheet->getColumnDimension('N')->setWidth(5); // จบมัธยมศึกษา/ปวช.
    $sheet->getColumnDimension('O')->setWidth(5); // จบปวส.
    $sheet->getColumnDimension('P')->setWidth(5); // ปริญญาตรี
    $sheet->getColumnDimension('Q')->setWidth(5); // สูงกว่าปริญญาตรี
    $sheet->getColumnDimension('R')->setWidth(5); // นักเรียนในระบบ
    $sheet->getColumnDimension('S')->setWidth(5); // นักเรียน กศน.
    $sheet->getColumnDimension('T')->setWidth(5); // บุคคลทั่วไป
    $sheet->getColumnDimension('U')->setWidth(5); // ชื่อสถานศึกษา
    $sheet->getColumnDimension('V')->setWidth(5); // เบอร์โทร
    $sheet->getColumnDimension('W')->setWidth(5); // e-mail address
    $sheet->getColumnDimension('X')->setWidth(5); // บ้านเลขที่

    // ตั้งค่า Header
    $sheet->setCellValue('A1', 'ที่')
          ->setCellValue('B1', 'ชื่อ-สกุล')
          ->setCellValue('C1', 'เลขบัตร ปชช.')
          ->setCellValue('D1', 'จ./ด./ป เกิด')
          ->setCellValue('E1', 'เพศ')
          ->setCellValue('E2', 'ชาย')
          ->setCellValue('F2', 'หญิง')
          ->setCellValue('G1', 'อายุ(ปี)')
          ->setCellValue('G2', 'ต่ำกว่า 15')
          ->setCellValue('H2', '16-30')
          ->setCellValue('I2', '31-50')
          ->setCellValue('J2', '51-59')
          ->setCellValue('K2', '60 ปีขึ้นไป')
          ->setCellValue('L1', 'ระดับการศึกษา')
          ->setCellValue('L2', 'ต่ำกว่าประถมศึกษา')
          ->setCellValue('M2', 'ประถมศึกษา')
          ->setCellValue('N2', 'มัธยมศึกษาตอนต้น')
          ->setCellValue('O2', 'มัธยมศึกษาตอนปลาย/ปวช.')
          ->setCellValue('P2', 'อนุปริญญา/ปวส.')
          ->setCellValue('Q2', 'ปริญญาตรี')
          ->setCellValue('R2', 'สูงกว่าป.ตรี')          
          ->setCellValue('S1', 'ประเภทผู้รับบริการ')
          ->setCellValue('S2', 'นักเรียนในระบบ')
          ->setCellValue('T2', 'นักศึกษาสังกัด สกร.')
          ->setCellValue('U2', 'ครูในระบบ')   
          ->setCellValue('V2', 'ครูสังกัด สกร.')       
          ->setCellValue('W2', 'ประชาชนทั่วไป')
          ->setCellValue('X2', 'อื่น ๆ ระบุ')
          ->setCellValue('Y1', 'ชื่อสถานศึกษา')
          ->setCellValue('Z1', 'เบอร์โทร')
          ->setCellValue('AA1', 'e-mail address');

          $sheet->getStyle('E2:X2')->getAlignment()->setTextRotation(90);

    // Merge cells สำหรับหัวข้อหลัก
    $sheet->mergeCells('A1:A2');
    $sheet->mergeCells('B1:B2');
    $sheet->mergeCells('C1:C2');
    $sheet->mergeCells('D1:D2');
    $sheet->mergeCells('E1:F1');
    $sheet->mergeCells('G1:K1');
    $sheet->mergeCells('L1:R1');
    $sheet->mergeCells('S1:X1');
    $sheet->mergeCells('Y1:Y2');
    $sheet->mergeCells('Z1:Z2');
    $sheet->mergeCells('AA1:AA2');

    // ตั้งค่าการจัดตำแหน่งข้อความให้กลาง
    $sheet->getStyle('A1:AA2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A1:AA2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

    // ตั้งค่า Border สำหรับ Header
    $sheet->getStyle('A1:AA2')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    // เพิ่มข้อมูลจากฐานข้อมูลในแต่ละแถว
    $rowNumber = 3;
    foreach ($data as $index => $row) {
        $sheet->setCellValue('A' . $rowNumber, $index + 1);
        $sheet->setCellValue('B' . $rowNumber, $row['UserPrefix'].$row['UserFirstName'].' '.$row['UserLastName']);
        $sheet->setCellValueExplicit('C' . $rowNumber, $row['UserIdCard'],  DataType::TYPE_STRING);
        $sheet->setCellValue('D' . $rowNumber, $row['UserBirthday']);
        if($row['UserPrefix'] == "นาย" || $row['UserPrefix'] == "เด็กชาย"){
            $sheet->setCellValue('E' . $rowNumber, '✓');
        }else{
            $sheet->setCellValue('F' . $rowNumber, '✓');
        }
        

        // ตัวอย่างการใส่ข้อมูลสำหรับอายุ (ใช้การเช็คเงื่อนไข)
        if ($row['UserRangeAge'] == 1) {
            $sheet->setCellValue('G' . $rowNumber, '✓');
        } elseif ($row['UserRangeAge'] == 2) {
            $sheet->setCellValue('H' . $rowNumber, '✓');
        } elseif ($row['UserRangeAge'] == 3) {
            $sheet->setCellValue('I' . $rowNumber, '✓');
        } elseif ($row['UserRangeAge'] == 4) {
            $sheet->setCellValue('J' . $rowNumber, '✓');
        } else {
            $sheet->setCellValue('K' . $rowNumber, '✓');
        }

        // ตัวอย่างการใส่ข้อมูลระดับการศึกษา
        if($row['UserLevelEdu'] == 1){
            $sheet->setCellValue('L' . $rowNumber, '✓'); // ตัวอย่างใส่เครื่องหมายถูกในมัธยมศึกษาตอนต้น
        }elseif($row['UserLevelEdu'] == 2){
            $sheet->setCellValue('M' . $rowNumber, '✓');
        }elseif($row['UserLevelEdu'] == 3){
            $sheet->setCellValue('N' . $rowNumber, '✓');
        }elseif($row['UserLevelEdu'] == 4){
            $sheet->setCellValue('O' . $rowNumber, '✓');
        }elseif($row['UserLevelEdu'] == 5){
            $sheet->setCellValue('P' . $rowNumber, '✓');
        }elseif($row['UserLevelEdu'] == 6){
            $sheet->setCellValue('Q' . $rowNumber, '✓');
        }elseif($row['UserLevelEdu'] == 7){
            $sheet->setCellValue('R' . $rowNumber, '✓');
        }
       

        // ตัวอย่างการใส่ข้อมูลประเภทผู้รับบริการ
        if($row['UserTypeService'] == 1){
            $sheet->setCellValue('S' . $rowNumber, '✓'); // ตัวอย่างใส่เครื่องหมายถูกในนักศึกษา กศน.
        }elseif($row['UserTypeService'] == 4){
            $sheet->setCellValue('T' . $rowNumber, '✓');
        }elseif($row['UserTypeService'] == 2){
            $sheet->setCellValue('U' . $rowNumber, '✓');
        }elseif($row['UserTypeService'] == 5){
            $sheet->setCellValue('V' . $rowNumber, '✓');
        }elseif($row['UserTypeService'] == 3){
            $sheet->setCellValue('W' . $rowNumber, '✓');
        }
        

        $sheet->setCellValue('Y' . $rowNumber, "");
        $sheet->setCellValue('Z' . $rowNumber, $row['UserPhone']);
        $sheet->setCellValue('AA' . $rowNumber, $row['Email']);

        $rowNumber++;
    }

    // กำหนดเส้นขอบให้กับช่วงข้อมูลทั้งหมด
        $lastRow = $rowNumber - 1;
        $sheet->getStyle('A1:AA' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'wrapText' => true,
            ],
        ]);

     // ตั้งค่า header เพื่อให้สามารถดาวน์โหลดไฟล์ Excel
     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
     header('Content-Disposition: attachment;filename="แบบรายงานผู้เรียนกิจกรรมส่งเสริมการเรียน.xlsx"');
     header('Cache-Control: max-age=0');
 
     $writer = new Xlsx($spreadsheet);
     $writer->save('php://output');
     exit;

    // สร้างไฟล์ Excel
    // $writer = new Xlsx($spreadsheet);
    // $fileName = 'report.xlsx';
    // $writer->save($fileName);

    // echo "สร้างไฟล์รายงานสำเร็จ: " . $fileName;

} catch (PDOException $e) {
    echo 'การเชื่อมต่อฐานข้อมูลล้มเหลว: ' . $e->getMessage();
}
