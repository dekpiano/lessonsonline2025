<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-0">
    <!-- Brand Logo -->
    <a href="../../../" class="brand-link d-flex align-items-center pl-3">
        <img src="../../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle shadow-sm"
            style="opacity: .9; width: 35px; height: 35px;">
        <span class="brand-text font-weight-bold ml-2 text-dark">บทเรียนออนไลน์</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar p-3">
        <!-- Sidebar user panel (optional) -->
        <?php if(!@$_SESSION['UserType']) :?>
        <div class="card shadow-sm border-0 mb-3 bg-white" style="border-radius: 12px;">
            <div class="card-body p-3">
                <h6 class="font-weight-bold text-center mb-3">ยินดีต้อนรับ</h6>
                <a href="#" class="btn btn-primary btn-block mb-2 rounded-lg" data-toggle="modal" data-target="#ModalLogin">
                    <i class="fas fa-sign-in-alt mr-1"></i> เข้าสู่ระบบ
                </a>
                <a href="../Register" class="btn btn-outline-primary btn-block rounded-lg mt-0">
                    <i class="fas fa-user-plus mr-1"></i> สมัครสมาชิก
                </a>
            </div>
        </div>
        <?php endif; ?>

        <?php if(!empty($_SESSION['UserID'])): ?>
        
        <?php if(isset($rowLesMain['CourseName'])): ?>
        <div class="user-panel mt-2 mb-4">
            <small class="text-uppercase text-muted font-weight-bold ml-2">คอร์สเรียนปัจจุบัน</small>
            <h5 class="mt-2 mb-0 px-2 font-weight-bold text-dark" style="line-height:1.4"><?=$rowLesMain['CourseName']?></h5>
        </div>
        
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-header">เนื้อหาบทเรียน</li>
                
                <?php while($row = $Resutl->fetch(PDO::FETCH_ASSOC)) : ?>
                <li class="nav-item">
                    <a href="../Learn/?Course=<?=@$_GET['Course']?>&Leeson=<?=$row['LessonNo']?>"
                        class="nav-link reloadButton <?= @$_GET['Course'] == $row['CourseID'] && @$_GET['Leeson'] == $row['LessonNo'] ? "active":""?> ">
                        <i class="nav-icon fas fa-book-open" style="font-size: 0.9rem;"></i>
                        <p class="text-sm font-weight-medium">
                            บทที่ <?=$row['LessonNo']?> <?=$row['LessonTitle']?>
                            
                            <?php $CheckStatusLesson = $Course->CheckStatusLesson($row['CourseID'],$row['LessonNo'])->fetch(PDO::FETCH_ASSOC); ?>

                            <?php if(@$CheckStatusLesson['LessProStatus'] == "เรียนสำเร็จ"): ?>
                            <i class="fas fa-check-circle text-success float-right ml-2 mt-1"></i>
                            <?php endif;?>
                        </p>
                    </a>
                </li>
                <?php endwhile; ?>
                
                <li class="nav-header mt-3">การวัดผล</li>
                
                <?php if(@$CourseProgress['completed_lessons'] == @$CourseProgress['total_lessons']) {
                            $disabled = "";
                            $href = "../Assessment?Course=".@$_GET['Course'];
                            $btnClass = "btn-success shadow";
                            $icon = "fa-check";
                       }else{                           
                            $disabled = 'disabled';
                            $href = '#'; 
                            $btnClass = "btn-light text-muted";
                            $icon = "fa-lock";
                       }
                ?>
                <li class="nav-item mt-2">
                    <a href="<?=$href;?>" class="btn btn-block <?=$btnClass;?> <?=$disabled;?> text-left pl-3 py-2 rounded-lg" 
                       style="border: 1px solid rgba(0,0,0,0.05);">
                        <i class="fas <?=$icon;?> mr-2"></i> แบบประเมินคอร์สเรียน
                    </a>
                </li>
            </ul>
        </nav>
        <?php else: ?>
            <!-- Fallback content if not inside a specific course -->
            <nav class="mt-4">
                <ul class="nav nav-pills nav-sidebar flex-column">
                    <li class="nav-header">เมนูหลัก</li>
                    <li class="nav-item">
                        <a href="../../../pages/Users/Course/CourseMy" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>คอร์สเรียนของฉัน</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../../../pages/Users/Profile" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>ข้อมูลส่วนตัว</p>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>

        <?php endif; ?>
    </div>
    <!-- /.sidebar -->
</aside>