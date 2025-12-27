<?php 
include_once '../../../php/Database/Database.php'; 
include_once '../../Users/PhpClass/ClassLearn.php';
include_once '../../../pages/Users/PhpClass/ClassRegisterUser.php';
$database = new Database();
$db = $database->getConnection();
$Title = "เช็คอีเมล | บทเรียนออนไลน์";

?>
<?php include_once('../../../pages/Users/Layout/HeaderUser.php') ?>

<body class="hold-transition layout-top-nav">


    <div class="d-flex justify-content-center align-items-center flex-column vh-100" style="background-color: #e9ecef;">
        <div class="login-box">

            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">
                   <h1 class="text-center text-success"><i class="fas fa-check-circle"></i></h1> 
                       <h2 class="text-center">คุณ! เปลี่ยนรหัสผ่านใหม่ เรียบร้อยแล้ว</h2> 
                    </p>
                   
                    <a href="../../../" class="btn btn-primary btn-block">กลับไปหน้าแรก</a>
                  
                   
                </div>

            </div>
        </div>
    </div>




    <?php include_once('../../../pages/Users/Layout/FooterUser.php'); ?>
</body>

</html>