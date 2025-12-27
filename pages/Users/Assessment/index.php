<?php 
include_once '../../../php/Database/Database.php'; 
include_once '../../Users/PhpClass/ClassLearn.php';
include_once '../../Users/PhpClass/ClassAssessment.php';
$database = new Database();
$db = $database->getConnection();
$Course = new ClassLearn($db);
$Assessment = new ClassAssessment($db);
$Title = $Course->TitleBar;
$Resutl = $Course->readLessonsAll(@$_GET['Course']);
$ResutlSing = $Course->readLessonsAll1(@$_GET['Course']);
$LesSing = $Course->readLessonsSingle(@$_GET['Course'],@$_GET['Leeson']);
$rowLesMain = $ResutlSing->fetch(PDO::FETCH_ASSOC);
$rowLesSingTitle = $LesSing->fetch(PDO::FETCH_ASSOC);


$QuestionAll = $Assessment->ReadQuestionAll();
$CheckAssessment = $Assessment->CheckAssessment(@$_GET['Course']);
//print_r($CheckAssessment);exit();
?>


<?php include_once('../../../pages/Users/Layout/HeaderUser.php') ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include_once('../../../pages/Users/Layout/NavbarTopUser.php') ?>
        <?php include_once('../../../pages/Users/Layout/NavbarLeftUser.php') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper mb-5">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <h2>แบบประเมินความพึงพอใจของผู้เข้าเรียน</h2>
                    <hr>

                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <form   id="<?= $CheckAssessment > 0 ?"FormAssessmentUpdate":"FormAssessmentInsert"?>" method="post">
                                <input type="hidden" name="CourseID" id="CourseID"  value="<?=$_GET['Course']?>">
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-center  align-content-center">
                                                <th rowspan="2">ข้อ</th>
                                                <th rowspan="2">รายการ</th>
                                                <th colspan="5">ระดับความคิดเห็น</th>
                                            </tr>
                                            <tr class="text-center">
                                                <th>5</th>
                                                <th>4</th>
                                                <th>3</th>
                                                <th>2</th>
                                                <th>1</th>
                                            </tr>
                                            <?php $num = 1;
                                    while($row = $QuestionAll->fetch(PDO::FETCH_ASSOC)) : 
                                       
                                        $EditAssessment = $Assessment->EditAssessment(@$_GET['Course'],$row['ass_question_id']);
                                        //echo "<pre>";print_r($EditAssessment);
                                        if($row['ass_question_type'] == 'rating'):
                                    ?>

                                            <tr>
                                                <td class="text-center"><?=$row['ass_question_article']?></td>
                                                <td><?=$row['ass_question_text']?> </td>
                                                <?php for ($i=5; $i >= 1; $i--): ?>
                                                <td>
                                                    
                                                    <input required type="radio" name="<?=$row['ass_question_id']?>" id="<?=$row['ass_question_id']?>"
                                                        class="form-control" value="<?=$i;?>" <?=@$EditAssessment['response_rating'] == $i ?"checked":""?>>
                                                </td>
                                                <?php endfor; ?>

                                            </tr>

                                            <?php elseif($row['ass_question_type'] == 'text'): ?>
                                            <tr>
                                                <td  colspan="7">
                                                    <h6><?=$row['ass_question_text']?></h6>
                                                    <textarea name="<?=$row['ass_question_id']?>" id="<?=$row['ass_question_id']?>" rows="3" cols="20" class="form-control">
                                                    <?=@$EditAssessment['response_text']?>
                                                    </textarea>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                            <?php $num++; endwhile; ?>
                                        </thead>
                                    </table>
                                    <div class="d-flex justify-content-center mt-3">
                                        <button type="submit" class="btn btn-primary">บันทึก</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>

                    </div>



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