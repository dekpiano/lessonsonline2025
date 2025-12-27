<?php 
include_once '../../../php/Database/Database.php'; 
include_once '../../Users/PhpClass/ClassLearn.php';
include_once '../../../pages/Users/PhpClass/ClassProfileUser.php';
$database = new Database();
$db = $database->getConnection();
$Title = "โปรไฟล์ | บทเรียนออนไลน์";
$User = new ClassProfileUser($db);
$DataUser = $User->SelectDataUser();
//echo '<pre>'; print_r($DataUser->SelectDataUser()); exit();
?>
<?php include_once('../../../pages/Users/Layout/HeaderUser.php') ?>
<style>
.match {
    color: green;
}

.mismatch {
    color: red;
}
</style>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <?php include_once('../../../pages/Users/Layout/NavbarHomeUser.php') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 2646.44px;">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>ข้อมูลส่วนตัว</h1>
                        </div>

                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">

                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle"
                                            src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png"
                                            alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username text-center">
                                        <?=$DataUser['UserPrefix'].$DataUser['UserFirstName'].' '.$DataUser['UserLastName']?>
                                    </h3>

                                    <p class="text-muted text-center"><?=$DataUser['UserType']?></p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Email</b> <a class="float-right"><?=$DataUser['Email']?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>วันเกิด</b> <a
                                                class="float-right"><?=thai_date_fullmonth(strtotime($DataUser['UserBirthday']))?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>เบอร์โทร</b> <a class="float-right"><?=$DataUser['UserPhone']?></a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#activity"
                                                data-toggle="tab">ข้อมูลส่วนตัว</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#timeline"
                                                data-toggle="tab">รหัสผ่าน</a></li>
                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            <form class="form-horizontal" id="ProfileUpdateDataUser">
                                                <div class="form-group row">
                                                    <label for="inputName" class="col-sm-2 col-form-label">ชื่อ -
                                                        นามสกุล</label>
                                                    <div class="col-sm-10">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <select class="form-control" id="UserPrefix"
                                                                    name="UserPrefix">
                                                                    <?php $Prefix = array('เด็กชาย','เด็กหญิง','นาย','นาง','นางสาว'); ?>
                                                                    <?php foreach ($Prefix as $key => $v_Prefix) : ?>
                                                                    <option
                                                                        <?=$DataUser['UserPrefix'] == $v_Prefix ?"selected":""?>
                                                                        value="<?=$v_Prefix;?>"><?=$v_Prefix;?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4"> <input type="text"
                                                                    class="form-control" id="UserFirstName"
                                                                    name="UserFirstName" placeholder="ชื่อจริง"
                                                                    value="<?=$DataUser['UserFirstName']?>"></div>
                                                            <div class="col-md-4"> <input type="text"
                                                                    class="form-control" id="UserLastName"
                                                                    name="UserLastName" placeholder="นามสกุลจริง"
                                                                    value="<?=$DataUser['UserLastName']?>"></div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="UserBirthday"
                                                        class="col-sm-2 col-form-label">วันเกิด</label>
                                                    <div class="col-sm-4">
                                                        <input type="date" class="form-control" id="UserBirthday"
                                                            name="UserBirthday" placeholder="Name"
                                                            value="<?=$DataUser['UserBirthday']?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="Email" class="col-sm-2 col-form-label">Email</label>
                                                    <div class="col-sm-4">
                                                        <input type="email" class="form-control" id="Email" name="Email"
                                                            placeholder="Email" value="<?=$DataUser['Email']?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="UserPhone"
                                                        class="col-sm-2 col-form-label">เบอร์โทรศัพท์</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" id="UserPhone"
                                                            name="UserPhone" placeholder="เบอร์โทรศัพท์"
                                                            value="<?=$DataUser['UserPhone']?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit" class="btn btn-danger">บันทึก</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="timeline">
                                            <form id="ResetPassword">
                                                <div class="form-group row">
                                                    <label for="PasswordOld"
                                                        class="col-sm-2 col-form-label">รหัสผ่านเก่า</label>
                                                    <div class="col-sm-4">
                                                        <input type="password" class="form-control" id="PasswordOld"
                                                            name="PasswordOld" placeholder="รหัสผ่านเก่า" value="">
                                                        <small id="password_match1"></small>
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <label for="PasswordNew"
                                                        class="col-sm-2 col-form-label">รหัสผ่านใหม่</label>
                                                    <div class="col-sm-4">
                                                        <input type="password" class="form-control" id="PasswordNew"
                                                            name="PasswordNew" placeholder="รหัสผ่านใหม่" value="">
                                                        <small id="password-strength"></small>
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <label for="PasswordConfrim"
                                                        class="col-sm-2 col-form-label">ยืนยันรหัสผ่าน</label>
                                                    <div class="col-sm-4">
                                                        <input type="password" class="form-control" id="PasswordConfrim"
                                                            name="PasswordConfrim" placeholder="ยืนยันรหัสผ่าน"
                                                            value="">
                                                        <small id="password_match"></small>
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button id="BtnResetPassword" type="submit"
                                                            class="btn btn-danger" disabled>เปลี่ยน</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.tab-pane -->

                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
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