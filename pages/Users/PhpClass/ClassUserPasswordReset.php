<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../../../plugins/PHPMailer/src/Exception.php';
require '../../../../plugins/PHPMailer/src/PHPMailer.php';
require '../../../../plugins/PHPMailer/src/SMTP.php';

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

            $isLocalhost = $_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1';
            if ($isLocalhost) {
               $resetLink = 'http://'.$_SERVER['SERVER_NAME']."/lessonsonline/pages/Users/ForgotPassword/RecoverPassword.php?token=" . $token;
            }else{
                if($_SERVER['HTTPS'] === "on"){
                    $ht = "https://";
                }else{
                    $ht = "http://";
                }
                $resetLink = $ht.$_SERVER['SERVER_NAME']."/pages/Users/ForgotPassword/RecoverPassword.php?token=" . $token;
            }

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'dekpiano@skj.ac.th';
                $mail->Password   = 'hgyu ohmv czha hvdy'; // รหัสผ่านสำหรับแอป hgyu ohmv czha hvdy
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
                $mail->setFrom('dekpiano@skj.ac.th', "ผู้ดูแล");
                $mail->addAddress($email);

                // เนื้อหาอีเมล
                $mail->isHTML(true);
                $mail->Subject = 'คุณขอรหัสผ่านใหม่';
                $mail->Body    = 'ขอรหัสผ่านใหม่ ที่นี่ '.$resetLink;
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                header("location:../CheckEmail.php");
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }else{
            header("location:../?Alert=err");
        }
          
    
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

            // ลบโทเคนออกจากฐานข้อมูล
            // $stmt = $this->conn->prepare("DELETE FROM password_resets WHERE token = :token");
            // $stmt->bindParam(':token', $token);
            // $stmt->execute();

            header("location:../ConfrimPassword.php");
        } else {
            return "Invalid token.";
        }
    }
}

