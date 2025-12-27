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
/* Modern Modal Styling */
.modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.modal-header {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    color: white;
    border-radius: 15px 15px 0 0;
    padding: 1.5rem;
}

.modal-header .close {
    color: white;
    text-shadow: none;
    opacity: 0.8;
}

.modal-header .close:hover {
    opacity: 1;
}

.modal-body {
    padding: 2rem;
    background-color: #f8f9fc;
}

/* Question Area */
.question-section {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    margin-bottom: 2rem;
}

/* Option Card */
.option-item {
    background: white;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
    border: 1px solid #e3e6f0;
    position: relative;
    box-shadow: 0 4px 6px rgba(0,0,0,0.02);
}

.option-item:hover {
    border-color: #4e73df;
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.05);
}

.option-item.is-correct {
    border-color: #1cc88a;
    background-color: #f0fff4;
}

/* Choice Labels (A, B, C...) */
.choice-label {
    width: 35px;
    height: 35px;
    background: #4e73df;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-weight: bold;
    margin-right: 15px;
    flex-shrink: 0;
    font-size: 14px;
}

/* Image Upload Widgets */
.upload-trigger {
    cursor: pointer;
    font-size: 1.25rem;
    color: #4e73df;
    transition: all 0.2s;
    padding: 8px;
    border-radius: 8px;
    background: #f1f3f9;
    margin-right: 10px;
}

.upload-trigger:hover {
    background: #4e73df;
    color: white;
}

/* Image Previews */
.image-preview-wrapper {
    position: relative;
    margin-top: 10px;
    max-width: 250px;
    border-radius: 8px;
    overflow: hidden;
    border: 2px solid #eaecf4;
}

.image-preview-wrapper img {
    width: 100%;
    display: block;
}

.btn-remove-img {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(231, 74, 59, 0.9);
    color: white;
    border: none;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    z-index: 10;
}

.btn-remove-img:hover {
    background: #e74a3b;
    transform: scale(1.1);
}

/* Correct Answer Checkbox */
.correct-checkbox {
    margin-left: 15px;
}

.custom-control-input:checked ~ .custom-control-label::before {
    background-color: #1cc88a;
    border-color: #1cc88a;
}

/* Animations */
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.option-item {
    animation: fadeInDown 0.3s ease-out forwards;
}
</style>

<!-- Modal Create -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                    <i class="fas fa-plus-circle mr-2"></i> สร้างแบบทดสอบใหม่
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="FormInsertQuizzes" class="needs-validation" enctype="multipart/form-data" novalidate>
                <input type="hidden" id="LessonID" name="LessonID" value="<?=$_GET['LessonID']?>">
                <div class="modal-body">
                    
                    <!-- Question Section -->
                    <div class="question-section">
                        <label class="font-weight-bold text-primary mb-3"><i class="fas fa-question-circle mr-1"></i> โจทย์คำถาม</label>
                        <div class="row">
                            <div class="col-md-9">
                                <textarea id="QuestionText" name="QuestionText" class="form-control form-control-lg" 
                                    placeholder="พิมพ์คำถามที่ต้องการ..." rows="3" required style="border-radius: 10px;"></textarea>
                                <div class="invalid-feedback">กรุณาตั้งคำถาม</div>
                            </div>
                            <div class="col-md-3 d-flex flex-column align-items-center justify-content-center border-left">
                                <span class="text-xs text-muted mb-2">รูปภาพประกอบ (ถ้ามี)</span>
                                <div class="upload-trigger" onclick="document.getElementById('customFile').click();">
                                    <i class="fas fa-image"></i> เพิ่มรูปภาพ
                                </div>
                                <input type="file" class="custom-file-input d-none" name="QuestionImg" id="customFile" accept="image/*">
                            </div>
                        </div>
                        <div class="image-preview-wrapper mt-3 d-none" id="q-preview-box">
                            <img id="imagePreview" src="#" alt="Preview">
                            <button type="button" class="btn-remove-img" id="removeButton" title="ลบรูปภาพ">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <label class="font-weight-bold text-dark m-0"><i class="fas fa-list-ul mr-1"></i> ตัวเลือกคำตอบ</label>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addOption()">
                            <i class="fas fa-plus"></i> เพิ่มตัวเลือก
                        </button>
                    </div>

                    <!-- Options Section -->
                    <div id="options-container">
                        <?php 
                        $labels = ['A', 'B', 'C', 'D', 'E', 'F'];
                        for ($i=1; $i <=4 ; $i++) :
                        ?>
                        <div class="option-item d-flex flex-column" id="opt-item-<?=$i?>">
                            <div class="d-flex align-items-center">
                                <div class="choice-label"><?=$labels[$i-1]?></div>
                                <div class="flex-grow-1">
                                    <input type="text" name="OptChoice[]" class="form-control border-0 bg-light"
                                        placeholder="ระบุตัวเลือกคำตอบ" required style="border-radius: 8px;">
                                </div>
                                
                                <div class="ml-2">
                                    <label for="OrtionFile<?=$i?>" class="upload-trigger mb-0" title="เพิ่มรูปภาพตัวเลือก">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                    <input type="file" class="option-file-insert d-none" name="OptImg[]" id="OrtionFile<?=$i?>" accept="image/*">
                                </div>

                                <div class="correct-checkbox">
                                    <div class="custom-control custom-checkbox ml-2">
                                        <input type="checkbox" class="custom-control-input" id="OptAnswer<?=$i?>" name="OptAnswer[]" value="1">
                                        <label class="custom-control-label font-weight-bold text-xs" for="OptAnswer<?=$i?>">ถูก</label>
                                    </div>
                                </div>
                                <?php if($i > 2): // Allow deleting choices after first two ?>
                                <button type="button" class="btn btn-link text-danger ml-2 p-1" onclick="$(this).closest('.option-item').fadeOut(200, function(){ $(this).remove(); })">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                            
                            <div class="image-preview-wrapper mt-2 d-none" id="preview-box-<?=$i?>">
                                <img id="preview<?=$i?>" src="#" alt="">
                                <button type="button" class="btn-remove-img" onclick="removeOptionImg(<?=$i?>)" title="ลบรูปภาพ">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-link text-muted" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm" style="border-radius: 8px;">
                        <i class="fas fa-save mr-1"></i> บันทึกแบบทดสอบ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function getLabel(index) {
    var labels = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
    return labels[index] || (index + 1);
}

function addOption() {
    var container = $("#options-container");
    var id = container.find('.option-item').length + 1;
    var label = getLabel(id - 1);
    
    var html = `
        <div class="option-item d-flex flex-column" id="opt-item-${id}" style="display:none;">
            <div class="d-flex align-items-center">
                <div class="choice-label">${label}</div>
                <div class="flex-grow-1">
                    <input type="text" name="OptChoice[]" class="form-control border-0 bg-light"
                        placeholder="ระบุตัวเลือกคำตอบ" required style="border-radius: 8px;">
                </div>
                <div class="ml-2">
                    <label for="OrtionFile${id}" class="upload-trigger mb-0">
                        <i class="fas fa-camera"></i>
                    </label>
                    <input type="file" class="option-file-insert d-none" name="OptImg[]" id="OrtionFile${id}" accept="image/*">
                </div>
                <div class="correct-checkbox">
                    <div class="custom-control custom-checkbox ml-2">
                        <input type="checkbox" class="custom-control-input" id="OptAnswer${id}" name="OptAnswer[]" value="1">
                        <label class="custom-control-label font-weight-bold text-xs" for="OptAnswer${id}">ถูก</label>
                    </div>
                </div>
                <button type="button" class="btn btn-link text-danger ml-2 p-1" onclick="removeOption(this)">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
            <div class="image-preview-wrapper mt-2 d-none" id="preview-box-${id}">
                <img id="preview${id}" src="#" alt="">
                <button type="button" class="btn-remove-img" onclick="removeOptionImg(${id})" title="ลบรูปภาพ">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>`;
    
    var $newOption = $(html);
    container.append($newOption);
    $newOption.fadeIn(300);
}

function UpdateaddOption() {
    var container = $("#Update-options-container");
    var id = container.find('.option-item').length + 1;
    var label = getLabel(id - 1);
    
    var html = `
        <div class="option-item d-flex flex-column" id="up-opt-item-${id}" style="display:none;">
            <div class="d-flex align-items-center">
                <div class="choice-label">${label}</div>
                <div class="flex-grow-1">
                    <input type="text" name="UpdateOptChoice[]" class="form-control border-0 bg-light"
                        placeholder="ระบุตัวเลือกคำตอบ" required style="border-radius: 8px;">
                </div>
                <div class="ml-2">
                    <label for="UP-OrtionFile${id}" class="upload-trigger mb-0">
                        <i class="fas fa-camera"></i>
                    </label>
                    <input type="file" class="option-file-Update d-none" name="OptImg[]" id="UP-OrtionFile${id}" accept="image/*">
                    <input type="hidden" name="UpdateOptImgDelete[]" class="opt-img-delete" value="0">
                </div>
                <div class="correct-checkbox">
                    <div class="custom-control custom-checkbox ml-2">
                        <input type="checkbox" class="custom-control-input" id="UpdateOptAnswer${id}" name="UpdateOptAnswer[]" value="1">
                        <label class="custom-control-label font-weight-bold text-xs" for="UpdateOptAnswer${id}">ถูก</label>
                    </div>
                </div>
                <button type="button" class="btn btn-link text-danger ml-2 p-1" onclick="removeOption(this)">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
            <div class="image-preview-wrapper mt-2 d-none" id="up-preview-box-${id}">
                <img id="OptionPreviwe${id}" src="#" alt="">
                <button type="button" class="btn-remove-img" onclick="removeUpdateOptionImg(${id})" title="ลบรูปภาพ">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>`;
    
    var $newOption = $(html);
    container.append($newOption);
    $newOption.fadeIn(300);
}

function removeOption(btn) {
    $(btn).closest('.option-item').fadeOut(200, function(){ $(this).remove(); });
}

function removeOptionImg(id) {
    $('#OrtionFile' + id).val(null);
    $('#preview' + id).attr('src', '#');
    $('#preview-box-' + id).addClass('d-none');
}

function removeUpdateOptionImg(id) {
    $('#UP-OrtionFile' + id).val(null);
    $('#up-opt-item-' + id).find('.opt-img-delete').val('1');
    $('#OptionPreviwe' + id).attr('src', '#');
    $('#up-preview-box-' + id).addClass('d-none');
}

$(document).on("change", ".custom-file-input", function() {
    var file = $(this)[0].files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').attr('src', e.target.result);
            $('#q-preview-box').removeClass('d-none');
        }
        reader.readAsDataURL(file);
    }
});

$(document).on("change", ".custom-file-input-Update", function() {
    var file = $(this)[0].files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#UpdateimagePreview').attr('src', e.target.result);
            $('#up-q-preview-box').removeClass('d-none');
        }
        reader.readAsDataURL(file);
    }
});

$(document).on("click", "#removeButton", function() {
    $('#customFile').val(null);
    $('#q-preview-box').addClass('d-none');
    $('#imagePreview').attr('src', '#');
});

$(document).on("click", "#UpdateremoveButton", function() {
    $('#UpdatecustomFile').val(null);
    $('#UpdateQuestionImgDelete').val('1');
    $('#up-q-preview-box').addClass('d-none');
    $('#UpdateimagePreview').attr('src', '#');
});

$(document).on('change', '.option-file-insert', function(e) {
    var inputId = $(this).attr('id');
    var idNum = inputId.match(/\d+/)[0];
    var file = this.files[0];
    if (file && /(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#preview' + idNum).attr('src', e.target.result);
            $('#preview-box-' + idNum).removeClass('d-none');
        }
        reader.readAsDataURL(file);
    }
});

$(document).on('change', '.option-file-Update', function(e) {
    var inputId = $(this).attr('id');
    var idNum = inputId.match(/\d+/)[0];
    var file = this.files[0];
    if (file && /(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#OptionPreviwe' + idNum).attr('src', e.target.result);
            $('#up-preview-box-' + idNum).removeClass('d-none');
        }
        reader.readAsDataURL(file);
    }
});

// Correct Answer Visual Feedback
$(document).on('change', '.custom-control-input', function() {
    if($(this).is(':checked')) {
        $(this).closest('.option-item').addClass('is-correct');
    } else {
        $(this).closest('.option-item').removeClass('is-correct');
    }
});
// Reset Form Create when closed
$('#exampleModal').on('hidden.bs.modal', function () {
    let form = $('#FormInsertQuizzes');
    form[0].reset();
    form.find('.is-correct').removeClass('is-correct');
    form.find('.image-preview-wrapper').addClass('d-none');
    form.find('img').attr('src', '#');
    
    // Restore default 4 options if some were deleted/added
    let container = $('#options-container');
    container.empty();
    for (let i = 1; i <= 4; i++) {
        addOption();
    }
    // Remove the 'display:none' from the first 4 since addOption adds them with fade
    container.find('.option-item').show();
});

// Reset Form Edit when closed
$('#ModelUpdateQuiz').on('hidden.bs.modal', function () {
    let form = $('#FormUpdateQuizzes');
    form[0].reset();
    form.find('.is-correct').removeClass('is-correct');
    form.find('.image-preview-wrapper').addClass('d-none');
    form.find('img').attr('src', '#');
    $('#Update-options-container').empty();
});
</script>



<!-- Modal Edit -->
<div class="modal fade" id="ModelUpdateQuiz" tabindex="-1" aria-labelledby="ModelUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);">
                <h5 class="modal-title d-flex align-items-center" id="ModelUpdateLabel">
                    <i class="fas fa-edit mr-2"></i> แก้ไขแบบทดสอบ
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="FormUpdateQuizzes" enctype="multipart/form-data" class="needs-validation" novalidate>
                <input type="hidden" id="UpdateQuestionID" name="UpdateQuestionID" value="">
                <div class="modal-body">
                    
                    <!-- Question Section -->
                    <div class="question-section">
                        <label class="font-weight-bold text-warning mb-3"><i class="fas fa-question-circle mr-1"></i> โจทย์คำถาม</label>
                        <div class="row">
                            <div class="col-md-9">
                                <textarea id="UpdateQuestionText" name="UpdateQuestionText" class="form-control form-control-lg" 
                                    rows="3" required style="border-radius: 10px;"></textarea>
                                <div class="invalid-feedback">กรุณาตั้งคำถาม</div>
                            </div>
                            <div class="col-md-3 d-flex flex-column align-items-center justify-content-center border-left">
                                <span class="text-xs text-muted mb-2">เปลี่ยนรูปภาพ</span>
                                <div class="upload-trigger" onclick="document.getElementById('UpdatecustomFile').click();">
                                    <i class="fas fa-image"></i> อัปโหลดใหม่
                                </div>
                                <input type="file" class="custom-file-input-Update d-none" name="UpdateQuestionImg" id="UpdatecustomFile" accept="image/*">
                                <input type="hidden" name="UpdateQuestionImgDelete" id="UpdateQuestionImgDelete" value="0">
                            </div>
                        </div>
                        <div class="image-preview-wrapper mt-3" id="up-q-preview-box">
                            <img id="UpdateimagePreview" src="#" alt="Preview">
                            <button type="button" class="btn-remove-img" id="UpdateremoveButton" title="ลบรูปภาพ">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <label class="font-weight-bold text-dark m-0"><i class="fas fa-list-ul mr-1"></i> ตัวเลือกคำตอบ</label>
                        <button type="button" class="btn btn-sm btn-outline-warning" onclick="UpdateaddOption()">
                            <i class="fas fa-plus"></i> เพิ่มตัวเลือก
                        </button>
                    </div>

                    <div id="Update-options-container">
                        <!-- Options will be loaded via AJAX from JsQuizzes.js -->
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-link text-muted" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-warning px-4 shadow-sm text-dark font-weight-bold" style="border-radius: 8px;">
                        <i class="fas fa-save mr-1"></i> บันทึกการแก้ไข
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>