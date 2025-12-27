<?php
class ClassHome {
    private $conn;
    private $table_name = "tb_courses";

    public $TitleBar = "หน้าแรก";

    public function __construct($db) {
        $this->conn = $db;
       
        if(empty($_SESSION['UserID'])){
            header("Location: ../../../");
            exit();
        }
    }

    public function getNewCourseCode() {
        $query = "SELECT CourseCode FROM " . $this->table_name . " ORDER BY CourseCode DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $lastCode = $stmt->fetchColumn();
        
        if ($lastCode) {
            $number = str_replace("Course_", "", $lastCode); // ลบส่วนของข้อความ "Con_" ออก
            $newNumber = str_pad((int)$number + 1, 4, "0", STR_PAD_LEFT); // แปลงเป็นตัวเลข, เพิ่มค่าขึ้น 1, แล้วเติม 0 ให้ครบ 3 หลัก
            $newCode = "Course_" . $newNumber;
        } else {
            // หากไม่มีรหัสใดๆ ในฐานข้อมูล
            $newCode = "Course_0001";
        }
        
        return $newCode;
    }


    // อ่านข้อมูลคอร์สเรียนทั้งหมด
    public function read() {
        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function CheckRegisterAll(){

        $query = "SELECT UserPrefix,UserFirstName,UserLastName,UserPhone,DateCreated,Email FROM tb_users WHERE UserType = 'student'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function CheckLessonsAll(){

        $query = "SELECT LessonNo,LessonTitle FROM tb_lessons";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function CheckCoursesAll(){

        $query = "SELECT CourseCode,CourseName FROM tb_courses";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function CheckPackageCourse() {

        $query = "SELECT COUNT(*) FROM tb_users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchColumn();

    }

    public function CheckUserEnrollments() {

        $query = "SELECT 
        tb_enrollments.UserID,
        tb_enrollments.EnrollmentID,
        tb_enrollments.CourseID,
        tb_users.UserPrefix,
        tb_users.UserFirstName,
        tb_users.UserLastName,
        tb_courses.CourseName,
        tb_users.UserPhone,
        tb_enrollments.EnrollDate,
        tb_users.Email
        FROM tb_enrollments
        INNER JOIN tb_courses ON tb_enrollments.CourseID = tb_courses.CourseID
        INNER JOIN tb_users ON tb_enrollments.UserID = tb_users.UserID";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;

    }
    

}
?>
