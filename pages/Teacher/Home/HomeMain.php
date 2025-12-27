<?php include_once '../../../php/Database/Database.php'; 
include_once '../../../pages/Teacher/Home/Php/ClassHome.php'; 
include_once '../../../pages/Teacher/PhpClass/ClassCourse.php'; 

// สร้างออบเจกต์ฐานข้อมูลและคอร์สเรียน
$database = new Database();
$db = $database->getConnection();
$Home = new ClassHome($db);
$Title = $Home->TitleBar;

// ดึงข้อมูลสถิติทั้งหมดด้วยการเรียกใช้เมธอดเดียวที่ปรับปรุงประสิทธิภาพแล้ว
$stats = $Home->getStats();

$CourseAll = $stats['total_courses'];
$LessonsAll = $stats['total_lessons'];
$EnrollmentsAll = $stats['total_enrollments'];
$CheckGraduationAll = $stats['total_graduation'];
$CountRegisterAll = $stats['total_students'];
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
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
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
                    <h2 class="mb-1">รายงาน</h2>
                    <hr>
                    <div>
                        <h4>แบบรายงานผู้เรียนกิจกรรมส่งเสริมการเรียน</h4>
                        <a href="../Report/ReportToExcel.php" class="btn btn-success">ดาวน์โหลด Excel</a>
                    </div>
                    <div class="mt-3">
                        <h4>รายงานแบบสำรวจความพึงพอใจของผู้เรียน</h4>
                        <a href="../Report/ReportComplacence.php?CourseID=1" class="btn btn-success">ดาวน์โหลด Excel คอร์ดเรียนที่ 1</a>
                        <a href="../Report/ReportComplacence.php?CourseID=2" class="btn btn-success">ดาวน์โหลด Excel คอร์ดเรียนที่ 2</a>
                    </div>

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <?php include_once('../../../pages/Teacher/Layout/FooterTeacher.php'); ?>
</body>

</html>