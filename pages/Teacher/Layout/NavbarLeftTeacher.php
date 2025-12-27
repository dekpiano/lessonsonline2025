<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../" class="brand-link">
        <img src="../../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">บทเรียนออนไลน์</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            <h3><i class="fas fa-user-tie text-white fa-xl"></i></h3>
            </div>
            <div class="info">
                <a href="#" class="d-block"><?=$_SESSION['FullName'];?><br> <small>ครูผู้สอน</small></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <div class="d-flex flex-column justify-content-between">
            <nav class="mt-2 user-panel">
                <ul class="nav nav-pills nav-sidebar" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a href="../" class="nav-link <?=uri(3) == "Home"?"active":""?>">
                            <i class="nav-icon fas fa-columns"></i>
                            <p>
                                หน้าแรก
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="../../../pages/Teacher/Course/CourseMain"
                            class="nav-link <?=uri(3) == "Course" || uri(3) == "Lesson" || uri(3) == "Quizzes" ?"active":""?> ">
                            <i class="nav-icon fas fa-columns"></i>
                            <p>
                                คอร์สเรียน
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
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

        <!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->
</aside>