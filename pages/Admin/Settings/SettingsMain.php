<?php 
include_once '../../../php/Database/Database.php';
include_once '../../Admin/PhpClass/ClassSystemSettings.php';

$database = new Database();
$db = $database->getConnection();
$Settings = new ClassSystemSettings($db);

$MaxCourses = $Settings->getSetting('max_total_courses', 50);
$Title = "ตั้งค่าคอร์สเรียน";
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
                            <h1 class="m-0">ตั้งค่าคอร์สเรียน</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../Home/HomeMain">หน้าแรก</a></li>
                                <li class="breadcrumb-item active">ตั้งค่าคอร์สเรียน</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                   
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                            <h3 class="card-title text-primary font-weight-bold"><i class="fas fa-sliders-h mr-2"></i> กำหนดค่าระบบ</h3>
                        </div>
                        <div class="card-body">
                            <form id="FormSettingsCourse">
                                <h5 class="text-secondary mb-4 border-bottom pb-2" style="font-size: 1rem;"><i class="fas fa-layer-group mr-1"></i> ข้อจำกัดคอร์สเรียน</h5>
                                
                                <div class="form-group row align-items-center mb-4">
                                    <label for="max_total_courses" class="col-sm-4 col-form-label text-dark font-weight-normal">จำกัดจำนวนคอร์สรวมทั้งระบบ</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="number" class="form-control text-center" id="max_total_courses" name="max_total_courses" value="<?=$MaxCourses?>" min="1" required style="border-radius: 8px 0 0 8px;">
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-light text-muted border-light" style="border-radius: 0 8px 8px 0;">คอร์ส</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="text-muted d-block mt-1"><i class="fas fa-info-circle mr-1"></i> กำหนดเพดานจำนวนคอร์สเรียนสูงสุดที่ระบบรองรับ (รวมของครูทุกคน)</small>
                                    </div>
                                </div>
                                
                                <h5 class="text-secondary mb-4 border-bottom pb-2 mt-5" style="font-size: 1rem;"><i class="fas fa-users-cog mr-1"></i> ข้อจำกัดบัญชีผู้ใช้</h5>

                                <div class="form-group row align-items-center mb-4">
                                    <label for="max_teachers" class="col-sm-4 col-form-label text-dark font-weight-normal">จำกัดจำนวนครูผู้สอน</label>
                                    <div class="col-sm-2">
                                        <div class="input-group">
                                            <input type="number" class="form-control text-center" id="max_teachers" name="max_teachers" value="<?=$Settings->getSetting('max_teachers', 10)?>" min="1" required style="border-radius: 8px 0 0 8px;">
                                              <div class="input-group-append">
                                                <span class="input-group-text bg-light text-muted border-light" style="border-radius: 0 8px 8px 0;">ท่าน</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                         <small class="text-muted d-block mt-1"><i class="fas fa-info-circle mr-1"></i> กำหนดโควต้าจำนวนบัญชีครูผู้สอนสูงสุดในระบบ</small>
                                    </div>
                                </div>

                                <div class="form-group row mt-5">
                                    <div class="col-sm-12 text-center">
                                        <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm rounded-pill"><i class="fas fa-save mr-2"></i> บันทึกการตั้งค่า</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <?php include_once('../../../pages/Admin/Layout/FooterAdmin.php'); ?>
        
        <!-- Add JS Script -->
        <script src="Js/JsSettings.js"></script>
</body>

</html>
