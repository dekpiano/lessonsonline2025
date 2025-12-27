<?php 
include_once '../../../php/Database/Database.php'; 
include_once '../../Users/PhpClass/ClassLearn.php';
include_once '../../../pages/Users/PhpClass/ClassRegisterUser.php';
$database = new Database();
$db = $database->getConnection();
$Title = "สมัครสมาชิก | Lessons Online";
$User = new ClassRegisterUser($db);
$Course = new ClassLearn($db);
?>
<?php include_once('../../../pages/Users/Layout/HeaderUser.php') ?>

<style>
    .register-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 40px 0;
    }

    .register-card {
        background: white;
        border-radius: 30px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        overflow: hidden;
        max-width: 1000px;
        width: 100%;
        display: flex;
        flex-wrap: wrap;
    }

    .register-hero {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        flex: 1 1 400px;
        padding: 60px;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
    }

    .register-form-side {
        flex: 1 1 500px;
        padding: 50px;
        background: white;
    }

    .form-section-title {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--primary);
        font-weight: 700;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-section-title::after {
        content: "";
        height: 1px;
        background: var(--primary);
        flex-grow: 1;
        opacity: 0.2;
    }

    .input-group-custom {
        margin-bottom: 20px;
    }

    .input-group-custom label {
        display: block;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 8px;
        color: var(--text-dark);
    }

    .error-msg {
        color: var(--danger);
        font-size: 0.75rem;
        margin-top: 5px;
        display: block;
    }

    .valid-msg {
        color: var(--success);
        font-size: 0.75rem;
        margin-top: 5px;
        display: block;
    }

    .password-feedback {
        background: #f8fafc;
        padding: 12px;
        border-radius: 12px;
        margin-bottom: 15px;
        font-size: 0.8rem;
    }

    .feedback-item { display: flex; align-items: center; gap: 8px; margin-bottom: 4px; color: #94a3b8; }
    .feedback-item.valid { color: var(--success); }
    .feedback-item.valid i::before { content: "\f00c"; }

    /* Improved Input Styling */
    .form-control {
        height: 50px;
        padding-left: 20px;
        border-radius: 12px;
        border: 2px solid #eef2f6;
        background-color: #f8fafc;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary);
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(var(--primary-rgb), 0.1);
    }

    /* Fix Placeholder Visibility */
    .form-control::placeholder {
        color: #94a3b8 !important;
        opacity: 1;
        font-weight: 400;
    }
    
    .form-control:-ms-input-placeholder { color: #94a3b8 !important; }
    .form-control::-ms-input-placeholder { color: #94a3b8 !important; }

    /* Input Group Styling */
    .input-group-text {
        border-radius: 12px 0 0 12px;
        border: 2px solid #eef2f6;
        border-right: none;
        background-color: #f8fafc;
        color: #64748b;
    }
    
    .input-group .form-control {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .input-group .input-group-prepend + .form-control {
        border-left: none;
    }
    
    .input-group-append .btn, .input-group-append .input-group-text {
        border-radius: 0 12px 12px 0;
        border: 2px solid #eef2f6;
        border-left: none;
        background-color: #f8fafc;
    }

    @media (max-width: 768px) {
        .register-hero { display: none; }
        .register-form-side { padding: 30px 20px; }
        .register-card { border-radius: 0; }
        .register-container { padding: 0; background: white; }
    }
</style>

<body class="hold-transition">
    <div class="register-container d-flex align-items-center justify-content-center">
        <div class="register-card">
            <!-- Left Side: Hero -->
            <div class="register-hero">
                <img src="../../../dist/img/AdminLTELogo.png" alt="Logo" class="mx-auto mb-4" style="width: 100px; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));">
                <h2 class="mb-3">ร่วมเป็นส่วนหนึ่งกับเรา</h2>
                <p class="opacity-80">เปิดประตูสู่การเรียนรู้ที่ไร้ขีดจำกัด เข้าถึงบทเรียนคุณภาพได้ทุกที่ ทุกเวลา</p>
                <div class="mt-5 text-left">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px; flex-shrink: 0;">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 font-weight-bold">รับเกียรติบัตร</h6>
                            <small class="opacity-70">สำเร็จหลักสูตรพร้อมรับใบประกาศ</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px; flex-shrink: 0;">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 font-weight-bold">รองรับมือถือ</h6>
                            <small class="opacity-70">เรียนได้สะดวกบนทุกเครื่องมือ</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="register-form-side">
                <div class="text-center mb-5 d-md-none">
                    <img src="../../../dist/img/AdminLTELogo.png" style="width: 60px;">
                    <h3 class="mt-2 font-weight-bold">สมัครสมาชิก</h3>
                </div>
                
                <h3 class="font-weight-bold mb-4 d-none d-md-block">สมัครสมาชิก</h3>
                
                <form method="post" id="FormRegisterUser" class="needs-validation" novalidate>
                    <!-- Account Section -->
                    <div class="form-section-title">ข้อมูลบัญชีผู้ใช้</div>
                    
                    <div class="input-group-custom">
                        <label>อีเมลสำหรับการเข้าใช้งาน <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" placeholder="ตัวอย่าง: student@school.ac.th" id="Email" name="Email" required onkeyup="CheckEmailRegister()">
                        </div>
                        <div id="emailStatus" class="mt-2"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group-custom">
                                <label>รหัสผ่าน <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" placeholder="รหัสผ่านอย่างน้อย 8 ตัวอักษร" id="Password" name="Password" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fa fa-eye"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group-custom">
                                <label>ยืนยันรหัสผ่าน <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                    </div>
                                    <input type="password" class="form-control" placeholder="กรอกรหัสผ่านอีกครั้ง" id="ConfirmPassword" name="ConfirmPassword" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="password-feedback">
                        <div class="feedback-item" id="feedback-length"><i class="fas fa-circle xsmall"></i> อย่างน้อย 8 ตัวอักษร</div>
                        <div class="feedback-item" id="feedback-match"><i class="fas fa-circle xsmall"></i> รหัสผ่านตรงกัน</div>
                    </div>

                    <!-- Personal Section -->
                    <div class="form-section-title pt-3">ข้อมูลส่วนตัว</div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group-custom">
                                <label>คำนำหน้า <span class="text-danger">*</span></label>
                                <select name="UserPrefix" id="UserPrefix" class="form-control" required>
                                    <option value="" disabled selected>เลือกคำนำหน้า</option>
                                    <option value="เด็กชาย">เด็กชาย</option>
                                    <option value="เด็กหญิง">เด็กหญิง</option>
                                    <option value="นาย">นาย</option>
                                    <option value="นาง">นาง</option>
                                    <option value="นางสาว">นางสาว</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group-custom">
                                <label>ชื่อจริง <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="ไม่ต้องใส่คำนำหน้า" name="UserFirstName" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group-custom">
                                <label>นามสกุล <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="นามสกุลภาษาไทย" name="UserLastName" required>
                            </div>
                        </div>
                    </div>

                    <div class="input-group-custom">
                        <label>เลขประจำตัวประชาชน 13 หลัก <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="1234567890123" id="UserIdCard" name="UserIdCard" required pattern="\d*" maxlength="13">
                        <div id="message13" class="small mt-1"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group-custom">
                                <label>วันเดือนปีเกิด <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="UserBirthday" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group-custom">
                                <label>เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" placeholder="08XXXXXXXX" id="UserPhone" name="UserPhone" required data-inputmask="'mask': '9999999999'">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group-custom">
                                <label>ช่วงอายุ <span class="text-danger">*</span></label>
                                <select name="UserRangeAge" class="form-control" required>
                                    <option value="" selected disabled>เลือกช่วงอายุ</option>
                                    <?php $RangeAge = $User->RangeAge(); while($row = $RangeAge->fetch(PDO::FETCH_ASSOC)): ?>
                                        <option value="<?=$row['rangeage_id']?>"><?=$row['rangeage_title']?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group-custom">
                                <label>ระดับการศึกษา <span class="text-danger">*</span></label>
                                <select name="UserLevelEdu" class="form-control" required>
                                    <option value="" selected disabled>เลือกระดับการศึกษา</option>
                                    <?php $LevelEdu = $User->LevelEdu(); while($row = $LevelEdu->fetch(PDO::FETCH_ASSOC)): ?>
                                        <option value="<?=$row['edu_id']?>"><?=$row['edu_title']?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="input-group-custom">
                        <label>ประเภทผู้ใช้บริการ <span class="text-danger">*</span></label>
                        <select name="UserTypeService" class="form-control" required>
                            <option value="" selected disabled>เลือกประเภทผู้บริการ</option>
                            <?php $type = $User->TypeService(); while($row = $type->fetch(PDO::FETCH_ASSOC)): ?>
                                <option value="<?=$row['typeser_id']?>"><?=$row['typeser_title']?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="py-3">
                        <button type="submit" id="BtnSubmitRegister" class="btn btn-primary btn-block btn-lg shadow-lg mb-4" style="height: 60px; border-radius: 18px;" disabled>
                            สร้างบัญชีผู้ใช้งาน <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                        
                        <div class="text-center">
                            <span class="text-muted small">มีบัญชีอยู่แล้ว?</span>
                            <a href="#" class="small font-weight-bold text-primary ml-1" data-toggle="modal" data-target="#ModalLogin">เข้าสู่ระบบที่นี่</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Ensure internal scripts work with new UI -->
    <style>
        .feedback-item.valid { color: #10b981; font-weight: 600; }
        .feedback-item.valid i::before { content: "\f058"; }
    </style>
    
    <?php include_once('../../../pages/Users/Layout/FooterUser.php'); ?>
</body>
</html>