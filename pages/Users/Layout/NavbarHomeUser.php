<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">

        <div class="d-block d-md-none ml-2">
            <a href="../../../" class="navbar-brand">
                <div class="d-flex justify-content-center align-items-center ">
                    <img src="../../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                        class="brand-image img-circle elevation-3" style="opacity: .8">
                    <div>
                        <span class="brand-text font-weight-light " style="font-size: 16px;">บทเรียนออนไลน์ <br>
                            ศูนย์วิทยาศาสตร์เพื่อการศึกษานครสวรรค์</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="d-none d-md-block">
            <a href="../../../" class="navbar-brand">
                <div class="d-flex justify-content-center align-items-center ">
                    <img src="../../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                        class="brand-image img-circle elevation-3" style="opacity: .8">
                    <div>
                        <span class="brand-text font-weight-light">บทเรียนออนไลน์ ศูนย์วิทยาศาสตร์เพื่อการศึกษานครสวรรค์</span>
                    </div>
                </div>
            </a>
        </div>


        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        
            <!-- Right navbar links -->
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <?php if(!empty($_SESSION['FullName'])):?>
                <li class="nav-item">
                    <a class="nav-link <?php echo uri(4) == "CourseMy"?"active":"";?>  " href="../../../pages/Users/Course/CourseMy" role="button">
                        คอร์สเรียนของฉัน
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fas fa-user"></i> <?=$_SESSION['FullName'];?>
                    </a>
                    <div class="dropdown-menu  dropdown-menu-right">
                        <!-- <a href="../../../Pages/Users/Profile" class="dropdown-item">
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
                    <a class="nav-link btn btn-sm btn-secondary text-white mr-2" href="../../Users/Register"
                        role="button">
                        <i class="fas fa-user-plus fa-1x"></i> สมัครเรียน
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-primary text-white" href="#" data-toggle="modal"
                        data-target="#ModalLogin">
                        <i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ
                    </a>
                </li>
                <?php endif; ?>


            </ul>
        </div>
</nav>