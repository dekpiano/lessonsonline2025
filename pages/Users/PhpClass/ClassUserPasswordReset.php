<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../../plugins/PHPMailer/src/Exception.php';
require __DIR__ . '/../../../plugins/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../../../plugins/PHPMailer/src/SMTP.php';

class ClassUserPasswordReset {
    private $pdo;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function requestPasswordReset($email) {
        // ตรวจสอบว่ามีอีเมลนี้ในฐานข้อมูลหรือไม่
        $stmt = $this->conn->prepare("SELECT Email FROM tb_users WHERE Email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $token = bin2hex(random_bytes(50)); // สร้างโทเคนที่ปลอดภัย
            $stmt = $this->conn->prepare("INSERT INTO tb_password_resets (pwr_email, pwr_token) VALUES (:email, :token)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);
            $stmt->execute();

            // ปรับปรุงการตรวจสอบ Protocol และ Host ให้แม่นยำขึ้น (รองรับ Port ใน Docker)
            $is_https = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] == 1)) ||
                        (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
            $protocol = $is_https ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST']; // จะรวม Port ด้วย เช่น localhost:8088

            // ตรวจสอบ Base Path อัตโนมัติ (รองรับทั้งการรันจาก Root และ Subfolder)
            // ไฟล์นี้อยู่ที่ /pages/Users/ForgotPassword/Php/PhpUserResetPassword.php
            // เราต้องการ get ส่วนที่เป็น root ของโปรเจกต์
            $scriptName = $_SERVER['SCRIPT_NAME'];
            $basePath = str_replace('/pages/Users/ForgotPassword/Php/PhpUserResetPassword.php', '', $scriptName);
            
            $resetLink = $protocol . $host . $basePath . "/pages/Users/ForgotPassword/RecoverPassword.php?token=" . $token;

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'dekpiano@skj.ac.th';
                $mail->Password   = 'hgyu ohmv czha hvdy'; // รหัสผ่านสำหรับแอป
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;
                // Set charset
                $mail->CharSet = 'UTF-8';
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                  // เปิดการดีบัก
                // $mail->SMTPDebug = 2; // ตั้งค่าให้แสดงระดับดีบักที่ต้องการ
                // $mail->Debugoutput = 'html';
                            
                // ตั้งค่าผู้ส่งและผู้รับ
                $mail->setFrom('dekpiano@skj.ac.th', "ผู้ดูแลระบบ Lessons Online");
                $mail->addAddress($email);

                // เนื้อหาอีเมล
                $mail->isHTML(true);
                $mail->Subject = 'แจ้งขอเปลี่ยนรหัสผ่านใหม่ - Lessons Online';
                
                // ปรับแต่งเนื้อหาอีเมลให้สวยงามขึ้นเล็กน้อย
                $mail->Body    = "
                    <div style='font-family: sans-serif; line-height: 1.6;'>
                        <h2>สวัสดีคุณผู้ใช้</h2>
                        <p>เราได้รับคำขอในการเปลี่ยนรหัสผ่านสำหรับบัญชีของคุณที่ Lessons Online</p>
                        <p>กรุณาคลิกที่ลิงก์ด้านล่างเพื่อทำการตั้งรหัสผ่านใหม่:</p>
                        <p><a href='{$resetLink}' style='background: #007bff; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;'>เปลี่ยนรหัสผ่านใหม่ที่นี่</a></p>
                        <p>หากคุณไม่ได้ร้องขอการเปลี่ยนนี้ กรุณาเพิกเฉยต่ออีเมลฉบับนี้</p>
                        <p>ขอบคุณครับ<br>ทีมงาน Lessons Online</p>
                    </div>
                ";
                $mail->AltBody = "กรุณาคลิกที่ลิงก์นี้เพื่อเปลี่ยนรหัสผ่าน: " . $resetLink;

                $mail->send();
                header("location:../CheckEmail.php");
                exit; // เพิ่ม exit เพื่อหยุดการทำงาน
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }else{
            header("location:../?Alert=err");
            exit; // เพิ่ม exit
        }
          
    
    }

    // เพิ่มเมธอดสำหรับตรวจสอบความถูกต้องของโทเคน
    public function validateToken($token) {
        $stmt = $this->conn->prepare("SELECT pwr_email FROM tb_password_resets WHERE pwr_token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function resetPassword($token, $newPassword) {
        // ตรวจสอบโทเคน
        $stmt = $this->conn->prepare("SELECT pwr_email FROM tb_password_resets WHERE pwr_token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $email = $stmt->fetchColumn();
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT); // แฮ็ชรหัสผ่านใหม่

            // อัปเดตรหัสผ่านในตาราง users
            $stmt = $this->conn->prepare("UPDATE tb_users SET Password = :password WHERE Email = :email");
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // ลบโทเคนออกจากฐานข้อมูล (แก้ไขชื่อตารางและคอลัมน์)
            $stmt = $this->conn->prepare("DELETE FROM tb_password_resets WHERE pwr_token = :token");
            $stmt->bindParam(':token', $token);
            $stmt->execute();

            header("location:../ConfrimPassword.php");
            exit; // เพิ่ม exit
        } else {
            return "Invalid token.";
        }
    }
}
