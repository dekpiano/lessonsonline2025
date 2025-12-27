<?php
session_start();
// ลบทุก session variables
$_SESSION = array();

// ถ้าต้องการทำลาย session อย่างสมบูรณ์, ลบ cookie ของ session ด้วย
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// สุดท้าย, ทำลาย session.
session_destroy();

// เปลี่ยนเส้นทางกลับไปยังหน้าเข้าสู่ระบบหรือหน้าแรก
header("Location: ../../");
exit();
?>