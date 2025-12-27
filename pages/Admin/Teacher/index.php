<?php include_once '../../../php/Database/Database.php'; 
include_once '../../../pages/Admin/PhpClass/ClassTeacher.php'; 
// สร้างออบเจกต์ฐานข้อมูลและคอร์สเรียน
$database = new Database();
$db = $database->getConnection();
$Title = "จัดการครูผู้สอน";

$Teacher = new ClassTeacher($db);
$result = $Teacher->read();
//echo "<pre>";print_r($result->fetch(PDO::FETCH_ASSOC)); exit();
?>

<?php include_once('../../../pages/Admin/Layout/HeaderAdmin.php') ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include_once('../../../pages/Admin/Layout/NavbarTopAdmin.php') ?>
        <?php include_once('../../../pages/Admin/Layout/NavbarLeftAdmin.php') ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?=$Title;?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="javascript:history.go(-1)">หน้าแรก</a></li>
                                <li class="breadcrumb-item active">Dashboard v1</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="">
                                <div class="card  mt-3">
                                    <div class="card-body register-card-body">
                                        <p class="login-box-msg">สมัครการใช้งาน สำหรับ ครูผู้สอน</p>
                                        <form method="post" id="FormRegisterTeacher" class="needs-validation"
                                            novalidate>
                                            <div class="input-group mb-3">
                                                <input type="email" class="form-control" placeholder="อีเมล" id="Email"
                                                    name="Email" required>
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-envelope"></span>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">กรุณากรอกอีเมล</div>
                                            </div>
                                            <div class="input-group mb-3">
                                                <input type="password" class="form-control" placeholder="รหัสผ่าน"
                                                    id="Password" name="Password" required>
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-lock"></span>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">กรุณากรอกรหัสผ่าน</div>
                                            </div>
                                            <div class="input-group mb-3">
                                                <input type="password" class="form-control" placeholder="ยืนยันรหัสผ่าน"
                                                    required>
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-lock"></span>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">กรุณากรอกยืนยันรหัสผ่าน</div>
                                            </div>
                                            <hr>
                                            <div class="input-group mb-3">
                                                <select name="UserPrefix" id="UserPrefix" class="form-control" required>
                                                    <option value="">กรุณาเลือกคำนำหน้า</option>
                                                    <option value="เด็กชาย">เด็กชาย</option>
                                                    <option value="เด็กหญิง">เด็กหญิง</option>
                                                    <option value="นาย">นาย</option>
                                                    <option value="นาง">นาง</option>
                                                    <option value="นางสาว">นางสาว</option>
                                                </select>
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-user"></span>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">กรุณาเลือกคำนำหน้า</div>
                                            </div>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="ชื่อจริง"
                                                    id="UserFirstName" name="UserFirstName" required>
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-user"></span>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">กรุณากรอกชื่อจริง</div>
                                            </div>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="นามสกุลจริง"
                                                    id="UserLastName" name="UserLastName" required>
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-user"></span>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">กรุณากรอกนามสกุลจริง</div>
                                            </div>
                                            <div class="input-group mb-3">
                                                <input type="date" class="form-control" placeholder="วันเกิด"
                                                    id="UserBirthday" name="UserBirthday" required>
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-birthday-cake"></i>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">กรุณาเลือกวันเกิด</div>
                                            </div>
                                            <div class="input-group mb-3">
                                                <input type="tel" class="form-control" placeholder="เบอร์โทร"
                                                    id="UserPhone" name="UserPhone" required>
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-phone"></span>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">กรุณากรอกเบอร์โทรศัพท์ </div>
                                            </div>


                                            <button type="submit" class="btn btn-primary btn-block">สมัครใช้งาน</button>

                                        </form>

                                    </div>
                                    <!-- /.form-box -->
                                </div><!-- /.card -->
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card mt-3">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="Tb_Couesr" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>รหัสครู</th>
                                                    <th>ชื่อ - นามสกุล</th>
                                                    <th>เบอร์โทร</th>
                                                    <th>อีเมล</th>
                                                    <th>ประเภท</th>
                                                    <th>คำสั่ง</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                                                <tr>
                                                    <td><?=$row['UserCode']?></td>
                                                    <td><?=$row['UserPrefix']?><?=$row['UserFirstName']?>
                                                        <?=$row['UserLastName']?></td>
                                                    <td><?=$row['UserPhone']?></td>
                                                    <td><?=$row['Email']?></td>
                                                    <td><?=$row['UserType']?></td>
                                                    <td>
                                                        <a href="http://" class=" btn btn-warning btn-sm">แก้ไข</a>
                                                        <a href="http://" class=" btn btn-danger btn-sm">ลบ</a>
                                                    </td>
                                                </tr>
                                                <?php endwhile; ?>
                                            <tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>





                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <?php include_once('../../../pages/Admin/Layout/FooterAdmin.php'); ?>
</body>

</html>