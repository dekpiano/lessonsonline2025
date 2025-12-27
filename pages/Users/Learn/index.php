<?php 
include_once '../../../php/Database/Database.php'; 
include_once '../../Users/PhpClass/ClassLearn.php';
include_once '../../Users/PhpClass/ClassCourse.php';
$database = new Database();
$db = $database->getConnection();
$Course = new ClassLearn($db);
$CourseMain = new ClassCourse($db);

$Title = "บทเรียนออนไลน์ | SKJ";
$Resutl = $Course->readLessonsAll(@$_GET['Course']);
$ResutlSing = $Course->readLessonsAll1(@$_GET['Course']);
$LesSing = $Course->readLessonsSingle(@$_GET['Course'],@$_GET['Leeson']);

$rowLesMain = $ResutlSing->fetch(PDO::FETCH_ASSOC);
$rowLesSingTitle = $LesSing->fetch(PDO::FETCH_ASSOC);

$CheckExamBefore = $Course->LessonsCheckExamBefore(@$_GET['Course'],@$_GET['Leeson']);
$LessonsTotal = $CourseMain->LessonsTotal(@$_GET['Course'])->fetch(PDO::FETCH_ASSOC);
$CourseProgressData = $CourseMain->CourseProgress(@$_GET['Course'])->fetch(PDO::FETCH_ASSOC);

if(!empty($_GET['Leeson'])){   
     $CheckEnroll = $Course->LessonsProgressInsert(@$_GET['Course'],@$_GET['Leeson']);
}
?>

<input type="hidden" id="LessProID" name="LessProID" value="<?=$CheckEnroll?>">
<input type="hidden" id="CourseID" name="CourseID" value="<?=@$_GET['Course']?>">
<input type="hidden" id="LeesonID" name="LeesonID" value="<?=@$_GET['Leeson']?>">
<input type="hidden" id="LessonStudyTime" name="LessonStudyTime" value="<?=$rowLesSingTitle['LessonStudyTime']?>">

<?php include_once('../../../pages/Users/Layout/HeaderUser.php') ?>

<style>
    :root {
        --sidebar-width: 380px;
        --header-height: 70px;
    }

    body {
        background-color: white !important;
        overflow-x: hidden;
    }

    /* Modern Layout for LMS */
    .lms-layout {
        display: flex;
        flex-direction: column;
        height: 100vh;
    }

    .lms-header {
        height: var(--header-height);
        background: #1e293b;
        color: white;
        display: flex;
        align-items: center;
        padding: 0 20px;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1050;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    }

    .lms-sidebar {
        width: var(--sidebar-width);
        background: #f8fafc;
        border-right: 1px solid #e2e8f0;
        position: fixed;
        top: var(--header-height);
        bottom: 0;
        left: 0;
        overflow-y: auto;
        z-index: 1000;
        transition: transform 0.3s ease;
    }

    .lms-main {
        margin-left: var(--sidebar-width);
        margin-top: var(--header-height);
        flex-grow: 1;
        background: white;
        min-height: calc(100vh - var(--header-height));
        padding-bottom: 80px;
    }

    /* Content Styling */
    .content-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    /* Image Constraint - Fix User's Request */
    .lesson-body {
        width: 100%;
        overflow-x: hidden; /* Prevent horizontal scroll from large content */
    }

    .lesson-body img {
        max-width: 100% !important; /* Force all images to fit container width */
        height: auto !important;    /* Maintain aspect ratio */
        display: block;             /* Remove inline gap */
        margin: 20px auto;          /* Center images with spacing */
        border-radius: 12px;        /* Optional: Add slight rounding for aesthetics */
        box-shadow: var(--shadow-sm); /* Optional: Slight depth */
    }

    iframe {
        width: 100%;
        aspect-ratio: 16/9;
        border: none;
        border-radius: 16px;
        background: #000;
        box-shadow: var(--shadow-lg);
        margin-bottom: 30px;
    }

    /* Sidebar Content */
    .curriculum-header {
        padding: 20px;
        background: #f1f5f9;
        border-bottom: 1px solid #e2e8f0;
    }

    .lesson-link {
        display: flex;
        padding: 16px 20px;
        color: var(--text-dark);
        text-decoration: none !important;
        transition: all 0.2s;
        border-bottom: 1px solid #f1f5f9;
        align-items: center;
        gap: 15px;
    }

    .lesson-link:hover { background: white; }
    .lesson-link.active {
        background: #eff6ff;
        border-left: 4px solid var(--primary);
    }

    .lesson-link.completed .icon-box {
        background: #10b981;
        color: white;
        border-color: #10b981;
    }

    /* Timer & Controls */
    .timer-footer {
        position: fixed;
        bottom: 0;
        left: var(--sidebar-width);
        right: 0;
        height: 80px;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(10px);
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        padding: 0 40px;
        justify-content: space-between;
        z-index: 1040;
    }

    #countdown { position: relative; width: 50px; height: 50px; }
    #countdown svg { transform: rotate(-90deg); width: 50px; height: 50px; }
    #countdown circle {
        fill: none; stroke-width: 4; stroke: #10b981; 
        stroke-dasharray: 157; stroke-dashoffset: 157;
        transition: stroke-dashoffset 0.5s;
    }
    #number { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 11px; font-weight: 700; color: #1e293b; }

    /* Mobile Responsive */
    @media (max-width: 991px) {
        .lms-sidebar { transform: translateX(-100%); width: 100%; }
        .lms-sidebar.open { transform: translateX(0); }
        .lms-main { margin-left: 0; }
        .timer-footer { left: 0; padding: 0 15px; }
        .sidebar-toggle-btn { display: block !important; }
    }

    .sidebar-toggle-btn {
        display: none;
        background: #334155;
        border: none;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        margin-right: 15px;
    }
</style>

<body class="hold-transition">
    <div class="lms-layout">
        <!-- Persistent Header -->
        <header class="lms-header">
            <button class="sidebar-toggle-btn" onclick="document.querySelector('.lms-sidebar').classList.toggle('open')">
                <i class="fas fa-list-ul"></i>
            </button>
            <a href="../Course/CourseMy" class="text-white mr-auto d-flex align-items-center gap-2 text-decoration-none">
                <i class="fas fa-chevron-left"></i>
                <span class="d-none d-md-inline">กลับไปยังคอร์สของฉัน</span>
            </a>
            <div class="header-course-info text-center font-weight-bold d-none d-lg-block">
                <?=$rowLesMain['CourseName']?>
            </div>
            <div class="ml-auto d-flex align-items-center">
                <div class="progress-info d-none d-md-block mr-3 text-right">
                    <small class="opacity-70 d-block">ความคืบหน้า</small>
                    <span class="font-weight-bold"><?=$CourseProgressData['completed_lessons']?> / <?=$LessonsTotal['TotalLessons']?></span>
                </div>
            </div>
        </header>

        <!-- Sidebar Curriculum -->
        <aside class="lms-sidebar">
            <div class="curriculum-header">
                <h6 class="mb-0 font-weight-bold">สารบัญบทเรียน</h6>
            </div>
            <div class="lesson-list">
                <?php while($row = $Resutl->fetch(PDO::FETCH_ASSOC)) : 
                    $CheckStatusLesson = $Course->CheckStatusLesson($row['CourseID'],$row['LessonNo'])->fetch(PDO::FETCH_ASSOC);
                    $isCompleted = (@$CheckStatusLesson['LessProStatus'] == "เรียนสำเร็จ");
                    $isActive = (@$_GET['Leeson'] == $row['LessonNo']);
                ?>
                <a href="../Learn/?Course=<?=@$_GET['Course']?>&Leeson=<?=$row['LessonNo']?>" 
                   class="lesson-link <?= $isActive ? 'active' : '' ?> <?= $isCompleted ? 'completed' : '' ?>">
                    <div class="icon-box">
                        <?php if($isCompleted): ?>
                            <i class="fas fa-check"></i>
                        <?php else: ?>
                            <i class="fas fa-play small"></i>
                        <?php endif; ?>
                    </div>
                    <div class="flex-grow-1">
                        <small class="text-muted d-block">บทที่ <?=$row['LessonNo']?></small>
                        <h6 class="mb-0"><?=$row['LessonTitle']?></h6>
                    </div>
                </a>
                <?php endwhile; ?>

                <?php 
                $canAssess = (@$CourseProgressData['completed_lessons'] == @$CourseProgressData['total_lessons'] && @$CourseProgressData['total_lessons'] > 0);
                ?>
                <div class="p-4 mt-auto">
                    <a href="../Assessment?Course=<?=@$_GET['Course']?>" 
                       class="btn btn-block btn-success rounded-pill py-3 <?= $canAssess ? '' : 'disabled opacity-50' ?>">
                        <i class="fas fa-clipboard-check mr-2"></i> ทำแบบประเมินคอร์ส
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content Viewer -->
        <main class="lms-main">
            <div class="content-container">
                <?php if(empty($_GET['Leeson'])): ?>
                    <div class="text-center py-5">
                        <img src="../../../dist/img/AdminLTELogo.png" class="mb-4 opacity-50" style="width: 80px; filter: grayscale(1);">
                        <h2 class="font-weight-bold">ยินดีต้อนรับสู่บทเรียน</h2>
                        <p class="text-muted lead">คลิกเลือกบทเรียนจากทางซ้าย เพื่อเริ่มต้นการเรียนรู้ของคุณ</p>
                    </div>
                <?php else: ?>
                    <?php if($CheckExamBefore === 0): ?>
                        <div class="card p-5 text-center shadow-lg border-0" style="border-radius: 24px;">
                            <div class="mb-4 text-primary">
                                <i class="fas fa-file-signature fa-4x"></i>
                            </div>
                            <h3 class="font-weight-bold mb-3">แบบทดสอบก่อนเรียน</h3>
                            <p class="text-muted mb-5">กรุณาทำแบบทดสอบเพื่อวัดพื้นฐานความรู้ก่อนเริ่มเนื้อหาในบทนี้</p>
                            <a class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow" 
                               href="../Quizzes/?Course=<?=@$_GET['Course']?>&Leeson=<?=@$_GET['Leeson']?>&AnswerCategory=ก่อนเรียน">
                                เริ่มทำแบบทดสอบ
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="lesson-content-header mb-4">
                            <h2 class="font-weight-bold mb-2">บทที่ <?=$rowLesSingTitle['LessonNo']?>: <?=$rowLesSingTitle['LessonTitle']?></h2>
                            <div class="text-muted d-flex align-items-center gap-3">
                                <span><i class="far fa-clock mr-1"></i> เวลาเรียนอย่างน้อย <?=$rowLesSingTitle['LessonStudyTime']?> นาที</span>
                            </div>
                        </div>

                        <div class="lesson-body prose">
                            <?=$rowLesSingTitle['LessonContent']?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </main>

        <!-- Persistent Control Bar (Only when in a lesson) -->
        <?php if(!empty($_GET['Leeson'] && $CheckExamBefore !== 0)): ?>
        <div class="timer-footer">
            <div class="d-flex align-items-center gap-3">
                <div id="countdown">
                    <svg viewBox="0 0 50 50">
                        <circle r="20" cx="25" cy="25"></circle>
                    </svg>
                    <div id="number">--:--</div>
                </div>
                <div>
                    <small class="text-muted d-block">ความคืบหน้าการศึกษา</small>
                    <span class="font-weight-bold" id="RoundTime">--:--</span> / <?=$rowLesSingTitle['LessonStudyTime']?> นาที
                </div>
            </div>

            <div class="lesson-actions">
                <a href="../Quizzes/?Course=<?=@$_GET['Course']?>&Leeson=<?=@$_GET['Leeson']?>&AnswerCategory=หลังเรียน" 
                   class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm d-none" id="btnQuiz">
                    <i class="fas fa-pencil-alt mr-2"></i> ทำแบบทดสอบหลังเรียน
                </a>
                <button class="btn btn-light btn-lg rounded-pill px-5 text-muted shadow-sm" id="btnLocked" disabled>
                    <i class="fas fa-lock mr-2"></i> ช่วงเวลากำหนด
                </button>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php include_once('../../../pages/Users/Layout/FooterUser.php'); ?>

    <script src="../../Users/Learn/Js/JsLearn.js"></script>
    <script>
        // Adjust iframe heights automatically
        window.addEventListener('load', () => {
            const iframes = document.querySelectorAll('iframe');
            iframes.forEach(iframe => {
                iframe.classList.add('shadow-lg');
            });
        });

        // Hide AdminLTE default sidebar/navbar parts if they leak
        // document.body.classList.remove('sidebar-mini'); // Assuming classList usage
        document.body.classList.add('layout-fixed');
    </script>
</body>
</html>