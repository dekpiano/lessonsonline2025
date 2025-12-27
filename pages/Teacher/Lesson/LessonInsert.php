<?php 
include_once '../../../php/Database/Database.php'; 
include_once '../../../pages/Teacher/PhpClass/ClassLesson.php'; 

$Title = "เพิ่มข้อมูลบทเรียน";
// get database connection
$database = new Database();
$db = $database->getConnection();
// prepare object
$Lesson = new ClassLesson($db);
$Lesson->CourseID = $_GET['CourseID']; 
$Lesson->readCourse(); 
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
                                <li class="breadcrumb-item"><a
                                        href="javascript:history.go(-1)"><i class="fas fa-arrow-left"></i> กลับไปหน้าหลักบทเรียน</a></li>
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

                            <form method="post" id="LessonFormInsert">
                                <div class="mb-3 mt-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="CourseID " class="form-label">จากคอร์สเรียน:</label>
                                            <input type="text" class="form-control" id="CourseName" name="CourseName"
                                                placeholder="Enter Lesson code" value="<?=$Lesson->CourseName?>"
                                                readonly>
                                            <input type="hidden" class="form-control" id="CourseID" name="CourseID"
                                                placeholder="Enter Lesson code" value="<?=$Lesson->CourseID?>" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="LessonCode" class="form-label">รหัสบทเรียน:</label>
                                            <input type="text" class="form-control" id="LessonCode" name="LessonCode"
                                                placeholder="Enter Lesson code" value="<?=$Lesson->getNewLessonCode()?>"
                                                readonly>
                                        </div>
                                    </div>

                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6 mt-2">
                                            <label for="LessonNo" class="form-label">บทเรียนที่:</label>
                                            <select name="LessonNo" id="LessonNo" class="form-control">
                                                <option value="">เลือกลำดับบทเรียน</option>
                                                <?php for ($i=1; $i <=30 ; $i++) :?>
                                                <option value="<?=$i?>">บทที่ <?=$i?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label for="LessonTitle" class="form-label">ชื่อบทเรียน:</label>
                                            <input type="text" class="form-control" id="LessonTitle" name="LessonTitle"
                                                placeholder="ใส่ชื่อบทเรียน">
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label for="LessonStudyTime" class="form-label">เวลาที่ใช้เรียน:</label>
                                            <input type="text" class="form-control" id="LessonStudyTime" name="LessonStudyTime"
                                                placeholder="กรุณาเวลาที่ใช้เรียน เป็น นาที">
                                        </div>
                                    </div>

                                </div>
                                <div class="mb-3">
                                    <label for="LessonContent" class="form-label">รายละเอียดบทเรียน:</label>
                                    <textarea class="form-control" id="summernote" name="LessonContent"
                                        rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="LessonVideoURL" class="form-label">วิดีโอ:</label>
                                    <input type="text" class="form-control" id="LessonVideoURL" name="LessonVideoURL"
                                        placeholder="ใส่ลิ้งก์วีดีโอ">
                                </div>
                                <button type="submit" class="btn btn-primary" id="saveButton">
                                <i class="fas fa-save"></i> บันทึก
                                    <div class="spinner-border text-light spinner-border-sm" role="status" id="spinner"
                                        style="display: none;">
                                        <span class="sr-only">Loading...</span>
                                    </div>
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