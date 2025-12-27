<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../../" class="brand-link">
        <img src="../../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">บทเรียนออนไลน์</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <?php if(!@$_SESSION['UserType']) :?>
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <i class="fas fa-sign-in-alt fa-2x"></i>
            </div>
            <div class="info">
                <a href="#" class="d-block" data-toggle="modal" data-target="#ModalLogin">เข้าสู่ระบบ</a>
            </div>
        </div>
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <i class="fas fa-user-plus fa-2x"></i>
            </div>
            <div class="info">
                <a href="../Register" class="d-block">สมัครเรียน</a>
            </div>
        </div>
        <?php else : ?>

        <?php endif; ?>

        <?php if(!empty($_SESSION['UserID'])): ?>
        <div class="mt-3">
            คอร์สเรียน
        </div>
        <h5 class=""><?=$rowLesMain['CourseName']?></h5>
        <hr>
        <div>
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php while($row = $Resutl->fetch(PDO::FETCH_ASSOC)) : 
              ?>
                <li class="nav-item">
                    <a href="../Learn/?Course=<?=@$_GET['Course']?>&Leeson=<?=$row['LessonNo']?>"
                        class="nav-link reloadButton <?= @$_GET['Course'] == $row['CourseID'] && @$_GET['Leeson'] == $row['LessonNo'] ? "active":""?> ">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>
                            บทที่ <?=$row['LessonNo']?> <?=$row['LessonTitle']?>

                            <?php $CheckStatusLesson = $Course->CheckStatusLesson($row['CourseID'],$row['LessonNo'])->fetch(PDO::FETCH_ASSOC); 
                        //print_r($CheckStatusLesson);
                        ?>

                            <?php if(@$CheckStatusLesson['LessProStatus'] == "เรียนสำเร็จ"): ?>
                            <span id="LessonNo<?=$row['LessonNo']?>" class="badge badge-success right"> <i
                                    class="fas fa-check" style="margin-left: 0rem"></i> </span>
                            <?php endif;?>
                        </p>
                    </a>
                </li>
                <?php endwhile; ?>
            </ul>
            <hr>
            <ul class="nav nav-pills nav-sidebar flex-column">
                <?php if(@$CourseProgress['completed_lessons'] == @$CourseProgress['total_lessons']) {
                            $disabled = "";
                            $href = "../Assessment?Course=".@$_GET['Course'];
                       }else{                           
                            $disabled = 'disabled';
                            $href = '#'; 
                       }
                ?>
                <li class="nav-item"><a href="<?=$href;?>"
                        class="btn btn-block btn-success text-white <?=$disabled;?>">แบบประเมิน</a></li>
            </ul>
        </div>


        <?php endif; ?>
    </div>
    <!-- /.sidebar -->
</aside>