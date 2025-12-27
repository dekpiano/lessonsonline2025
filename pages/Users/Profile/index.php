<?php 
include_once '../../../php/Database/Database.php'; 
include_once '../../Users/PhpClass/ClassLearn.php';
include_once '../../../pages/Users/PhpClass/ClassProfileUser.php';
$database = new Database();
$db = $database->getConnection();
$Title = "โปรไฟล์ | บทเรียนออนไลน์";
$User = new ClassProfileUser($db);
$DataUser = $User->SelectDataUser();
?>
<?php include_once('../../../pages/Users/Layout/HeaderUser.php') ?>
<style>
.match { color: #10b981; }
.mismatch { color: #ef4444; }

/* Custom Profile Styles */
.profile-user-img {
    border: 3px solid #e2e8f0;
    padding: 3px;
    width: 120px;
    height: 120px;
    object-fit: cover;
}

.box-profile {
    padding: 30px;
}

.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #fff;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.4);
}

.nav-pills .nav-link {
    color: var(--text-dark);
    font-weight: 500;
    border-radius: 50px;
    padding: 10px 25px;
    margin-right: 10px;
}

.form-control:disabled, .form-control[readonly] {
    background-color: #f8fafc;
    opacity: 1;
    cursor: not-allowed;
}

select.form-control {
    height: auto !important;
    padding-top: 10px;
    padding-bottom: 10px;
}
</style>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php include_once('../../../pages/Users/Layout/NavbarTopUser.php') ?>
        <?php include_once('../../../pages/Users/Layout/NavbarLeftUser.php') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header pt-4 pb-4">
                <div class="container-fluid">
                    <div class="row mb-2 align-items-center">
                        <div class="col-sm-6">
                            <h1 class="m-0 font-weight-bold">ข้อมูลส่วนตัว</h1>
                            <p class="text-muted mb-0">จัดการข้อมูลส่วนตัวและการตั้งค่าบัญชีของคุณ</p>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content pb-5">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <!-- Profile Image -->
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body box-profile text-center">
                                    <div class="position-relative d-inline-block mb-3">
                                        <img class="profile-user-img img-fluid img-circle shadow-sm"
                                            src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png"
                                            alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username font-weight-bold text-dark mb-1">
                                        <?=$DataUser['UserPrefix'].$DataUser['UserFirstName'].' '.$DataUser['UserLastName']?>
                                    </h3>

                                    <p class="text-muted mb-4 badge badge-light px-3 py-2" style="font-size: 0.9rem;">
                                        <i class="fas fa-user-tag mr-1"></i> <?=$DataUser['UserType']?>
                                    </p>

                                    <div class="text-left mt-4 px-3">
                                        <div class="mb-3 d-flex align-items-center">
                                            <div class="mr-3 text-primary"><i class="fas fa-envelope fa-lg" style="width: 24px;"></i></div>
                                            <div>
                                                <small class="text-muted d-block">อีเมล</small>
                                                <span class="font-weight-medium text-dark text-break"><?=$DataUser['Email']?></span>
                                            </div>
                                        </div>
                                        <div class="mb-3 d-flex align-items-center">
                                            <div class="mr-3 text-secondary"><i class="fas fa-birthday-cake fa-lg" style="width: 24px;"></i></div>
                                            <div>
                                                <small class="text-muted d-block">วันเกิด</small>
                                                <span class="font-weight-medium text-dark"><?=thai_date_fullmonth(strtotime($DataUser['UserBirthday']))?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3 text-success"><i class="fas fa-phone-alt fa-lg" style="width: 24px;"></i></div>
                                            <div>
                                                <small class="text-muted d-block">เบอร์โทรศัพท์</small>
                                                <span class="font-weight-medium text-dark"><?=$DataUser['UserPhone']?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="card shadow-sm border-0">
                                <div class="card-header p-2 bg-transparent border-bottom-0 pt-4 px-4">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="pill"><i class="fas fa-user-edit mr-2"></i>แก้ไขข้อมูลส่วนตัว</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="pill"><i class="fas fa-key mr-2"></i>เปลี่ยนรหัสผ่าน</a></li>
                                    </ul>
                                </div>
                                
                                <div class="card-body p-4">
                                    <div class="tab-content">
                                        <div class="active tab-pane fade show" id="activity">
                                            <form class="form-horizontal" id="ProfileUpdateDataUser">
                                                <div class="form-row mb-3">
                                                    <div class="form-group col-md-4">
                                                        <label for="UserPrefix" class="font-weight-bold text-muted small text-uppercase">คำนำหน้า</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text bg-light border-right-0"><i class="fas fa-user-tag"></i></span></div>
                                                            <select class="form-control border-left-0" id="UserPrefix" name="UserPrefix">
                                                                <?php $Prefix = array('เด็กชาย','เด็กหญิง','นาย','นาง','นางสาว'); ?>
                                                                <?php foreach ($Prefix as $key => $v_Prefix) : ?>
                                                                <option <?=$DataUser['UserPrefix'] == $v_Prefix ?"selected":""?> value="<?=$v_Prefix;?>"><?=$v_Prefix;?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="UserFirstName" class="font-weight-bold text-muted small text-uppercase">ชื่อจริง</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text bg-light border-right-0"><i class="fas fa-user"></i></span></div>
                                                            <input type="text" class="form-control border-left-0" id="UserFirstName" name="UserFirstName" placeholder="ชื่อจริง" value="<?=$DataUser['UserFirstName']?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="UserLastName" class="font-weight-bold text-muted small text-uppercase">นามสกุล</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text bg-light border-right-0"><i class="fas fa-user"></i></span></div>
                                                            <input type="text" class="form-control border-left-0" id="UserLastName" name="UserLastName" placeholder="นามสกุล" value="<?=$DataUser['UserLastName']?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-row mb-3">
                                                    <div class="form-group col-md-6">
                                                        <label for="UserBirthday" class="font-weight-bold text-muted small text-uppercase">วันเกิด</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text bg-light border-right-0"><i class="fas fa-calendar-alt"></i></span></div>
                                                            <input type="date" class="form-control border-left-0" id="UserBirthday" name="UserBirthday" value="<?=$DataUser['UserBirthday']?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="UserPhone" class="font-weight-bold text-muted small text-uppercase">เบอร์โทรศัพท์</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text bg-light border-right-0"><i class="fas fa-phone"></i></span></div>
                                                            <input type="text" class="form-control border-left-0" id="UserPhone" name="UserPhone" placeholder="เบอร์โทรศัพท์" value="<?=$DataUser['UserPhone']?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="Email" class="font-weight-bold text-muted small text-uppercase">อีเมล <span class="badge badge-warning font-weight-normal text-white ml-2">ไม่สามารถแก้ไขได้</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text bg-light border-right-0"><i class="fas fa-envelope"></i></span></div>
                                                        <input type="email" class="form-control border-left-0 bg-light" id="Email" name="Email" placeholder="Email" value="<?=$DataUser['Email']?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                                                        <i class="fas fa-save mr-2"></i> บันทึกข้อมูล
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="tab-pane fade" id="timeline">
                                            <form id="ResetPassword" class="p-2">
                                                <div class="form-group">
                                                    <label for="PasswordOld" class="font-weight-bold text-muted small text-uppercase">รหัสผ่านปัจจุบัน</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text bg-light border-right-0"><i class="fas fa-lock"></i></span></div>
                                                        <input type="password" class="form-control border-left-0" id="PasswordOld" name="PasswordOld" placeholder="ระบุรหัสผ่านเดิม">
                                                    </div>
                                                    <small id="password_match1" class="form-text mt-1"></small>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="PasswordNew" class="font-weight-bold text-muted small text-uppercase">รหัสผ่านใหม่</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text bg-light border-right-0"><i class="fas fa-key"></i></span></div>
                                                            <input type="password" class="form-control border-left-0" id="PasswordNew" name="PasswordNew" placeholder="กำหนดรหัสผ่านใหม่">
                                                        </div>
                                                        <small id="password-strength" class="form-text mt-1"></small>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="PasswordConfrim" class="font-weight-bold text-muted small text-uppercase">ยืนยันรหัสผ่านใหม่</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text bg-light border-right-0"><i class="fas fa-check-circle"></i></span></div>
                                                            <input type="password" class="form-control border-left-0" id="PasswordConfrim" name="PasswordConfrim" placeholder="ระบุรหัสผ่านใหม่อีกครั้ง">
                                                        </div>
                                                        <small id="password_match" class="form-text mt-1"></small>
                                                    </div>
                                                </div>

                                                <div class="text-right mt-4">
                                                     <button id="BtnResetPassword" type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm" disabled>
                                                        <i class="fas fa-sync-alt mr-2"></i> เปลี่ยนรหัสผ่าน
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include_once('../../../pages/Users/Layout/FooterUser.php'); ?>
    </div>
</body>
</html>