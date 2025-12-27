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
?>


<?php include_once('../../../pages/Users/Layout/HeaderUser.php') ?>

<style>
    /* Custom Radio Buttons for Ratings */
    .rating-options {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .rating-item {
        position: relative;
    }

    .rating-item input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .rating-label {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background-color: #f1f5f9;
        color: var(--text-muted);
        font-weight: 600;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .rating-item input[type="radio"]:checked + .rating-label {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
    }

    .rating-item:hover .rating-label {
        background-color: #e2e8f0;
        transform: translateY(-2px);
    }

    .rating-item input[type="radio"]:checked + .rating-label:hover {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        transform: scale(1.1) translateY(-2px);
    }

    .question-card:hover {
        transform: translateY(-2px);
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include_once('../../../pages/Users/Layout/NavbarTopUser.php') ?>
        <?php include_once('../../../pages/Users/Layout/NavbarLeftUser.php') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper mb-5">
            <!-- Content Header (Page header) -->
            <div class="content-header pt-4">
                <div class="container-fluid">
                    
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-10">
                            
                            <div class="text-center mb-5 fade-in-up">
                                <h1 class="display-4 font-weight-bold text-dark mb-2" style="font-size: 2.5rem;">แบบประเมินความพึงพอใจ</h1>
                                <p class="lead text-muted">ความคิดเห็นของท่านมีค่า เพื่อการพัฒนาการสอนให้ดียิ่งขึ้น</p>
                                <div class="mt-3">
                                    <span class="badge badge-light px-3 py-2 text-primary" style="font-size: 0.9rem; border-radius: 20px; box-shadow: var(--shadow-sm);">
                                        <i class="fas fa-book-reader mr-2"></i> คอร์สเรียนที่กำลังประเมิน
                                    </span>
                                </div>
                            </div>

                            <form id="<?= $CheckAssessment > 0 ?"FormAssessmentUpdate":"FormAssessmentInsert"?>" method="post">
                                <input type="hidden" name="CourseID" id="CourseID" value="<?=$_GET['Course']?>">
                                
                                <div class="questions-container">
                                    <?php 
                                    $num = 1;
                                    // Reset pointer if needed or re-query if PDO fetch consumes it effectively (assuming $QuestionAll is traversable)
                                    // Using standard while loop as per original code
                                    while($row = $QuestionAll->fetch(PDO::FETCH_ASSOC)) : 
                                        $EditAssessment = $Assessment->EditAssessment(@$_GET['Course'],$row['ass_question_id']);
                                    ?>

                                    <?php if($row['ass_question_type'] == 'rating'): ?>
                                    <div class="card mb-4 border-0 shadow-sm question-card" style="border-radius: 20px; overflow: visible;">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-start mb-4">
                                                <div class="mr-3">
                                                    <span class="d-flex justify-content-center align-items-center bg-light text-primary font-weight-bold rounded-circle" 
                                                          style="width: 32px; height: 32px; font-size: 1rem;">
                                                        <?=$row['ass_question_article']?>
                                                    </span>
                                                </div>
                                                <div>
                                                    <h5 class="font-weight-bold text-dark mb-1" style="line-height: 1.6;"><?=$row['ass_question_text']?></h5>
                                                </div>
                                            </div>

                                            <div class="bg-white rounded-xl p-3 border-0" style="background: #f8fafc;">
                                                <div class="d-flex justify-content-between align-items-center mb-2 px-2">
                                                    <small class="text-muted font-weight-bold">น้อยที่สุด (1)</small>
                                                    <small class="text-muted font-weight-bold">มากที่สุด (5)</small>
                                                </div>
                                                
                                                <div class="rating-options">
                                                    <!-- Reverse loop for visual layout if needed, but flex-row is standard 1->5 or 5->1 depending on UI/UX preference. 
                                                         Original code had 5 to 1. Let's do 1 to 5 for natural reading LTR, or stick to logic.
                                                         Let's render 1 to 5 for standard scale UI. -->
                                                    <?php for ($i=1; $i <= 5; $i++): ?>
                                                    <div class="rating-item" title="<?=$i?> คะแนน">
                                                        <input required type="radio" 
                                                               id="q_<?=$row['ass_question_id']?>_<?=$i?>" 
                                                               name="<?=$row['ass_question_id']?>" 
                                                               value="<?=$i?>"
                                                               <?=@$EditAssessment['response_rating'] == $i ?"checked":""?>>
                                                        <label class="rating-label mb-0" for="q_<?=$row['ass_question_id']?>_<?=$i?>">
                                                            <?=$i?>
                                                        </label>
                                                    </div>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php elseif($row['ass_question_type'] == 'text'): ?>
                                    <div class="card mb-4 border-0 shadow-sm question-card" style="border-radius: 20px;">
                                        <div class="card-body p-4">
                                            <h5 class="font-weight-bold text-dark mb-3">
                                                <i class="fas fa-comment-dots text-secondary mr-2"></i> <?=$row['ass_question_text']?>
                                            </h5>
                                            <div class="form-group mb-0">
                                                <textarea name="<?=$row['ass_question_id']?>" 
                                                          id="<?=$row['ass_question_id']?>" 
                                                          rows="4" 
                                                          class="form-control border-0 bg-light" 
                                                          style="border-radius: 15px; resize: none;" 
                                                          placeholder="แสดงความคิดเห็นเพิ่มเติมของคุณที่นี่..."><?=@$EditAssessment['response_text']?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                    <?php $num++; endwhile; ?>
                                </div>

                                <div class="row mt-5 mb-5">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-lg px-5 py-3 shadow-lg" style="border-radius: 50px; font-size: 1.1rem; min-width: 200px;">
                                            <i class="fas fa-paper-plane mr-2"></i> บันทึกผลการประเมิน
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

        </div>
        <!-- /.content-wrapper -->

        <?php include_once('../../../pages/Users/Layout/FooterUser.php'); ?>
    </div>
</body>
</html>