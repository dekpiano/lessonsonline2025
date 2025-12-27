    <!-- Preloader -->
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="../../../dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60"
            width="60">
    </div> -->

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light border-0">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link font-weight-bold text-primary">ศูนย์วิทยาศาสตร์เพื่อการศึกษานครสวรรค์</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto align-items-center">
            <!-- Navbar Search -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search text-muted"></i>
                </a>
                <div class="navbar-search-block border-0 shadow-sm" style="border-radius: 12px; top: 10px; right: 10px; left: 10px;">
                    <form class="form-inline">
                        <div class="input-group input-group-sm w-100">
                            <input class="form-control form-control-navbar border-0" type="search" placeholder="ค้นหาบทเรียน..." aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <?php if(!empty($_SESSION['FullName'])):?>
            <li class="nav-item ml-2">
                <a class="nav-link btn btn-light text-primary rounded-pill px-3 py-1 shadow-sm" href="../../../pages/Users/Course/CourseMy" role="button" style="height: auto; border: 1px solid #f1f5f9;">
                    <i class="fas fa-book-reader mr-1"></i> คอร์สของฉัน
                </a>
            </li>
            <li class="nav-item dropdown ml-3">
                <a class="nav-link d-flex align-items-center p-0" data-toggle="dropdown" href="#">
                    <div class="d-none d-md-block text-right mr-2" style="line-height: 1.2;">
                       <span class="d-block font-weight-bold text-dark" style="font-size: 0.9rem;"><?=$_SESSION['FullName'];?></span>
                       <small class="text-muted">ผู้เรียน</small>
                    </div>
                    <!-- <img src="../../../dist/img/avatar5.png" class="img-circle shadow-sm" alt="User Image" style="width: 40px; height: 40px; object-fit: cover;"> -->
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right border-0 shadow-lg" style="border-radius: 16px; margin-top: 10px;">
                    <span class="dropdown-item dropdown-header text-left">เมนูจัดการ</span>
                    <a href="../../../pages/Users/Profile" class="dropdown-item" style="border-radius: 10px;">
                        <i class="fas fa-user-circle mr-2 text-primary"></i> ข้อมูลส่วนตัว
                    </a>
                    <div class="dropdown-divider my-1"></div>
                    <a href="../../../php/Login/PhpLogoutMain" class="dropdown-item text-danger" style="border-radius: 10px;">
                        <i class="fas fa-sign-out-alt mr-2"></i> ออกจากระบบ
                    </a>
                </div>
            </li>
            <?php else:  ?>
            <li class="nav-item">
                <a href="#" class="btn btn-primary rounded-pill px-4 shadow-sm ml-3" data-toggle="modal" data-target="#ModalLogin">
                    <i class="fas fa-sign-in-alt mr-1"></i> เข้าสู่ระบบ
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
    <!-- /.navbar -->