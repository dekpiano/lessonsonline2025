<?php include_once '../../../php/Database/Database.php'; 
include_once '../../../pages/Teacher/Home/Php/ClassHome.php'; 
include_once '../../../pages/Teacher/PhpClass/ClassCourse.php'; 

// สร้างออบเจกต์ฐานข้อมูลและคอร์สเรียน
$database = new Database();
$db = $database->getConnection();

$Home = new ClassHome($db);
$Title = "ผู้เรียนที่สำเร็จการศึกษา | " . $Home->TitleBar;

// ดึงข้อมูลสถิติทั้งหมดด้วยการเรียกใช้เมธอดเดียวที่ปรับปรุงประสิทธิภาพแล้ว
$stats = $Home->getStats();

$CourseAll = $stats['total_courses'];
$LessonsAll = $stats['total_lessons'];
$EnrollmentsAll = $stats['total_enrollments'];
$CheckGraduationAll = $stats['total_graduation'];
$CountRegisterAll = $stats['total_students'];

$ViewGraduationAll = $Home->CheckGraduationAll();
?>

<?php include_once('../../../pages/Teacher/Layout/HeaderTeacher.php') ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include_once('../../../pages/Teacher/Layout/NavbarTopTeacher.php') ?>
        <?php include_once('../../../pages/Teacher/Layout/NavbarLeftTeacher.php') ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">ผู้เรียนที่สำเร็จการศึกษา</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../">Home</a></li>
                                <li class="breadcrumb-item active">Graduation</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?=$CourseAll;?></h3>

                                    <p>คอร์สเรียน</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="ViewCoursesAll.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?=$LessonsAll;?></h3>

                                    <p>บทเรียน</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="ViewLessonsAll.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?=$EnrollmentsAll;?></h3>

                                    <p>ลงทะเบียนเรียน</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="ViewRegisterLearn.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?=$CheckGraduationAll;?></h3>

                                    <p>เรียนสำเร็จ</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="ViewGraduationAll.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                         
                         <!-- ./col -->
                         <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-dark">
                                <div class="inner">
                                    <h3><?=$CountRegisterAll;?></h3>

                                    <p>สมาชิกทั้งหมด</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="ViewRegisterAll.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                    <hr>
                    <h2 class="mb-1">รายชื่อผู้เรียนที่สำเร็จการศึกษา</h2>
                    <hr>

                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-hover" id="Tb_ViewGraduationAll">
                                <thead>
                                    <tr>
                                        <th>ชื่อ - นามสกุล</th>
                                        <th>อีเมล</th>
                                        <th>เบอร์โทร</th>
                                        <th>วันที่ลงทะเบียน</th>
                                        <th>คอร์สที่เรียน</th>
                                        <th>เลขที่ประกาศนียบัตร</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ViewGraduationAll as $key => $v_data) : ?>
                                    <tr>
                                        <td><?=$v_data['UserPrefix'].$v_data['UserFirstName'].' '.$v_data['UserLastName'];?></td>
                                        <td><?=$v_data['Email']?></td>
                                        <td><?=$v_data['UserPhone']?></td>
                                        <td><?=thai_date_fullmonth(strtotime($v_data['EnrollDate']))?></td>
                                        <td><?=$v_data['CourseName']?></td>
                                        <td>
                                            <span class="badge badge-success"><?=$v_data['EnrollCertificate']?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>



                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <?php include_once('../../../pages/Teacher/Layout/FooterTeacher.php'); ?>
</body>

</html>
