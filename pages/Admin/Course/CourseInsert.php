<?php 
include_once '../../../php/Database/Database.php'; 
include_once '../../../pages/Admin/Course/Php/CourseClass.php'; 

$Title = "เพิ่มข้อมูลคอร์สเรียน";
// get database connection
$database = new Database();
$db = $database->getConnection();
// prepare object
$course = new Course($db);

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
                            <h1 class="m-0"><?=$Title?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">คอร์สเรียน</a></li>
                                <li class="breadcrumb-item active"><?=$Title?></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="card">
                        <div class="card-body">
                        
                                <form method="post" id="courseForm">
                                    <div class="mb-3 mt-3">
                                        <label for="courseCode" class="form-label">รหัสคอร์ส:</label>
                                        <input type="text" class="form-control" id="CourseCode" name="CourseCode"
                                            placeholder="Enter course code" value="<?=$course->getNewCourseCode()?>" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="CourseName" class="form-label">ชื่อคอร์ส:</label>
                                        <input type="text" class="form-control" id="CourseName" name="CourseName"
                                            placeholder="Enter course title">
                                    </div>
                                    <div class="mb-3">
                                        <label for="CourseDescription" class="form-label">รายละเอียดคอร์ส:</label>
                                        <textarea class="form-control" id="CourseDescription" name="CourseDescription" rows="3"
                                           ></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">บันทึก</button>
                                </form>
                           
                        </div>
                    </div>

                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <?php include_once('../../../pages/Admin/Layout/FooterAdmin.php'); ?>
</body>

</html>