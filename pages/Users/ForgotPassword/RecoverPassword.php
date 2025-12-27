<?php 
include_once '../../../php/Database/Database.php'; 
include_once '../../Users/PhpClass/ClassLearn.php';
include_once '../../../pages/Users/PhpClass/ClassRegisterUser.php';
$database = new Database();
$db = $database->getConnection();
$Title = "เปลี่ยนรหัสผ่านใหม่ | บทเรียนออนไลน์";
$User = new ClassRegisterUser($db);
$Course = new ClassLearn($db);
?>
<?php include_once('../../../pages/Users/Layout/HeaderUser.php') ?>

<body class="hold-transition layout-top-nav">


    <div class="d-flex justify-content-center align-items-center flex-column vh-100" style="background-color: #e9ecef;">
        <div class="login-box">
            <div class="login-logo">
                <a href="../../index2.html"><b>เปลี่ยนรหัสผ่านใหม่</b></a>
            </div>

            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">คุณเหลือรหัสผ่านใหม่เพียงขั้นตอนเดียว กู้คืนรหัสผ่านของคุณทันที</p>
                    <form action="Php/PhpUserConfrimPassword.php" method="post">
                        <div class="input-group mb-3">
                            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                            <input type="password" id="PasswordMain" name="PasswordMain" class="form-control"
                                placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" id="ConfrimPassword" name="ConfrimPassword" class="form-control"
                                placeholder="Confirm Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <p id="message"></p>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" id="submitButton" class="btn btn-primary btn-block" disabled>เปลี่ยนรหัสผ่าน</button>
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

