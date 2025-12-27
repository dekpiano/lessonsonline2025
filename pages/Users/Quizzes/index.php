<?php 
include_once '../../../php/Database/Database.php'; 
include_once '../../Users/PhpClass/ClassLearn.php';
include_once '../../Users/PhpClass/ClassQuizzesUser.php';
include_once '../../Users/PhpClass/ClassCourse.php';
$database = new Database();
$db = $database->getConnection();
$Course = new ClassLearn($db);
$Quiz = new ClassQuizzesUser($db);
$CourseMain = new ClassCourse($db);

$Title = $Course->TitleBar;
$Resutl = $Course->readLessonsAll(@$_GET['Course']); //เมนูซ้าย
$ResutlSing = $Course->readLessonsSingle(@$_GET['Course'],@$_GET['Leeson']);
$rowLesMain = $ResutlSing->fetch(PDO::FETCH_ASSOC); //เนื้อหาแต่ละบท
// $LesSing = $Course->readLessonsAll(@$_GET['Course']);
// $rowLesSing = $LesSing->fetch(PDO::FETCH_ASSOC);

//$rowLesSingTitle = $LesSing->fetch(PDO::FETCH_ASSOC);

$ShowQuiz = $Quiz->readQuiz(@$_GET['Course'],@$_GET['Leeson']); // คำตอบ
$ViewLatestExamRound = $Quiz->ViewLatestExamRound($rowLesMain['LessonID'],@$_GET['AnswerCategory']);
$Viewscore = $Quiz->Viewscore($rowLesMain['LessonID'],@$ViewLatestExamRound['UserAnswerExamRound'],@$_GET['AnswerCategory']);
if($Viewscore['CountAll'] == 0){
    $CountAll = 1;
}else{
    $CountAll = $Viewscore['CountAll'];
}

$ViewAnswerIsCorrect = $Quiz->ViewAnswerIsCorrect($rowLesMain['LessonID'],@$ViewLatestExamRound['UserAnswerExamRound'],@$_GET['AnswerCategory']);

$CourseProgress = $CourseMain->CourseProgress(@$_GET['Course'])->fetch(PDO::FETCH_ASSOC);
?>
<?php include_once('../../../pages/Users/Layout/HeaderUser.php') ?>

<style>
/* ซ่อน radio buttons แท้จริง */
input[type="radio"] {
    display: none;
}

/* สร้างรูปลักษณ์ของปุ่ม radio */
.radio-button {
    display: inline-block;
    background-color: #ffffff;
    color: black;
    padding: 17px 25px;
    border: 2px solid #000;
    border-radius: 5px;
    cursor: pointer;
}

/* การเลือก radio button แล้ว */
input[type="radio"]:checked+label {
    background-color: #007bff;
    color: #ffffff;
}

input[type="radio"]:hover+label {
    background-color: #007bff;
    color: #ffffff;
}

/* สร้างลักษณะของ label เพื่อกำหนดรูปลักษณ์ของปุ่ม */
.radio-button-label {
    display: inline-block;
    padding: 17px 25px;
    border-radius: 5px;
    cursor: pointer;
}
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include_once('../../../pages/Users/Layout/NavbarTopUser.php') ?>
        <?php include_once('../../../pages/Users/Layout/NavbarLeftUser.php') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">แบบทดสอบ บทที่ <?=$rowLesMain['LessonNo']?> <?=$rowLesMain['LessonTitle']?>
                            </h1>
                            <h5>( <?=@$Viewscore['SumScore']?>/<?=$Viewscore['CountAll']?> คะแนน คิดเป็น 
                            <?php $P = number_format(((@$Viewscore['SumScore']/$CountAll)*100),2) ?>
                            <?=$P == 0 ?"0":$P;?>%)
                        </h5>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="javascript:history.go(-1)"><i
                                            class="fas fa-arrow-left"></i> กลับหน้าบทเรียน</a></li>
                                <li class="breadcrumb-item active">แบบทดสอบ</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <form id="FormCheckAnswers" class="needs-validation" novalidate>

                        <?php $i = 1; while ($row = $ShowQuiz->fetch(PDO::FETCH_ASSOC)) : ?>
                        <input type="hidden" id="QuestionID" name="QuestionID[]" value="<?=$row['QuestionID']?>">
                        <input type="hidden" id="UserAnswerCategory" name="UserAnswerCategory"
                            value="<?=$_GET['AnswerCategory']?>">

                        <?php $CheckAnsFull =  explode('|',$row['OptAnswerArray'])?>
                        <div class="card">
                            <div class="QuestionText card-header bg-gradient-secondary h4">
                                <?=$i?>. <?= $row['QuestionText'];?>
                            </div>
                            <?php if($row['QuestionImg'] != ''): ?>
                            <div class="mt-2 text-center">
                                <img src="../../../uploads/Question/<?= $row['QuestionImg'];?>" class="img-fluid"
                                    alt="">
                            </div>
                            <?php endif;?>

                            <div class="card-body">

                                <div class="row">
                                    <?php foreach (explode('|',$row['OptChoiceArray']) as $key => $value): ?>
                                    <?php if($key == 0):?>
                                    <input type="hidden" id="UserAnswerExamRound" name="UserAnswerExamRound"
                                        value="<?=@$ViewAnswerIsCorrect[$row['QuestionID']][2]+1?>">
                                    <?php endif; ?>
                                    <?php if($value == @$ViewAnswerIsCorrect[$row['QuestionID']][0] && (@$ViewAnswerIsCorrect[$row['QuestionID']][1] == 1 && $CheckAnsFull[$key] == 1)){
                                            $Checked = "checked";
                                            $style = "style='background-color: #28a745;'";
                                            $Is = "&#10004";
                                        }else {
                                            $Checked = "";
                                            $style = "";
                                            $Is = "";
                                        }

                                        if($value == @$ViewAnswerIsCorrect[$row['QuestionID']][0] && (@$ViewAnswerIsCorrect[$row['QuestionID']][1] == 0 && $CheckAnsFull[$key] == 0)){
                                            $Checked = "checked";
                                            $style = "style='background-color: #dc3545;'";
                                            $Is ="&#10007";
                                        }
                                        
                                        ?>
                                    <div class="col-md-6">
                                        <input type="radio" id="<?=$row['QuestionID'].$key;?>"
                                            name="OptChoice<?=$row['QuestionID']?>" value="<?=$value;?>" required
                                            <?=$Checked?>>
                                        <label for="<?=$row['QuestionID'].$key;?>" key_main="<?=$i?>"
                                            class="R<?=$i?> radio-button-label radio-button w-100" <?=$style?>>
                                            <div class="d-flex justify-content-between">
                                                <?=$value?> <div class="mark<?=$i?>"><?=$Is;?></div>
                                            </div>
                                        </label>
                                        <?php $OptImg =  explode("|",$row['OptImgArray']); ?>
                                        <div class="mt-1 mb-1 text-center">
                                <img src="../../../uploads/Options/<?= $OptImg[$key];?>" style="width:200px"
                                    alt="">
                            </div>
                                        <div class="invalid-feedback">กรุณาเลือกคำตอบ!</div>
                                    </div>

                                    <?php endforeach; ?>

                                </div>
                            </div>
                        </div>
                        <?php $i++; endwhile; ?>
                        <div class="d-flex justify-content-between align-items-center">
                            <?php if($_GET['AnswerCategory'] == "ก่อนเรียน") :?>
                            <button type="submit" class="btn btn-success mb-5"
                                <?= ($ViewLatestExamRound['UserAnswerExamRound'] ?? 0) == 1 ?"disabled":""?>>ส่งคำตอบ</button>
                            <?php else: ?>
                            <div id="SendAnswer">
                                <div>
                                    ส่งคำตอบแล้ว <?=$ViewLatestExamRound['UserAnswerExamRound'] ?? 0?>/3 ครั้ง
                                </div>
                                <button type="submit" class="btn btn-success mb-5"
                                    <?= ($ViewLatestExamRound['UserAnswerExamRound'] ?? 0) >= 3 ?"disabled":""?>>ส่งคำตอบ</button>
                            </div>
                            <?php endif;?>

                            <div id="Next">
                                <?php if(($ViewLatestExamRound['UserAnswerExamRound'] ?? 0) > 0 && $_GET['AnswerCategory'] == "หลังเรียน"):?>
                                <a href="../Learn/?Course=<?=$_GET['Course']?>"
                                    class="btn btn-primary mb-5">เลือกบทถัดไป เมนูซ้าย</a>

                                <?php else : ?>
                                <a href="../Learn/?Course=<?=$_GET['Course']?>&Leeson=<?=$_GET['Leeson']?>"
                                    class="btn btn-primary mb-5">ถัดไป &#10230;</a>
                                <?php endif;?>
                            </div>
                        </div>
                </div>
                </form>

        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <?php include_once('../../../pages/Users/Layout/FooterUser.php'); ?>
</body>

</html>