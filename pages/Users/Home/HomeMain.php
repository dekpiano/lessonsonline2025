<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../../../php/Database/Database.php'; 
include_once '../../Users/PhpClass/ClassCourse.php';
include_once '../../Users/PhpClass/ClassEnrollmentUser.php';
include_once '../../Users/PhpClass/ClassLearn.php';

$database = new Database();
$db = $database->getConnection();
$Course = new ClassCourse($db);
$Enroll = new ClassEnrollmentUser($db);
$Learn = new ClassLearn($db);
$Title = "บทเรียนออนไลน์ | SKJ";
$stmt = $Course->read();

$Resutl = $Course->readLessonsAll(@$_GET['Course']); //เมนูซ้าย
?>
<?php include_once('../../../pages/Users/Layout/HeaderUser.php') ?>

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        --accent-color: #f43f5e;
        --card-bg: rgba(255, 255, 255, 0.95);
        --text-main: #1e293b;
        --text-muted: #64748b;
        --border-radius-lg: 24px;
        --border-radius-md: 16px;
        --shadow-sm: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        --shadow-md: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.1);
    }

    body {
        background-color: #f8fafc;
        color: var(--text-main);
        font-family: 'Kanit', sans-serif;
    }

    .content-wrapper {
        background: #f8fafc; /* Override previous background if needed */
        min-height: 100vh;
    }

    /* Hero Section */
    .hero-section {
        background: var(--primary-gradient);
        padding: 80px 20px 120px;
        border-radius: 0 0 40px 40px;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
        margin-bottom: -60px;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 800px;
        margin: 0 auto;
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 2rem;
    }

    /* Course Grid */
    .course-container {
        padding: 0 15px;
        margin-top: 20px;
    }

    .course-card {
        background: var(--card-bg);
        border: none;
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow-md);
        margin-bottom: 24px;
        text-decoration: none !important;
        display: block;
        height: 100%;
    }

    .course-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }

    .course-image-wrapper {
        position: relative;
        aspect-ratio: 16/9;
        overflow: hidden;
    }

    .course-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .course-card:hover .course-image {
        transform: scale(1.1);
    }

    .course-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-main);
        box-shadow: var(--shadow-sm);
    }

    .course-content {
        padding: 20px;
    }

    .course-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
    }

    .course-teacher {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .course-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }

    .stat-item {
        text-align: center;
    }

    .stat-value {
        display: block;
        font-size: 1rem;
        font-weight: 700;
        color: #6366f1;
    }

    .stat-label {
        display: block;
        font-size: 0.7rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Smartphone Optimization */
    @media (max-width: 768px) {
        .hero-section {
            padding: 60px 15px 100px;
        }
        .hero-title {
            font-size: 1.8rem;
        }
        .hero-subtitle {
            font-size: 1rem;
        }
        .course-container {
            margin-top: -40px;
        }
    }

    /* Floating Action Button for Mobile */
    .mobile-nav-btn {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: var(--primary-gradient);
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 30px;
        justify-content: center;
        align-items: center;
        box-shadow: var(--shadow-lg);
        z-index: 1000;
        transition: transform 0.2s;
    }

    .mobile-nav-btn:active {
        transform: scale(0.9);
    }

    @media (max-width: 768px) {
        <?php if(!empty($_SESSION['FullName'])):?>
        .mobile-nav-btn { display: flex; }
        <?php endif; ?>
    }

</style>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <?php include_once('../../../pages/Users/Layout/NavbarHomeUser.php') ?>

        <div class="content-wrapper">
            <!-- Hero Section -->
            <div class="hero-section">
                <div class="hero-content">
                    <h1 class="hero-title">ยกระดับการเรียนรู้<br>ด้วยบทเรียนออนไลน์</h1>
                    <p class="hero-subtitle">สะดวกรวดเร็ว เรียนรู้ได้ทุกที่ทุกเวลา พัฒนาทักษะเพื่ออนาคตของคุณ</p>
                    
                    <?php if(empty($_SESSION['FullName'])): ?>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="../../Users/Register" class="btn btn-light btn-lg rounded-pill px-4 shadow-sm font-weight-bold">
                            เริ่มสมัครเลย
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Main Content -->
            <div class="content">
                <div class="container course-container">
                    <div class="row">

                        <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                            $EnrollmentSuccessful = $Enroll->CheckEnrollmentSuccessful($row['CourseID']);
                            $EnrollmentAll = $Enroll->CheckEnrollmentAll($row['CourseID']);
                            $LessonsAll = $Learn->LessonsAllWhereCourse($row['CourseID']);
                        ?>

                        <div class="col-lg-4 col-md-6">
                            <a href="../Course/CourseView?CourseID=<?=$row['CourseID']?>" class="course-card">
                                <div class="course-image-wrapper">
                                    <img src="../../../uploads/Course/<?=$row['CourseImage'];?>" 
                                         class="course-image" 
                                         onerror="this.src='../../../dist/img/photo1.png'"
                                         alt="<?=$row['CourseName']?>">
                                    <div class="course-badge">บทเรียนใหม่</div>
                                </div>
                                
                                <div class="course-content">
                                    <h5 class="course-name"><?=$row['CourseName']?></h5>
                                    <div class="course-teacher">
                                        <i class="fas fa-chalkboard-teacher"></i> โดย ศูนย์วิทยาศาสตร์เพื่อการศึกษานครสวรรค์
                                    </div>
                                    
                                    <div class="course-stats">
                                        <div class="stat-item">
                                            <span class="stat-value"><?= $EnrollmentAll['SumAll'] ?: 0 ?></span>
                                            <span class="stat-label">ลงทะเบียน</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-value"><?= $EnrollmentSuccessful['SumAll'] ?: 0 ?></span>
                                            <span class="stat-label">สำเร็จ</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-value"><?= $LessonsAll['LessonsAll'] ?: 0 ?></span>
                                            <span class="stat-label">บทเรียน</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endwhile; ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Floating Action Button -->
        <?php if(!empty($_SESSION['FullName'])): ?>
        <a href="../../../pages/Users/Course/CourseMy" class="mobile-nav-btn" title="คอร์สเรียนของฉัน">
            <i class="fas fa-book-reader fa-lg"></i>
        </a>
        <?php endif; ?>

    </div>

    <?php include_once('../../../pages/Users/Layout/FooterUser.php'); ?>
</body>
</html>