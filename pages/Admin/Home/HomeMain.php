<?php include_once '../../../php/Database/Database.php';
include_once '../../../pages/Admin/PhpClass/ClassTeacher.php';  
// สร้างออบเจกต์ฐานข้อมูลและคอร์สเรียน
$database = new Database();
$db = $database->getConnection();
$Teacher = new ClassTeacher($db);
$result = $Teacher->read();
$num = $result->rowCount();

?>

<?php include_once('../../../pages/Admin/Layout/HeaderAdmin.php') ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

    <?php include_once('../../../pages/Admin/Layout/NavbarTopAdmin.php') ?>
    <?php include_once('../../../pages/Admin/Layout/NavbarLeftAdmin.php') ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                      
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">                    
                
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?=$num?></h3>

                                    <p>ครูผู้สอน</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="../../../pages/Admin/Teacher" class="small-box-footer">จัดการครูผู้สอน <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                   
                    </div>
                    <!-- /.row -->

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <?php include_once('../../../pages/Admin/Layout/FooterAdmin.php'); ?>
</body>

</html>