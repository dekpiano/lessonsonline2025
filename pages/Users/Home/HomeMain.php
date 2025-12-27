<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../../../php/Database/Database.php'; 
include_once '../../Users/PhpClass/ClassCourse.php';
include_once '../../Users/PhpClass/ClassEnrollmentUser.php';
include_once '../../Users/PhpClass/ClassLearn.php';

$database = new Database();
$db = $database->getConnection();
$Course = new ClassCourse($db);
$Enroll = new ClassEnrollmentUser($db);
$Learn = new ClassLearn($db);
$Title = "บทเรียนออนไลน์";
$stmt = $Course->read();

$Resutl = $Course->readLessonsAll(@$_GET['Course']); //เมนูซ้าย

//echo '<pre>';print_r($EnrollmentSuccessful); 
//exit();



?>
<?php include_once('../../../pages/Users/Layout/HeaderUser.php') ?>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include_once('../../../pages/Users/Layout/NavbarHomeUser.php') ?>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"> คอร์สเรียน</h1>
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container">
                    <div class="row">

                        <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                        $EnrollmentSuccessful = $Enroll->CheckEnrollmentSuccessful($row['CourseID']);
                          ?>

                        <div class="col-md-4 ">
                            <a href="../Course/CourseView?CourseID=<?=$row['CourseID']?>">
                                <div class="card card-widget widget-user card-outline card-primary">
                                    <div class="widget-user-header text-white"
                                        style="background: url('../../../uploads/Course/<?=$row['CourseImage'];?>') center center;background-size: cover;">

                                    </div>
                                    <div class="p-2">
                                        <h5 class="m-0"><?=$row['CourseName']?></h5>
                                        <small>โดย ศูนย์วิทยาศาสตร์เพื่อการศึกษานครสวรรค์</small>
                                        <div class="row">
                                            <div class="col-sm-4 col-4 border-right">
                                                <div class="description-block">
                                                    <h5 class="description-header">
                                                        <?php print_r($Enroll->CheckEnrollmentAll($row['CourseID'])['SumAll']); ?>
                                                    </h5>
                                                    <span class="description-text">ลงทะเบียน</span>
                                                </div>

                                            </div>

                                            <div class="col-sm-4 col-4 border-right">
                                                <div class="description-block">
                                                    <h5 class="description-header">
                                                        <?php echo $EnrollmentSuccessful['SumAll'];?></h5>
                                                    <span class="description-text">เรียนสำเร็จ</span>
                                                </div>

                                            </div>

                                            <div class="col-sm-4 col-4">
                                                <div class="description-block">
                                                    <h5 class="description-header">
                                                        <?php print_r($Learn->LessonsAllWhereCourse($row['CourseID'])['LessonsAll'])?>
                                                    </h5>
                                                    <span class="description-text">บทเรียน</span>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endwhile; ?>

                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

    </div>
    <!-- ./wrapper -->

    <?php include_once('../../../pages/Users/Layout/FooterUser.php'); ?>