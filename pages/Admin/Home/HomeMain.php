<?php include_once '../../../php/Database/Database.php';
include_once '../../../pages/Admin/PhpClass/ClassTeacher.php';  
// สร้างออบเจกต์ฐานข้อมูลและคอร์สเรียน
$database = new Database();
$db = $database->getConnection();
$Teacher = new ClassTeacher($db);
$result = $Teacher->read();
$num = $result->rowCount();

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
                    <div class="row mb-2 align-items-center">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">หน้าแรก</h1>
                            <p class="text-muted">ภาพรวมระบบและสถิติการใช้งาน</p>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <div class="float-sm-right">
                                <span class="text-muted"><i class="far fa-calendar-alt mr-1"></i> <?=thai_date_fullmonth(time())?></span>
                            </div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    
                    <!-- Welcome Banner (Optional) -->
                    <!-- <div class="alert alert-light border-0 shadow-sm mb-4" role="alert">
                        <h4 class="alert-heading text-primary"><i class="fas fa-hand-sparkles mr-1"></i> ยินดีต้อนรับ, <?=$_SESSION['FullName'] ?? 'ผู้ดูแลระบบ'?>!</h4>
                        <p class="mb-0 text-muted">เข้าสู่ระบบจัดการบทเรียนออนไลน์ จัดการครูผู้สอน คอร์สเรียน และการตั้งค่าต่างๆ ได้ที่นี่</p>
                    </div> -->

                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <!-- Teachers Count -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-white text-dark shadow-sm h-100 position-relative" style="border-left: 5px solid var(--primary-color);">
                                <div class="inner p-3">
                                    <h3 class="font-weight-bold text-dark"><?=$num?></h3>
                                    <p class="text-muted mb-0">ครูผู้สอนทั้งหมด</p>
                                </div>
                                <div class="icon text-primary" style="opacity: 0.1;">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <a href="../../../pages/Admin/Teacher" class="small-box-footer text-primary bg-transparent py-2 mt-2 d-block text-right pr-3">
                                    จัดการข้อมูล <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Settings -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-white text-dark shadow-sm h-100 position-relative" style="border-left: 5px solid var(--success-color);">
                                <div class="inner p-3">
                                    <h3 class="font-weight-bold text-dark">System</h3>
                                    <p class="text-muted mb-0">ตั้งค่าคอร์สเรียน</p>
                                </div>
                                <div class="icon text-success" style="opacity: 0.1;">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <a href="../../../pages/Admin/Settings/SettingsMain" class="small-box-footer text-success bg-transparent py-2 mt-2 d-block text-right pr-3">
                                    ไปที่ตั้งค่า <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                   
                        <!-- Placeholder for future stats -->
                         <div class="col-lg-3 col-6">
                            <div class="small-box bg-white text-dark shadow-sm h-100 position-relative" style="border-left: 5px solid var(--warning-color);">
                                <div class="inner p-3">
                                    <h3 class="font-weight-bold text-dark">-</h3>
                                    <p class="text-muted mb-0">นักเรียน (เร็วๆนี้)</p>
                                </div>
                                <div class="icon text-warning" style="opacity: 0.1;">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <a href="#" class="small-box-footer text-warning bg-transparent py-2 mt-2 d-block text-right pr-3">
                                    ดูรายละเอียด <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-white text-dark shadow-sm h-100 position-relative" style="border-left: 5px solid var(--info-color);">
                                <div class="inner p-3">
                                    <h3 class="font-weight-bold text-dark">-</h3>
                                    <p class="text-muted mb-0">คอร์สเรียน (เร็วๆนี้)</p>
                                </div>
                                <div class="icon text-info" style="opacity: 0.1;">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <a href="#" class="small-box-footer text-info bg-transparent py-2 mt-2 d-block text-right pr-3">
                                    ดูรายละเอียด <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->

        </div>
        <!-- /.content-wrapper -->


        <?php include_once('../../../pages/Admin/Layout/FooterAdmin.php'); ?>
</body>

</html>