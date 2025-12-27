<?php 
include_once '../../../php/Database/Database.php'; 
include_once '../../Users/PhpClass/ClassLearn.php';
include_once '../../Users/PhpClass/ClassCourse.php';
$database = new Database();
$db = $database->getConnection();
$Course = new ClassLearn($db);
$CourseMain = new ClassCourse($db);

$Title = $Course->TitleBar;
$Resutl = $Course->readLessonsAll(@$_GET['Course']);
$ResutlSing = $Course->readLessonsAll1(@$_GET['Course']);
$LesSing = $Course->readLessonsSingle(@$_GET['Course'],@$_GET['Leeson']);

$rowLesMain = $ResutlSing->fetch(PDO::FETCH_ASSOC);

$rowLesSingTitle = $LesSing->fetch(PDO::FETCH_ASSOC);

$CheckExamBefore = $Course->LessonsCheckExamBefore(@$_GET['Course'],@$_GET['Leeson']);

$LessonsTotal = $CourseMain->LessonsTotal(@$_GET['Course'])->fetch(PDO::FETCH_ASSOC);
$CourseProgress = $CourseMain->CourseProgress(@$_GET['Course'])->fetch(PDO::FETCH_ASSOC);


if(!empty($_GET['Leeson'])){   
     $CheckEnroll = $Course->LessonsProgressInsert(@$_GET['Course'],@$_GET['Leeson']);
}
?>

<!-- ค่ารหัสตารางเรียน -->
<input type="hidden" id="LessProID" name="LessProID" value="<?=$CheckEnroll?>">
<input type="hidden" id="CourseID" name="CourseID" value="<?=@$_GET['Course']?>">
<input type="hidden" id="LeesonID" name="LeesonID" value="<?=@$_GET['Leeson']?>">
<input type="hidden" id="LessonStudyTime" name="LessonStudyTime" value="<?=$rowLesSingTitle['LessonStudyTime']?>">
<?php include_once('../../../pages/Users/Layout/HeaderUser.php') ?>
<style>
iframe {
    width: 100%;
    height: 500px;
}

#countdown {
    position: relative;
    width: 60px;
    height: 60px;
}

#countdown svg {
    transform: rotate(-90deg);
    width: 60px;
    height: 60px;
}

#countdown circle {
    fill: none;
    stroke-width: 5;
    stroke: #4CAF50;
    stroke-dasharray: 314;
    /* Circumference of the circle (2 * π * r) */
    stroke-dashoffset: 314;
    /* Initially set to full circumference */
    transition: stroke-dashoffset 0.5s;
}

#number {
    position: absolute;
    top: 45%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 14px;
}
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include_once('../../../pages/Users/Layout/NavbarTopUser.php') ?>
        <?php include_once('../../../pages/Users/Layout/NavbarLeftUser.php') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper mb-5">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <?php if(empty($_GET['Leeson'])): ?>
                    <div class="vh-100 d-flex justify-content-center align-items-center">
                        <div>
                            <h1>ยินดีต้อนรับ</h1>
                            <p>โปรดเลือกเนื้อหาที่ต้องการเรียนจากสารบัญ</p>
                            <i class="fas fa-arrow-left"></i>
                        </div>
                    </div>
                    <?php else:?>

                    <?php if($CheckExamBefore === 0): ?>
                                <div class="vh-100 d-flex justify-content-center align-items-center">
                                    <a class="btn btn-primary" href="../Quizzes/?Course=<?=@$_GET['Course']?>&Leeson=<?=@$_GET['Leeson']?>&AnswerCategory=ก่อนเรียน">แบบทดสอบก่อนเรียน</a>
                                </div>
                      
                    <?php else : ?>
                    <h2>บทที่ <?=$rowLesSingTitle['LessonNo']?> <?=$rowLesSingTitle['LessonTitle']?></h2>
                    <hr>
                    <?=$rowLesSingTitle['LessonContent']?>
                    <?php if(!empty($_GET['Leeson'])):?>
                    <footer class="main-footer fixed-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong>เวลาที่เรียน <span
                                    id="RoundTime"></span>/<?=$rowLesSingTitle['LessonStudyTime'] ?? 0?>
                                นาที</strong>
                            <strong>

                                <div id="countdown">
                                    <svg>
                                        <circle r="20" cx="30" cy="30"></circle>
                                    </svg>
                                    <div id="number">00:00</div>
                                </div>
                            </strong>
                            <div class="float-right">
                               
                                <a href="../Quizzes/?Course=<?=@$_GET['Course']?>&Leeson=<?=@$_GET['Leeson']?>&AnswerCategory=หลังเรียน"
                                    class="btn btn-primary btn-sm" id="btnQuiz"><b>ทำแบบทดสอบ</b></a>
                            </div>
                        </div>
                    </footer>
                    <?php endif; ?>

                    <?php endif; ?>

                    <?php endif; ?>

                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->




        <?php include_once('../../../pages/Users/Layout/FooterUser.php'); ?>
</body>

</html>


<script>
// $(document).on("click", ".reloadButton", function(event) {
//     event.preventDefault();
//     Swal.fire({
//         title: "ในแต่ละบทมีเวลากำหนด เมื่ออยู่ครบเวลาจะสามารถทำแบบทดสอบและไปบทถัดไปได้",

//     }).then((result) => {
//         /* Read more about isConfirmed, isDenied below */
//         if (result.isConfirmed) {
//             window.location.href = event.target.href;;
//         }
//     });

// });
</script>