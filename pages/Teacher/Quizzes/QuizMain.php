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
                                        <td><a href="#" class="btn btn-warning btn-sm BtnEditQuizzes"
                                                IDQuestion="<?php echo $row['QuestionID']; ?>" data-toggle="modal"
                                                data-target="#ModelUpdateQuiz">แก้ไข</a>
                                            <a href="#" class="btn btn-danger btn-sm"
                                                onclick="confirmDeleteQuiz(<?php echo $row['QuestionID']; ?>)">ลบ</a>
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

<style>
.custom-file-input~.custom-file-label::after {
    content: "";
}

.custom-file-input:focus~.custom-file-label {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
}

.image-preview-container {
    position: relative;
    display: inline-block;
}

.image-preview {
    margin-top: 10px;
    width: 100%;
    max-width: 300px;
    display: none;
}

.remove-button {
    position: absolute;
    top: 5px;
    right: 5px;
    background-color: red;
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    display: none;
    justify-content: center;
    align-items: center;
    cursor: pointer;
}

.remove-button:hover {
    background-color: darkred;
}

.upload-icon {
    cursor: pointer;
    font-size: 30px;
    color: #007bff;
}

.upload-icon:hover {
    color: #0056b3;
}
</style>
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
            <form id="FormInsertQuizzes" class="needs-validation" enctype="multipart/form-data" novalidate>
                <input type="hidden" id="LessonID" name="LessonID" value="<?=$_GET['LessonID']?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputDescription">คำถาม</label>
                        <div class="d-flex">
                            <textarea id="QuestionText" name="QuestionText" class="form-control" rows="2"
                                required></textarea>
                            <div class="custom-file ml-2" style="width:auto;">
                                <input type="file" class="custom-file-input" name="QuestionImg" id="customFile"
                                    accept="image/*" style="display: none;">
                                <i class="fas fa-image upload-icon"
                                    onclick="document.getElementById('customFile').click();"></i>
                            </div>
                        </div>

                        <div class="invalid-feedback">
                            กรุณาตั้งคำถาม
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="image-preview-container">
                            <img id="imagePreview" class="image-preview" src="#" alt="Image Preview">
                            <div id="removeButton" class="remove-button">&times;</div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <div>คำตอบ</div>
                            <div>เฉลย</div>
                        </div>
                        <div id="options-container">
                            <?php for ($i=1; $i <=4 ; $i++) :?>
                            <div>
                                <div class="d-flex align-items-center">
                                    <div class="mr-2" style="width: -webkit-fill-available;">
                                        <input type="text" id="OptChoice" name="OptChoice[]" class="form-control"
                                            placeholder="ใส่ตัวเลือกคำตอบ" required>                                        
                                    </div>
                                    <div>
                                        <label for="OrtionFile<?=$i?>" class="file-label mb-0 mr-2"><i
                                                class="fas fa-image upload-icon"></i></label>
                                        <input type="file" class="option-file-insert" name="OptImg[]" id="OrtionFile<?=$i?>"
                                            accept="image/*" style="display: none; ">
                                    </div>
                                    <div>
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="OptAnswer<?=$i?>" name="OptAnswer[]" value="1">
                                            <label for="OptAnswer<?=$i?>">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <img id="preview<?=$i?>" class="img-fluid" style="display:none;width:150px;" src="#" alt="">
                                <div id="removeButton" class="remove-button">&times;</div>
                            </div>
                            <?php endfor; ?>
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
        '<div><div class="d-flex align-items-center mt-2"><div class="mr-2" style="width: -webkit-fill-available;"><input type="text" id="OptChoice" name="OptChoice[]" class="form-control"placeholder="ใส่ตัวเลือกคำตอบ" required></div><div><label for="OrtionFile' +
        id +
        '" class="file-label mb-0 mr-2"><i class="fas fa-image upload-icon"></i></label><input type="file" class="option-file-insert" name="OptImg[]" id="OrtionFile' +
        id +
        '"  accept="image/*" style="display: none;"> </div><div><div class="icheck-primary d-inline"><input type="checkbox" id="OptAnswer' +
        id + '" name="OptAnswer[]" value="1"><label for="OptAnswer' + id +
        '"></label></div></div></div><img id="preview' + id +
        '" style="display:none;width:150px;" src="#" alt=""><div id="removeButton" class="remove-button">&times;</div></div>';
    container.append(html);
}

function UpdateaddOption() {
    var container = $("#Update-options-container");
    var id = container.children().length + 1;
    var html =
        '<div><div class="d-flex align-items-center mt-2"><div class="mr-2" style="width: -webkit-fill-available;"><input type="text" id="UpdateOptChoice" name="UpdateOptChoice[]" class="form-control"placeholder="ใส่ตัวเลือกคำตอบ" required></div><div><label for="OrtionFile' +
        id +
        '" class="file-label mb-0 mr-2"><i class="fas fa-image upload-icon"></i></label><input type="file" class="option-file-Update" name="OptImg[]" id="OrtionFile' +
        id +
        '"  accept="image/*" style="display: none;"> </div><div><div class="icheck-primary d-inline"><input type="checkbox" id="UpdateOptAnswer' +
        id + '" name="UpdateOptAnswer[]" value="1"><label for="UpdateOptAnswer' + id + '"></label></div></div></div><img id="OptionPreviwe' + id +
        '" style="display:none;width:150px;" src="#" alt=""></div>';
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
            <form id="FormUpdateQuizzes" enctype="multipart/form-data" class="needs-validation" novalidate>
                <input type="hidden" id="UpdateQuestionID" name="UpdateQuestionID" value="">
                <div class="modal-body">
                    <div class="form-group">
                     
                        <label for="inputDescription">คำถาม</label>
                        <div class="d-flex">
                            <textarea id="UpdateQuestionText" name="UpdateQuestionText" class="form-control" rows="2"
                                required></textarea>
                            <div class="custom-file ml-2" style="width:auto;">
                                <input type="file" class="custom-file-input-Update" name="UpdateQuestionImg"
                                    id="UpdatecustomFile" accept="image/*" style="display: none;">
                                <i class="fas fa-image upload-icon"
                                    onclick="document.getElementById('UpdatecustomFile').click();"></i>
                            </div>
                        </div>
                        <div class="image-preview-container">
                            <img id="UpdateimagePreview" class="img-fluid" src="#" alt="" style="width:200px">
                            <div id="UpdateremoveButton" class="remove-button">&times;</div>
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

                    <button type="button" class="btn btn-secondary mt-2"
                        onclick="UpdateaddOption()">เพิ่มตัวเลือก</button>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).on("change", ".custom-file-input", function() {
    var file = $(this)[0].files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').attr('src', e.target.result).show();
            $('#removeButton').show();
        }
        reader.readAsDataURL(file);
    }
});

$(document).on("change", ".custom-file-input-Update", function() {
    var file = $(this)[0].files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#UpdateimagePreview').attr('src', e.target.result).show();
            $('#UpdateremoveButton').show();
        }
        reader.readAsDataURL(file);
    }
});

$(document).on("click", "#removeButton", function() {
    $('#customFile').val(null);
    $('#imagePreview').hide().attr('src', '#');
    $(this).hide();
    $('.custom-file-label').removeClass("selected").html("");
    $('.upload-icon').show();
});
$(document).on("click", "#UpdateremoveButton", function() {
    $('#UpdateimagePreview').hide().attr('src', '#');
    $(this).hide();
    $('.custom-file-label').removeClass("selected").html("");
    $('.upload-icon').show();
});

$(document).on('change', '.option-file-insert', function(e) {
    e.preventDefault();
    var inputId = $(this).attr('id');
    var previewId = 'preview' + inputId.slice(-1);
    //console.log(previewId);
    //$('#' + previewId).html("");
    var file = this.files[0];
    if (file && /(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) {
        var reader = new FileReader();
        reader.onload = function(e) {

            $('#' + previewId).attr('src', e.target.result).show();
        }
        reader.readAsDataURL(file);
    }
});

$(document).on('change', '.option-file-Update', function(e) {
    e.preventDefault();
    var inputId = $(this).attr('id');
    var OptionPreviwe = 'OptionPreviwe' + inputId.slice(-1);
    //console.log(OptionPreviwe);
    //$('#' + previewId).html("");
    var file = this.files[0];
    if (file && /(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) {
        var reader = new FileReader();
        reader.onload = function(e) {

            $('#' + OptionPreviwe).attr('src', e.target.result).show();
        }
        reader.readAsDataURL(file);
    }
});

</script>