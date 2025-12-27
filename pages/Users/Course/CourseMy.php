<?php 
include_once '../../../php/Database/Database.php'; 
include_once '../../Users/PhpClass/ClassCourse.php';
include_once '../../Users/PhpClass/ClassAssessment.php';
$database = new Database();
$db = $database->getConnection();
$Course = new ClassCourse($db);
$Assessment = new ClassAssessment($db);
$Title = "คอร์สเรียนของฉัน | Lessons Online";

$stmt = $Course->CourseMy();
?>
<?php include_once('../../../pages/Users/Layout/HeaderUser.php') ?>

<style>
    .my-course-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        padding: 40px 0 80px;
        color: white;
        margin-bottom: -40px;
    }

    .course-progress-card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--shadow-md);
        margin-bottom: 20px;
        border: 1px solid #f1f5f9;
        overflow: hidden;
        transition: transform 0.2s;
    }

    .course-progress-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .card-thumb {
        width: 100%;
        aspect-ratio: 16/9;
        object-fit: cover;
    }

    .progress-pill {
        height: 8px;
        border-radius: 10px;
        background: #f1f5f9;
        overflow: hidden;
        margin: 15px 0;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #10b981, #34d399);
        border-radius: 10px;
        transition: width 1s ease-in-out;
    }

    .action-btn-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        padding: 15px;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
    }

    @media (max-width: 768px) {
        .my-course-header { padding: 30px 0 60px; }
        .course-progress-card { border-radius: 16px; }
    }

    .btn-action {
        width: 100%;
        border-radius: 12px;
        font-weight: 600;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: 0.9rem;
    }

    .status-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        backdrop-filter: blur(8px);
        background: rgba(255,255,255,0.9);
        color: var(--text-dark);
        box-shadow: var(--shadow-sm);
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 30px;
        box-shadow: var(--shadow-md);
    }
</style>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <?php include_once('../../../pages/Users/Layout/NavbarHomeUser.php') ?>

        <div class="content-wrapper">
            <div class="my-course-header">
                <div class="container text-center">
                    <h1 class="text-white mb-2">บทเรียนของฉัน</h1>
                    <p class="opacity-80">ติดตามความก้าวหน้าและความสำเร็จของคุณ</p>
                </div>
            </div>

            <section class="content py-5">
                <div class="container">
                    <div class="row">
                        <?php 
                        $hasCourses = false;
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                            $hasCourses = true;
                            $CourseProgress = $Course->CourseProgress($row['CourseID']);
                            $LessonsTotal = $Course->LessonsTotal($row['CourseID'])->fetch(PDO::FETCH_ASSOC);
                            $ValCourseProgress = $CourseProgress->fetch(PDO::FETCH_ASSOC);
                            $CheckDoAssessment = $Course->CheckDoAssessment($row['CourseID']);
                            
                            $ValProgressAll = $LessonsTotal['TotalLessons'] > 0 ? ROUND((($ValCourseProgress['completed_lessons']/$LessonsTotal['TotalLessons'])*100),2) : 0;
                            
                            $isCompleted = ($ValCourseProgress['completed_lessons'] == $LessonsTotal['TotalLessons'] && $LessonsTotal['TotalLessons'] > 0);
                            $doneAssessment = ($CheckDoAssessment['DoAssessment'] > 0);
                        ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="course-progress-card position-relative">
                                <img src="../../../uploads/Course/<?=$row['CourseImage'];?>" class="card-thumb" onerror="this.src='../../../dist/img/photo1.png'">
                                
                                <?php if($doneAssessment): ?>
                                    <div class="status-badge text-success"><i class="fas fa-check-circle mr-1"></i> สำเร็จแล้ว</div>
                                <?php elseif($isCompleted): ?>
                                    <div class="status-badge text-warning"><i class="fas fa-star mr-1"></i> รอประเมิน</div>
                                <?php endif; ?>

                                <div class="p-4">
                                    <h5 class="mb-1 text-truncate" title="<?=$row['CourseName']?>"><?=$row['CourseName']?></h5>
                                    <p class="text-muted small mb-3"><i class="fas fa-user-graduate mr-1"></i> <?=$_SESSION['FullName']?></p>

                                    <div class="d-flex justify-content-between align-items-end mb-1">
                                        <span class="small font-weight-bold text-primary"><?=$ValProgressAll?>%</span>
                                        <span class="small text-muted"><?=$ValCourseProgress['completed_lessons']?> / <?=$LessonsTotal['TotalLessons']?> บทเรียน</span>
                                    </div>
                                    <div class="progress-pill">
                                        <div class="progress-fill" style="width: <?=$ValProgressAll?>%"></div>
                                    </div>
                                </div>

                                <div class="action-btn-group">
                                    <a href="../Learn/?Course=<?=$row['CourseID']?>" class="btn btn-primary btn-action">
                                        <i class="fas fa-play"></i> <?= $ValProgressAll > 0 ? 'เรียนต่อ' : 'เริ่มเรียน' ?>
                                    </a>

                                    <?php if(!$isCompleted): ?>
                                        <button class="btn btn-light btn-action text-muted" disabled>
                                            <i class="fas fa-lock"></i> แบบประเมิน
                                        </button>
                                    <?php else: ?>
                                        <a href="../Assessment?Course=<?=$row['CourseID']?>" class="btn btn-success btn-action">
                                            <i class="fas fa-clipboard-check"></i> แบบประเมิน
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if($isCompleted && $doneAssessment): ?>
                                        <div class="col-12 mt-2 px-0">
                                            <a href="Certificate/LoadCertificate.php?CourseID=<?=$row['CourseID']?>" target="_blank" class="btn btn-warning btn-action font-weight-bold w-100">
                                                <i class="fas fa-award"></i> ดาวน์โหลดเกียรติบัตร
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>

                        <?php if(!$hasCourses): ?>
                            <div class="col-12">
                                <div class="empty-state">
                                    <img src="../../../dist/img/AdminLTELogo.png" style="width: 100px; opacity: 0.3; filter: grayscale(1);" class="mb-4">
                                    <h3>คุณยังไม่มีคอร์สเรียน</h3>
                                    <p class="text-muted">สำรวจคอร์สเรียนที่น่าสนใจและเริ่มพัฒนาตนเองได้เลย</p>
                                    <a href="../Home/HomeMain" class="btn btn-primary btn-lg rounded-pill px-5 mt-3 shadow-sm">ดูคอร์สเรียนทั้งหมด</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>

        <?php include_once('../../../pages/Users/Layout/FooterUser.php'); ?>
    </div>
</body>
</html>