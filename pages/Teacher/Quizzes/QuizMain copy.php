<?php 
include_once '../../../php/Database/Database.php'; 
include_once '../../../pages/Teacher/PhpClass/ClassQuizzes.php'; 
$database = new Database();
$db = $database->getConnection();
$Title = "สร้างแบบทดสอบ";

$Quiz = new ClassQuizzes($db);
$CheckNameLesson = $Quiz->CheckNameLesson($_GET['LessonID']);
$NameLesson = $CheckNameLesson->fetch(PDO::FETCH_ASSOC);
$ShowQuestion = $Quiz->readAll($_GET['LessonID']);


//print_r($NameLesson->fetch(PDO::FETCH_ASSOC)); exit();
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
                            <h1 class="m-0"><?=$Title;?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="javascript:history.go(-1)"><i
                                            class="fas fa-arrow-left"></i> กลับหน้าบทเรียน</a></li>
                                <li class="breadcrumb-item active">สร้างแบบทดสอบ</li>
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
                        <div class="card-header">
                            <h5 class="">
                                <div class=" d-flex justify-content-between align-items-center">
                                    <div>
                                        ตารางแบบทดสอบของบทเรียน <?=$NameLesson['LessonTitle']?>
                                    </div>
                                    <a href="#" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal"><i class="far fa-plus-square"></i> เพิ่มแบบทดสอบ</a>
                                </div>
                            </h5>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <table id="Tb_Couesr" class="table table-bordered table-striped">
                                <thead>
                                    <tr>

                                        <th>คำถาม</th>
                                        <th>คำตอบที่ถูก</th>
                                        <th>คำสั่ง</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $ShowQuestion->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr id="Quiz<?=$row['QuestionID'];?>">
                                        <td><?=$row['QuestionText']?></td>
                                        <td><?php print_r($Quiz->CorrectAnswer($row['QuestionID'])['OptChoice'] ?? "");?>
                                        </td>
                                        <td><a href="#"  class="btn btn-warning btn-sm BtnEditQuizzes" IDQuestion="<?php echo $row['QuestionID']; ?>" data-toggle="modal"
                                        data-target="#ModelUpdateQuiz">แก้ไข</a>
                                            <a href="#" class="btn btn-danger btn-sm" onclick="confirmDeleteQuiz(<?php echo $row['QuestionID']; ?>)">ลบ</a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>


                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <?php include_once('../../../pages/Teacher/Layout/FooterTeacher.php'); ?>
</body>

</html>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">สร้างแบบทดสอบ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="FormInsertQuizzes" class="needs-validation" novalidate>
                <input type="hidden" id="LessonID" name="LessonID" value="<?=$_GET['LessonID']?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputDescription">คำถาม</label>
                        <textarea id="QuestionText" name="QuestionText" class="form-control" rows="2"
                            required></textarea>
                        <div class="invalid-feedback">
                            กรุณาตั้งคำถาม
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <div>ตัวเลือก</div>
                            <div>เฉลย</div>
                        </div>
                        <div id="options-container">
                            <div class="d-flex align-items-center">
                                <div class="mr-2" style="width: -webkit-fill-available;">
                                    <input type="text" id="OptChoice" name="OptChoice[]" class="form-control"
                                        placeholder="ใส่ตัวเลือกคำตอบ" required>
                                    <div class="invalid-feedback">
                                        กรุณาเพิ่มตัวเลือก
                                    </div>
                                </div>
                                <div>
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="OptAnswer1" name="OptAnswer[]" value="1">
                                        <label for="OptAnswer1">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary mt-2" onclick="addOption()">เพิ่มตัวเลือก</button>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function addOption() {
    var container = $("#options-container");
    var id = container.children().length + 1;
    var html =
        '<div class="d-flex align-items-center mt-2"><div class="mr-2" style="width: -webkit-fill-available;"><input type="text" id="OptChoice" name="OptChoice[]" class="form-control"placeholder="ใส่ตัวเลือกคำตอบ" required></div><div><div class="icheck-primary d-inline"><input type="checkbox" id="OptAnswer' +
        id + '" name="OptAnswer[]" value="1"><label for="OptAnswer' + id + '"></label></div></div></div>';
    container.append(html);
}

function UpdateaddOption() {
    var container = $("#Update-options-container");
    var id = container.children().length + 1;
    var html =
        '<div class="d-flex align-items-center mt-2"><div class="mr-2" style="width: -webkit-fill-available;"><input type="text" id="UpdateOptChoice" name="OptChoice[]" class="form-control"placeholder="ใส่ตัวเลือกคำตอบ" required></div><div><div class="icheck-primary d-inline"><input type="checkbox" id="OptAnswer' +
        id + '" name="OptAnswer[]" value="1"><label for="OptAnswer' + id + '"></label></div></div></div>';
    container.append(html);
}
</script>


<!-- Modal -->
<div class="modal fade" id="ModelUpdateQuiz" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">แก้ไขแบบทดสอบ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="FormUpdateQuizzes" class="needs-validation" novalidate>
                <input type="hidden" id="UpdateQuestionID" name="UpdateQuestionID" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputDescription">คำถาม</label>
                        <textarea id="UpdateQuestionText" name="UpdateQuestionText" class="form-control" rows="2"
                            required></textarea>
                        <div class="invalid-feedback">
                            กรุณาตั้งคำถาม
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <div>ตัวเลือก</div>
                            <div>เฉลย</div>
                        </div>
                        <div id="Update-options-container">
                         
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary mt-2" onclick="UpdateaddOption()">เพิ่มตัวเลือก</button>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>