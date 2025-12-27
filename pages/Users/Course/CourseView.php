<?php 
include_once '../../../php/Database/Database.php'; 
include_once '../../Users/PhpClass/ClassCourse.php';
include_once '../../Users/PhpClass/ClassEnrollmentUser.php';
$database = new Database();
$db = $database->getConnection();
$Course = new ClassCourse($db);
$Enroll = new ClassEnrollmentUser($db);

$Enroll->CourseID = $_GET['CourseID'];
$Enroll->UserID = @$_SESSION['UserID'];
$CheckEnroll = $Enroll->CheckEnrollmentUser();

$Course->CourseID = $_GET['CourseID'];
$Course->readSingle();
$stmt = $Course->readLessonsAll(@$_GET['CourseID']);
$Resutl = $Course->readLessonsAll(@$_GET['Course']);

$Title = $Course->CourseName . " | รายละเอียดคอร์ส";
?>
<?php include_once('../../../pages/Users/Layout/HeaderUser.php') ?>

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        --secondary-gradient: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
        --card-bg: rgba(255, 255, 255, 1);
        --text-main: #1e293b;
        --text-muted: #64748b;
        --border-radius-lg: 24px;
        --border-radius-md: 16px;
        --shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.1);
    }

    body {
        background-color: #f8fafc;
        color: var(--text-main);
        font-family: 'Kanit', sans-serif;
    }

    .content-wrapper {
        background: #f8fafc;
        min-height: 100vh;
        padding-bottom: 100px;
    }

    /* Course Hero */
    .course-hero {
        background: var(--primary-gradient);
        padding: 40px 15px 120px;
        color: white;
        margin-bottom: -60px;
    }

    .breadcrumb-custom {
        font-size: 0.9rem;
        margin-bottom: 20px;
        opacity: 0.8;
    }
    .breadcrumb-custom a { color: white; text-decoration: none; }

    .course-title {
        font-size: 2.2rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 15px;
    }

    /* Main Card Layout */
    .main-course-card {
        background: var(--card-bg);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        border: none;
        overflow: hidden;
        margin-bottom: 30px;
    }

    .course-img-main {
        width: 100%;
        border-radius: var(--border-radius-md);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        margin-bottom: 25px;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i { color: #6366f1; }

    .description-text {
        color: #475569;
        line-height: 1.8;
        font-size: 1.05rem;
    }

    /* Lesson List */
    .lesson-item {
        background: #f1f5f9;
        border-radius: var(--border-radius-md);
        padding: 16px 20px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }

    .lesson-item:hover {
        background: white;
        border-color: #6366f1;
        transform: translateX(5px);
    }

    .lesson-number {
        background: white;
        color: #6366f1;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        flex-shrink: 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .lesson-info { flex-grow: 1; }
    .lesson-info h6 { margin: 0; font-weight: 600; color: var(--text-main); }
    .lesson-info small { color: var(--text-muted); }

    /* Action Sidebar */
    .action-sidebar {
        position: sticky;
        top: 20px;
    }

    .enroll-card {
        background: white;
        border-radius: var(--border-radius-md);
        padding: 24px;
        box-shadow: var(--shadow-lg);
        border: 1px solid #e2e8f0;
    }

    .btn-enroll {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 14px;
        font-weight: 700;
        font-size: 1.1rem;
        border-radius: 12px;
        transition: transform 0.2s;
        text-align: center;
        display: block;
        width: 100%;
        text-decoration: none !important;
    }

    .btn-learn { background: var(--secondary-gradient); }

    .btn-enroll:active { transform: scale(0.98); }

    /* Mobile Fixed Bottom Bar */
    .mobile-bottom-bar {
        display: none;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        padding: 15px 20px 25px;
        box-shadow: 0 -10px 15px -3px rgba(0,0,0,0.1);
        z-index: 1000;
        border-top: 1px solid #e2e8f0;
    }

    @media (max-width: 991px) {
        .course-hero { padding: 30px 15px 100px; text-align: center; }
        .course-title { font-size: 1.8rem; }
        .mobile-bottom-bar { display: block; }
        .sidebar-col { display: none; }
    }
</style>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
    <?php include_once('../../../pages/Users/Layout/NavbarHomeUser.php') ?>

        <div class="content-wrapper">
            <!-- Hero Section -->
            <div class="course-hero">
                <div class="container">
                    <nav class="breadcrumb-custom">
                        <a href="../../../">หน้าแรก</a> / <a href="../Home/HomeMain">คอร์สเรียน</a> / รายละเอียด
                    </nav>
                    <h1 class="course-title text-white"><?=$Course->CourseName?></h1>
                    <div class="d-flex justify-content-center justify-content-lg-start align-items-center gap-2 opacity-90 text-white">
                        <i class="fas fa-chalkboard-teacher"></i> โดย ศูนย์วิทยาศาสตร์เพื่อการศึกษานครสวรรค์
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container">
                    <div class="row">
                        <!-- Left Content -->
                        <div class="col-lg-8">
                            <div class="main-course-card p-4 p-md-5">
                                <img src="../../../uploads/Course/<?=$Course->CourseImage?>" 
                                     class="course-img-main" 
                                     onerror="this.src='../../../dist/img/photo1.png'"
                                     alt="Course Image">

                                <div class="mb-5">
                                    <h4 class="section-title"><i class="fas fa-info-circle"></i> เกี่ยวกับรายวิชานี้</h4>
                                    <div class="description-text">
                                        <?=$Course->CourseDescription ?: "ไม่มีรายละเอียดสำหรับคอร์สนี้";?>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="section-title"><i class="fas fa-list-ul"></i> เนื้อหาบทเรียน</h4>
                                    <div class="lesson-list">
                                        <?php 
                                        $lesson_count = 0;
                                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) : 
                                            $lesson_count++;
                                        ?>
                                        <div class="lesson-item">
                                            <div class="lesson-number"><?=$row['LessonNo']?></div>
                                            <div class="lesson-info">
                                                <h6><?=$row['LessonTitle']?></h6>
                                                <small><i class="far fa-clock"></i> ใช้เวลาเรียน <?=$row['LessonStudyTime']?> นาที</small>
                                            </div>
                                            <div class="lesson-action">
                                                <i class="fas fa-play-circle text-muted"></i>
                                            </div>
                                        </div>
                                        <?php endwhile; ?>

                                        <?php if($lesson_count == 0): ?>
                                            <div class="text-center p-5 text-muted">
                                                <i class="fas fa-folder-open fa-3x mb-3"></i>
                                                <p>ยังไม่มีบทเรียนในคอร์สนี้</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Sidebar -->
                        <div class="col-lg-4 sidebar-col">
                            <div class="action-sidebar">
                                <div class="enroll-card">
                                    <h5 class="mb-4 font-weight-bold">สถานะของฉัน</h5>
                                    
                                    <?php if(!isset($_SESSION['FullName'])) :?>
                                        <div class="alert alert-light border text-center mb-4">
                                            กรุณาเข้าสู่ระบบก่อนเริ่มเรียน
                                        </div>
                                        <a href="#" data-toggle="modal" data-target="#ModalLogin"
                                           class="btn-enroll mb-2">เข้าสู่ระบบเพื่อเรียน</a>
                                        <a href="../../Users/Register" class="btn btn-outline-secondary btn-block rounded-pill">สมัครสมาชิกใหม่</a>
                                    <?php else: ?>
                                        <?php if($CheckEnroll == 0) :?>
                                            <a href="../Learn/Php/EnrollmentInsert?Course=<?=$Course->CourseID?>"
                                               class="btn-enroll"><i class="fas fa-user-plus mr-2"></i> ลงทะเบียนเรียน</a>
                                        <?php else: ?>
                                            <div class="alert alert-success text-center mb-4 rounded-pill">
                                                <i class="fas fa-check-circle"></i> ลงทะเบียนแล้ว
                                            </div>
                                            <a href="../Learn/?Course=<?=$Course->CourseID?>"
                                               class="btn-enroll btn-learn"><i class="fas fa-graduation-cap mr-2"></i> เข้าสู่หน้าบทเรียน</a>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <div class="mt-4 pt-4 border-top">
                                        <ul class="list-unstyled text-muted small">
                                            <li class="mb-2"><i class="fas fa-infinity mr-2"></i> เข้าเรียนได้ตลอด 24 ชั่วโมง</li>
                                            <li class="mb-2"><i class="fas fa-certificate mr-2"></i> รับเกียรติบัตรเมื่อเรียนจบ</li>
                                            <li><i class="fas fa-mobile-alt mr-2"></i> รองรับการเรียนผ่านมือถือ</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Bottom Action Bar -->
        <div class="mobile-bottom-bar">
            <?php if(!isset($_SESSION['FullName'])) :?>
                <a href="#" data-toggle="modal" data-target="#ModalLogin" class="btn-enroll">เข้าสู่ระบบเพื่อเรียน</a>
            <?php else: ?>
                <?php if($CheckEnroll == 0) :?>
                    <a href="../Learn/Php/EnrollmentInsert?Course=<?=$Course->CourseID?>" class="btn-enroll">ลงทะเบียนเรียนเลย</a>
                <?php else: ?>
                    <a href="../Learn/?Course=<?=$Course->CourseID?>" class="btn-enroll btn-learn">เรียนต่อในบทเรียน</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <?php include_once('../../../pages/Users/Layout/FooterUser.php'); ?>
    </div>
</body>
</html>