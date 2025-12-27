<?php 
include_once '../../../php/Database/Database.php'; 
include_once '../../Users/PhpClass/ClassLearn.php';
include_once '../../../pages/Users/PhpClass/ClassRegisterUser.php';
$database = new Database();
$db = $database->getConnection();
$Title = "ลืมรหัสผ่าน | Lessons Online";
$User = new ClassRegisterUser($db);
$Course = new ClassLearn($db);
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
        text-align: center;
    }

    .icon-circle {
        width: 72px;
        height: 72px;
        background: rgba(99, 102, 241, 0.1);
        color: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        font-size: 24px;
    }
</style>

<body class="hold-transition">
    <div class="auth-bg">
        <div class="auth-card">
            <div class="icon-circle">
                <i class="fas fa-key"></i>
            </div>
            
            <h3 class="font-weight-bold mb-2">ลืมรหัสผ่าน?</h3>
            <p class="text-muted mb-4 small">ไม่ต้องกังวล! กรุณากรอกอีเมลที่ใช้สมัครสมาชิก เพื่อรับรหัสผ่านใหม่ทางอีเมลของคุณ</p>
            
            <form action="Php/PhpUserResetPassword.php" method="post">
                <div class="form-group mb-4">
                    <div class="input-group shadow-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0" style="border-radius: 12px 0 0 12px;"><i class="fas fa-envelope text-muted"></i></span>
                        </div>
                        <input type="email" class="form-control border-left-0" style="border-radius: 0 12px 12px 0; height: 50px;" placeholder="กรอกอีเมลของคุณ" id="Email" name="Email" required>
                    </div>
                </div>

                <?php if(isset($_GET['Alert'])): ?>
                    <?php if($_GET['Alert'] == 'err'): ?>
                        <div class="alert alert-danger border-0 mb-4" style="border-radius: 12px; font-size: 0.85rem;">
                            <i class="fas fa-exclamation-circle mr-2"></i> ไม่พบอีเมลนี้ในระบบ หรือข้อมูลไม่ถูกต้อง
                        </div>
                    <?php elseif($_GET['Alert'] == 'invalid_token'): ?>
                        <div class="alert alert-warning border-0 mb-4" style="border-radius: 12px; font-size: 0.85rem;">
                            <i class="fas fa-hourglass-end mr-2"></i> ลิงก์เปลี่ยนรหัสผ่านหมดอายุ หรือไม่ถูกต้อง กรุณาทำรายการใหม่
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary btn-block btn-lg shadow-sm mb-4" style="height: 54px; border-radius: 14px;">
                    ส่งรหัสผ่านใหม่ <i class="fas fa-paper-plane ml-2"></i>
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