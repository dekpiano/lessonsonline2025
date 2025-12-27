<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="../../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">บทเรียนออนไลน์</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?=$_SESSION['FullName'];?><br> <small>Admin</small></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2 user-panel">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="../../../pages/Admin/Home/HomeMain" class="nav-link">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>
                            หน้าแรก
                        </p>
                    </a>
                </li>

                <!-- <li class="nav-item">
                    <a href="../../../pages/Admin/Course/CourseMain"
                        class="nav-link <?=uri(3) == "Course"?"active":""?> ">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>
                            สร้างคอร์สเรียน
                        </p>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a href="../../../pages/Admin/Teacher"
                        class="nav-link <?=uri(3) == "Teacher"?"active":""?> ">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>
                            จัดการครูผู้สอน
                        </p>
                    </a>
                </li> 
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
        <nav class="mt-2 user-panel">
                <ul class="nav nav-pills nav-sidebar" data-widget="treeview" role="menu"
                    data-accordion="false">

                    <li class="nav-item">
                        <a href="../../../php/Login/PhpLogoutMain" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                ออกจากระบบ
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
    </div>
    <!-- /.sidebar -->
</aside>