<?php 
include_once '../../../php/Database/Database.php'; 
include_once '../../Users/PhpClass/ClassCourse.php';
include_once '../../Users/PhpClass/ClassAssessment.php';
$database = new Database();
$db = $database->getConnection();
$Course = new ClassCourse($db);
$Assessment = new ClassAssessment($db);
$Title = "บทเรียนออนไลน์";
$Resutl = $Course->readLessonsAll(@$_GET['Course']);

$stmt = $Course->CourseMy();
$Check = $Course->CourseMy()->fetch(PDO::FETCH_ASSOC);
$CheckAssessment = $Assessment->CheckAssessment(@$Check['CourseID']);

//print_r($_SESSION['UserID']);exit();

?>
<?php include_once('../../../pages/Users/Layout/HeaderUser.php') ?>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <?php include_once('../../../pages/Users/Layout/NavbarHomeUser.php') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"></h1>
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">คอร์สเรียนของฉัน</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped projects">
                                    <thead>
                                        <tr>
                                            <th style="width: 15%">
                                                #
                                            </th>
                                            <th style="width: 20%">
                                                ชื่อคอร์สเรียน
                                            </th>
                                            <th style="width: 15%">
                                                ผู้เรียน
                                            </th>
                                            <th>
                                                เรียนแล้ว
                                            </th>
                                            <th style="" class="text-center">
                                                สถานะ
                                            </th>
                                            <th style="">
                                                เรียนต่อ
                                            </th>
                                            <th style="">
                                                แบบประเมิน
                                            </th>
                                            <th>
                                                เกียรติบัตร
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)):
              $CourseProgress = $Course->CourseProgress($row['CourseID']);
              $LessonsTotal = $Course->LessonsTotal($row['CourseID'])->fetch(PDO::FETCH_ASSOC);
                                          
              $ValCourseProgress = $CourseProgress->fetch(PDO::FETCH_ASSOC);
              $CheckDoAssessment = $Course->CheckDoAssessment($row['CourseID']);
              //print_r($CheckDoAssessment['DoAssessment'] );
              //สมการหา %
              $ValProgressAll = ROUND((($ValCourseProgress['completed_lessons']/$LessonsTotal['TotalLessons'])*100),2);
                ?>
                                        <tr>
                                            <td>
                                                <img src="../../../uploads/Course/<?=$row['CourseImage'];?>"
                                                    class="img-fluid" alt="คอร์สเรียน" srcset="">
                                            </td>
                                            <td>
                                                <a>
                                                    <?=$row['CourseName']?>
                                                </a>
                                                <!-- <br>
                                                <small>โดย <?=$row['FullName']?></small> -->
                                            </td>
                                            <td>
                                                <?php echo $_SESSION['FullName']?>
                                            </td>
                                            <td class="project_progress">
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-green" role="progressbar"
                                                        aria-valuenow="<?=$ValProgressAll?>" aria-valuemin="0"
                                                        aria-valuemax="100" style="width: <?=$ValProgressAll?>%">
                                                    </div>
                                                </div>
                                                <small>
                                                    <?=$ValProgressAll?>% จาก
                                                    (<?=$ValCourseProgress['completed_lessons'].'/'.$LessonsTotal['TotalLessons']?>
                                                    บทเรียน)
                                                </small>
                                                <div>
                                                    <!-- <a class="btn btn-primary btn-xs" href="#">
                                                        <i class="fas fa-eye">
                                                        </i>
                                                        ดูทั้งหมด
                                                    </a> -->
                                                </div>

                                            </td>
                                            <td class="project-state">
                                            <?php if($CheckDoAssessment['DoAssessment'] == 0) :?>
                                                <span class="badge badge-success"><?=$row['CourseStatus']?></span>
                                                <?php else: ?>
                                                    <span class="badge badge-success">Success</span>
                                            <?php endif; ?>
                                            </td>

                                            <td class="project-actions">
                                                <a class="btn btn-info btn-xs"
                                                    href="../Learn/?Course=<?=$row['CourseID']?>">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    เรียน
                                                </a>

                                            </td>
                                            <td>
                                            <?php $disabledAssessment = ($ValCourseProgress['completed_lessons'] != $LessonsTotal['TotalLessons']) ?"disabled":""?>
                                                <a  class="btn btn-success btn-xs <?=$disabledAssessment?>" href="../Assessment?Course=<?=$row['CourseID']?>">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    แบบประเมิน
                                                </a>
                                            </td>
                                            <td>
                                            <?php $disabledCertificate = ($CheckDoAssessment['DoAssessment'] == 0) ?"disabled":""?>
                                            <a class="btn btn-warning btn-xs <?=$disabledAssessment?> <?=$disabledCertificate?>" href="Certificate/LoadCertificate.php?CourseID=<?=$row['CourseID']?>" target="_blank">
                                            <i class="fas fa-file-export"></i>
                                                    ดาวน์โหลด
                                                </a>
                                                
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- Small boxes (Stat box) -->
                    <div class="row">

                        <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>

                        <div class="col-md-4">
                            <a href="../Course/CourseView?CourseID=<?=$row['CourseID']?>">
                                <div class="card card-widget widget-user">
                                    <div class="widget-user-header text-white"
                                        style="background: url('../../../uploads/Course/<?=$row['CourseImage'];?>') center center;background-size: cover;">

                                    </div>
                                    <div class="p-2">
                                        <h5 class="m-0"><?=$row['CourseName']?></h5>
                                        <small>โดย <?=$row['FullName']?></small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endwhile; ?>

                    </div>
                    <!-- /.row -->

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <?php include_once('../../../pages/Users/Layout/FooterUser.php'); ?>
</body>

</html>