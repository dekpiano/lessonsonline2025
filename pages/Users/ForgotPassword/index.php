<?php 
include_once '../../../php/Database/Database.php'; 
include_once '../../Users/PhpClass/ClassLearn.php';
include_once '../../../pages/Users/PhpClass/ClassRegisterUser.php';
$database = new Database();
$db = $database->getConnection();
$Title = "ขอรหัสผ่านใหม่ | บทเรียนออนไลน์";
$User = new ClassRegisterUser($db);
$Course = new ClassLearn($db);
?>
<?php include_once('../../../pages/Users/Layout/HeaderUser.php') ?>

<body class="hold-transition layout-top-nav">


    <div class="d-flex justify-content-center align-items-center flex-column vh-100" style="background-color: #e9ecef;">
        <div class="login-box">
            <div class="login-logo">
                <a href="../../index2.html"><b>ขอรหัสผ่านใหม่</b></a>
            </div>

            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">เมื่อคุณลืมรหัสผ่าน? ให้กรอกอีเมลที่สมัครเพื่อรับรหัสผ่านใหม่</p>
                    <form action="Php/PhpUserResetPassword.php" method="post">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email" id="Email" name="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            
                        </div>
                        <?php if(isset($_GET['Alert'])): ?>
                        <div class="alert-danger p-2">
                                อีเมลของคุณไม่ถูกต้อง หรือไม่มีในระบบ!
                            </div>
                            <?php endif; ?>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">รับรหัสผ่านใหม่</button>
                            </div>

                        </div>
                    </form>
                   
                </div>

            </div>
        </div>
    </div>




    <?php include_once('../../../pages/Users/Layout/FooterUser.php'); ?>
</body>

</html>