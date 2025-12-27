<?php include_once '../../../php/Database/Database.php'; 
include_once '../../../pages/Admin/PhpClass/ClassTeacher.php'; 
// สร้างออบเจกต์ฐานข้อมูลและคอร์สเรียน
$database = new Database();
$db = $database->getConnection();
$Teacher = new ClassTeacher($db);
$Title = $Teacher->TitleBar;
$result = $Teacher->read();
//echo "<pre>";print_r($result->fetch(PDO::FETCH_ASSOC)); exit();
?>

<?php include_once('../../../pages/Teacher/Layout/HeaderTeacher.php') ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include_once('../../../pages/Teacher/Layout/NavbarTopTeacher.php') ?>
        <?php include_once('../../../pages/Teacher/Layout/NavbarLeftTeacher.php') ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?=$Title;?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="javascript:history.go(-1)">หน้าแรก</a></li>
                                <li class="breadcrumb-item active">จัดการครูผู้สอน</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                <div class="row">
                        <!-- Teachers List Column (Full Width) -->
                        <div class="col-lg-12">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-header bg-white border-bottom pt-4 pb-3 d-flex justify-content-between align-items-center">
                                    <h4 class="card-title text-dark font-weight-bold"><i class="fas fa-list-ul mr-2 text-info"></i> รายชื่อครูผู้สอน</h4>
                                    <?php
                                    // Check Limit
                                    include_once '../../../pages/Admin/PhpClass/ClassSystemSettings.php';
                                    $Settings = new ClassSystemSettings($db);
                                    $MaxTeachers = (int)$Settings->getSetting('max_teachers', 10);
                                    $CurrentTeachers = $result->rowCount();
                                    
                                    if ($CurrentTeachers < $MaxTeachers) {
                                        $btnClass = "btn-primary";
                                        $btnAttr = 'data-toggle="modal" data-target="#modalAddTeacher"';
                                        $btnIcon = "fa-plus";
                                    } else {
                                        $btnClass = "btn-secondary";
                                        $btnAttr = 'onclick="alertLimitReached(' . $MaxTeachers . ')"';
                                        $btnIcon = "fa-ban";
                                    }
                                    ?>
                                    <button type="button" class="btn <?=$btnClass?> rounded-pill shadow-sm px-4" <?=$btnAttr?>>
                                        <i class="fas <?=$btnIcon?> mr-2"></i> เพิ่มครูผู้สอนใหม่
                                    </button>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="Tb_Couesr" class="table table-hover table-striped mb-0" style="width:100%">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th class="border-top-0 text-muted small text-uppercase font-weight-bold pl-4">รหัส</th>
                                                    <th class="border-top-0 text-muted small text-uppercase font-weight-bold">ชื่อ - นามสกุล</th>
                                                    <th class="border-top-0 text-muted small text-uppercase font-weight-bold">เบอร์โทร</th>
                                                    <th class="border-top-0 text-muted small text-uppercase font-weight-bold">อีเมล</th>
                                                    <th class="border-top-0 text-muted small text-uppercase font-weight-bold text-center">จัดการ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                                                <tr id="row_<?=$row['UserID']?>">
                                                    <td class="pl-4 align-middle"><span class="badge badge-light border text-muted"><?=$row['UserCode']?></span></td>
                                                    <td class="align-middle">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm mr-2 bg-primary rounded-circle d-flex justify-content-center align-items-center text-white font-weight-bold" style="width:35px; height:35px;">
                                                                <?=mb_substr($row['UserFirstName'],0,1)?>
                                                            </div>
                                                            <div>
                                                                <div class="font-weight-bold text-dark"><?=$row['UserPrefix']?><?=$row['UserFirstName']?></div>
                                                                <div class="small text-muted"><?=$row['UserLastName']?></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-muted"><?=$row['UserPhone']?></td>
                                                    <td class="align-middle text-muted"><?=$row['Email']?></td>
                                                    <td class="align-middle text-center">
                                                        <div class="btn-group">
                                                            <a href="javascript:void(0)" onclick="fetchTeacherData(<?=$row['UserID']?>)" class="btn btn-outline-warning btn-sm rounded-left" data-toggle="tooltip" title="แก้ไข">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="javascript:void(0)" onclick="deleteTeacher(<?=$row['UserID']?>)" class="btn btn-outline-danger btn-sm rounded-right" data-toggle="tooltip" title="ลบ">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->

            <!-- Add Teacher Modal -->
            <div class="modal fade" id="modalAddTeacher" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content shadow-lg border-0">
                        <div class="modal-header bg-light border-bottom-0">
                            <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-user-plus text-primary mr-2"></i> เพิ่มครูผู้สอนใหม่</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" id="FormRegisterTeacher" class="needs-validation" novalidate>
                                
                                <div class="form-group mb-3">
                                    <label class="text-muted small mb-1">ข้อมูลเข้าสู่ระบบ</label>
                                    <div class="input-group">
                                        <input type="email" class="form-control" placeholder="อีเมล (ใช้เป็น Username)" id="Email" name="Email" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text bg-light border-light"><span class="fas fa-envelope text-muted"></span></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <div class="input-group">
                                        <input type="password" class="form-control" placeholder="รหัสผ่าน" id="Password" name="Password" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text bg-light border-light"><span class="fas fa-lock text-muted"></span></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-4">
                                    <div class="input-group">
                                        <input type="password" class="form-control" placeholder="ยืนยันรหัสผ่าน" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text bg-light border-light"><span class="fas fa-check-circle text-muted"></span></div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="form-group mb-3">
                                    <label class="text-muted small mb-1">ข้อมูลส่วนตัว</label>
                                    <select name="UserPrefix" id="UserPrefix" class="form-control custom-select" required>
                                        <option value="" selected disabled>เลือกคำนำหน้า...</option>
                                        <option value="นาย">นาย</option>
                                        <option value="นาง">นาง</option>
                                        <option value="นางสาว">นางสาว</option>
                                        <option value="ดร.">ดร.</option>
                                    </select>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-6">
                                        <input type="text" class="form-control" placeholder="ชื่อจริง" id="UserFirstName" name="UserFirstName" required>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" placeholder="นามสกุล" id="UserLastName" name="UserLastName" required>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="text-muted small mb-1">วันเกิด</label>
                                    <input type="date" class="form-control" id="UserBirthday" name="UserBirthday" required>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="text-muted small mb-1">เบอร์โทรศัพท์</label>
                                    <input type="tel" class="form-control" placeholder="กรอกเบอร์โทรศัพท์" id="UserPhone" name="UserPhone" required>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block rounded-pill shadow-sm py-2 font-weight-bold">
                                    <i class="fas fa-check mr-2"></i> ลงทะเบียนครู
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="modalEditTeacher" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content shadow-lg border-0">
                        <div class="modal-header bg-light border-bottom-0">
                            <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-edit text-warning mr-2"></i> แก้ไขข้อมูลครูผู้สอน</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="FormEditTeacher">
                                <input type="hidden" id="edit_UserID" name="UserID">
                                
                                <div class="form-group mb-3">
                                    <label class="text-muted small mb-1">ข้อมูลส่วนตัว</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white"><i class="fas fa-user-tag text-muted"></i></span>
                                        </div>
                                        <select name="UserPrefix" id="edit_UserPrefix" class="form-control custom-select" required>
                                            <option value="นาย">นาย</option>
                                            <option value="นาง">นาง</option>
                                            <option value="นางสาว">นางสาว</option>
                                            <option value="ดร.">ดร.</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="col-6">
                                        <input type="text" class="form-control" placeholder="ชื่อจริง" id="edit_UserFirstName" name="UserFirstName" required>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" placeholder="นามสกุล" id="edit_UserLastName" name="UserLastName" required>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="text-muted small mb-1">วันเกิด</label>
                                    <input type="date" class="form-control" id="edit_UserBirthday" name="UserBirthday" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="text-muted small mb-1">เบอร์โทรศัพท์</label>
                                    <input type="tel" class="form-control" id="edit_UserPhone" name="UserPhone" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="text-muted small mb-1">อีเมล (Username)</label>
                                    <input type="email" class="form-control" id="edit_Email" name="Email" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="text-muted small mb-1">เปลี่ยนรหัสผ่าน (ถ้าต้องการ)</label>
                                    <input type="password" class="form-control" id="edit_Password" name="Password" placeholder="กรอกรหัสผ่านใหม่หากต้องการเปลี่ยน">
                                </div>
                            
                            </form>
                        </div>
                        <div class="modal-footer border-top-0 bg-light">
                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">ยกเลิก</button>
                            <button type="button" onclick="updateTeacher()" class="btn btn-warning rounded-pill px-4 font-weight-bold">บันทึกการแก้ไข</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->


        <?php include_once('../../../pages/Teacher/Layout/FooterTeacher.php'); ?>
</body>

</html>
<!-- Reuse Admin JS -->
<script src="../../../pages/Admin/Teacher/Js/JsRegisterTeacher.js"></script>

<script>
function alertLimitReached(max) {
    Swal.fire({
        title: 'ไม่สามารถเพิ่มครูผู้สอนได้',
        text: 'จำนวนบัญชีครูผู้สอนครบตามจำนวนที่กำหนดแล้ว (' + max + ' ท่าน) กรุณาติดต่อผู้ดูแลระบบเพื่อขยายสิทธิ์',
        icon: 'warning',
        confirmButtonText: 'เข้าใจแล้ว'
    });
}
</script>
