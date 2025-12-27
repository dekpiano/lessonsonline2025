<nav class="main-header navbar navbar-expand-md navbar-light bg-white sticky-top py-2">
    <div class="container px-md-3">
        <a href="../../../" class="navbar-brand d-flex align-items-center gap-2">
            <img src="../../../dist/img/AdminLTELogo.png" alt="Logo" class="brand-image" style="width: 40px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));">
            <div class="brand-text-wrapper ml-1">
                <span class="font-weight-bold h5 mb-0 d-block" style="color: var(--primary); letter-spacing: -0.5px;">LESSONS ONLINE</span>
                <small class="text-muted d-none d-md-block" style="font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">ศูนย์วิทยาศาสตร์เพื่อการศึกษานครสวรรค์</small>
            </div>
        </a>

        <button class="navbar-toggler border-0 p-2" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="fas fa-bars text-muted"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ml-auto align-items-md-center gap-3 mt-3 mt-md-0">
                <?php if(!empty($_SESSION['FullName'])):?>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded-pill <?php echo uri(4) == "CourseMy" ? "active bg-primary text-white" : "text-dark"; ?>" href="../../../pages/Users/Course/CourseMy">
                            <i class="fas fa-book-open mr-1"></i> คอร์สของฉัน
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle bg-light rounded-pill px-3 py-2 d-flex align-items-center gap-2" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <div class="user-avatar bg-primary text-white d-flex align-items-center justify-content-center rounded-circle" style="width: 28px; height: 28px; font-size: 12px;">
                                <?= mb_substr($_SESSION['FullName'], 0, 1, 'UTF-8'); ?>
                            </div>
                            <span class="d-none d-inline-block font-weight-600"><?=$_SESSION['FullName'];?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right border-0 shadow-lg mt-2" style="border-radius: 15px;">
                            <a href="../../../php/Login/PhpLogoutMain" class="dropdown-item py-2 text-danger">
                                <i class="fas fa-sign-out-alt mr-2"></i> ออกจากระบบ
                            </a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark font-weight-600 px-3" href="#" data-toggle="modal" data-target="#ModalLogin">
                            เข้าสู่ระบบ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary rounded-pill px-4 shadow-sm" href="../../Users/Register">
                            สมัครสมาชิก
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<style>
    .gap-2 { gap: 0.5rem; }
    .gap-3 { gap: 1rem; }
    .font-weight-600 { font-weight: 600; }
    
    #navbarCollapse .nav-link.active {
        background: var(--primary) !important;
        color: white !important;
        box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
    }
    
    #navbarCollapse .nav-link:not(.active):hover {
        color: var(--primary) !important;
        background: rgba(99, 102, 241, 0.05);
        border-radius: 50px;
    }

    @media (max-width: 767px) {
        .navbar-nav { padding-bottom: 1rem; }
        .nav-item { margin-bottom: 0.5rem; }
        .btn-primary { width: 100%; text-align: center; }
    }
</style>