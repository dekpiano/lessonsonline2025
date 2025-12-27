<?php 
include_once '../../../php/Database/Database.php'; 
include_once '../../Users/PhpClass/ClassLearn.php';
include_once '../../../pages/Users/PhpClass/ClassRegisterUser.php';
include_once '../../../pages/Users/PhpClass/ClassUserPasswordReset.php';

$database = new Database();
$db = $database->getConnection();
$Title = "ตั้งรหัสผ่านใหม่ | Lessons Online";
$UserReset = new ClassUserPasswordReset($db);

$token = isset($_GET['token']) ? $_GET['token'] : '';
$isValidToken = $UserReset->validateToken($token);

if (!$isValidToken) {
    // ถ้าโทเคนไม่ถูกต้อง ให้กลับไปหน้าลืมรหัสผ่านพร้อมแจ้งเตือน
    header("location:index.php?Alert=invalid_token");
    exit;
}

?>
<?php include_once('../../../pages/Users/Layout/HeaderUser.php') ?>

<style>
    .auth-bg {
        min-height: 100vh;
        background: radial-gradient(circle at top right, #f8fafc 0%, #e2e8f0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .auth-card {
        background: white;
        width: 100%;
        max-width: 450px;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        padding: 40px;
    }

    .icon-circle {
        width: 72px;
        height: 72px;
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        font-size: 24px;
    }

    .password-requirement {
        font-size: 0.75rem;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
    }

    .password-requirement i {
        margin-right: 8px;
        width: 14px;
    }

    .requirement-met {
        color: #28a745;
    }

    .requirement-unmet {
        color: #6c757d;
    }
</style>

<body class="hold-transition">
    <div class="auth-bg">
        <div class="auth-card">
            <div class="icon-circle">
                <i class="fas fa-user-shield"></i>
            </div>
            
            <h3 class="text-center font-weight-bold mb-2">ตั้งรหัสผ่านใหม่</h3>
            <p class="text-center text-muted mb-4 small">กรุณากำหนดรหัสผ่านใหม่ที่คาดเดาได้ยากเพื่อความปลอดภัย</p>
            
            <form action="Php/PhpUserConfrimPassword.php" method="post" id="resetForm">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                
                <div class="form-group mb-3">
                    <label class="small font-weight-bold text-muted">รหัสผ่านใหม่</label>
                    <div class="input-group shadow-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0" style="border-radius: 12px 0 0 12px;"><i class="fas fa-lock text-muted"></i></span>
                        </div>
                        <input type="password" class="form-control border-left-0" style="border-radius: 0 12px 12px 0; height: 50px;" placeholder="Password" id="PasswordMain" name="PasswordMain" required>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="small font-weight-bold text-muted">ยืนยันรหัสผ่านใหม่</label>
                    <div class="input-group shadow-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0" style="border-radius: 12px 0 0 12px;"><i class="fas fa-check-double text-muted"></i></span>
                        </div>
                        <input type="password" class="form-control border-left-0" style="border-radius: 0 12px 12px 0; height: 50px;" placeholder="Confirm Password" id="ConfrimPassword" name="ConfrimPassword" required>
                    </div>
                </div>

                <div id="password-feedback" class="mb-4 p-3 bg-light" style="border-radius: 12px;">
                    <div class="password-requirement" id="req-length"><i class="fas fa-circle"></i> 8-20 ตัวอักษร</div>
                    <div class="password-requirement" id="req-upper"><i class="fas fa-circle"></i> มีพิมพ์ใหญ่อย่างน้อย 1 ตัว</div>
                    <div class="password-requirement" id="req-lower"><i class="fas fa-circle"></i> มีพิมพ์เล็กอย่างน้อย 1 ตัว</div>
                    <div class="password-requirement" id="req-number"><i class="fas fa-circle"></i> มีตัวเลขอย่างน้อย 1 ตัว</div>
                    <div class="password-requirement" id="req-special"><i class="fas fa-circle"></i> มีอักขระพิเศษอย่างน้อย 1 ตัว</div>
                    <div class="password-requirement mt-2 pt-2 border-top" id="req-match"><i class="fas fa-circle"></i> รหัสผ่านตรงกัน</div>
                </div>

                <button type="submit" id="submitButton" class="btn btn-primary btn-block btn-lg shadow-sm mb-4" style="height: 54px; border-radius: 14px;" disabled>
                    บันทึกรหัสผ่านใหม่ <i class="fas fa-save ml-2"></i>
                </button>

                <div class="text-center">
                    <a href="../Home/HomeMain" class="text-muted small align-items-center d-inline-flex">
                        <i class="fas fa-arrow-left mr-2"></i> กลับสู่หน้าหลัก
                    </a>
                </div>
            </form>
        </div>
    </div>

    <?php include_once('../../../pages/Users/Layout/FooterUser.php'); ?>
</body>
</html>

