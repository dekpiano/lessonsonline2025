<?php 
include_once '../../../php/Database/Database.php'; 
include_once '../../../pages/Teacher/PhpClass/ClassCourse.php';

$Title = "แก้ไขข้อมูลคอร์สเรียน";
// get database connection
$database = new Database();
$db = $database->getConnection();
// prepare object
$course = new ClassCourse($db);
$course->CourseID = $_GET['CourseID']; 
$course->readSingle();


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
                            <h1 class="m-0"><?=$Title?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="javascript:history.go(-1)">กลับหน้าคอร์สเรียน</a>
                                </li>
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

                            <form method="post" id="courseFormUpdate" enctype="multipart/form-data">
                                <div class="mb-3 mt-3">
                                    <label for="courseCode" class="form-label">รหัสคอร์ส:</label>
                                    <input type="text" class="form-control col-md-3" id="CourseCode" name="CourseCode"
                                        placeholder="Enter course code" value="<?=$course->CourseCode?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="CourseName" class="form-label">ชื่อคอร์ส:</label>
                                    <input type="text" class="form-control" id="CourseName" name="CourseName"
                                        placeholder="Enter course title" value="<?=$course->CourseName?>">
                                </div>
                                <div class="mb-3">
                                    <label for="CourseDescription" class="form-label">รายละเอียดคอร์ส:</label>
                                    <textarea class="form-control summernoteEdit" id="CourseDescription"
                                        name="CourseDescription" rows="3"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="CourseStartDate" class="form-label">วันที่เริ่ม:</label>
                                            <input type="date" class="form-control" id="CourseStartDate"
                                                name="CourseStartDate" placeholder="Enter course title"
                                                value="<?=$course->CourseStartDate?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="CourseEndDate" class="form-label">วันสิ้นสุด:</label>
                                            <input type="date" class="form-control" id="CourseEndDate"
                                                name="CourseEndDate" placeholder="Enter course title"
                                                value="<?=$course->CourseEndDate?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="CourseDuration" class="form-label">ระยะเวลา:</label>
                                        <input type="number" class="form-control" id="CourseDuration"
                                            name="CourseDuration" placeholder="รวมเวลาเรียนกี่ชั่วโมง"
                                            value="<?=$course->CourseDuration?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="CourseType" class="form-label">ประเภทคอร์สเรียน:</label>
                                        <input type="text" class="form-control" id="CourseType" name="CourseType"
                                            placeholder="คอมพิวเตอร์,คณิตศาสตร์,การงาน"
                                            value="<?=$course->CourseType?>">
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="CourseImage" class="form-label">หน้าปก:</label>
                                    <input type="file" class="form-control col-md-3" id="CourseImage" name="CourseImage"
                                        placeholder="เพิ่มรูป"
                                        onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">
                                    <input id="CourseImageOld" name="CourseImageOld" type="hidden"
                                        value="<?=$course->CourseImageOld;?>">
                                    <img id="preview" src="../../../uploads/Course/<?=$course->CourseImageOld;?>" class="img-fluid"
                                        alt="" srcset="">
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <span id="btnText">แก้ไขคอร์สเรียน</span>
                                    <span id="loading" class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true" style="display: none;"></span>

                                </button>
                            </form>

                        </div>
                    </div>

                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <?php include_once('../../../pages/Teacher/Layout/FooterTeacher.php'); ?>
</body>

</html>