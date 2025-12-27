    <!-- Preloader -->
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="../../../dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60"
            width="60">
    </div> -->

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light elevation-2">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li> -->
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">ศูนย์วิทยาศาสตร์เพื่อการศึกษานครสวรรค์</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                aria-label="Search">
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
            <li class="nav-item">
                <a class="nav-link active" href="../../../pages/Users/Course/CourseMy" role="button">
                    คอร์สเรียนของฉัน
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                    <i class="fas fa-user"></i> <?=$_SESSION['FullName'];?>
                </a>
                <div class="dropdown-menu  dropdown-menu-right">
                    <!-- <a href="../../../Users/Profile" class="dropdown-item">
                    <i class="fas fa-user-circle"></i> บัญชี
                    </a> -->
                    <div class="dropdown-divider"></div>
                    <a href="../../../php/Login/PhpLogoutMain" class="dropdown-item">
                        <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
                    </a>
                </div>
            </li>
            <?php else:  ?>
            <li class="nav-item">
                <a href="#" class="nav-link" data-toggle="modal" data-target="#ModalLogin">
                    <i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ
                </a>
            </li>
            <?php endif; ?>
            <!-- <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li> -->

        </ul>
    </nav>
    <!-- /.navbar -->