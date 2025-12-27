<?php
date_default_timezone_set('Asia/Bangkok'); // ตั้งค่า Time Zone ตามที่ต้องการ

class ClassCourse {
    private $conn;
    private $table_name = "tb_courses";

    public $TitleBar = "คอร์สเรียน";
    public $CourseID;
    public $CourseName;
    public $CourseDescription;
    public $TeacherID;
    public $CourseDateCreated;

    public function __construct($db) {
        $this->conn = $db;
      
    }


    // อ่านข้อมูลคอร์สเรียนทั้งหมด
    public function read() {
        $query = "SELECT tb_courses.*,CONCAT(tb_users.UserPrefix,tb_users.UserFirstName,' ',tb_users.UserLastName) As FullNmae FROM tb_courses LEFT JOIN tb_users ON tb_courses.TeacherID = tb_users.UserID";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function readSingle() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE CourseID = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(1, $this->CourseID);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //print_r($row);
        // กำหนดค่าให้กับ properties
        $this->CourseCode = $row['CourseCode'];
        $this->CourseName = $row['CourseName'];
        $this->CourseDescription = $row['CourseDescription'];
        $this->CourseImage = $row['CourseImage'];
        $this->CourseStartDate = $row['CourseStartDate'];
        $this->CourseEndDate = $row['CourseEndDate'];
        $this->CourseImage = $row['CourseImage'];
    }

    public function readLessonsAll($CourseID) {
        $query = "SELECT * FROM tb_lessons WHERE CourseID = ? ORDER BY LessonNo ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $CourseID);
        $stmt->execute();
        return $stmt;
    }

    public function CourseMy() {
        if(empty($_SESSION['UserID']) && @!$_SESSION['UserType'] == "student"){
            header("Location: ../../../");
            exit();
        }
        $query = "SELECT tb_enrollments.*,tb_courses.CourseCode,tb_courses.CourseName,tb_courses.CourseImage,tb_courses.CourseStatus,CONCAT(tb_users.UserPrefix,tb_users.UserFirstName,' ',tb_users.UserLastName) As FullName 
        FROM tb_enrollments 
        LEFT JOIN tb_courses ON tb_courses.CourseID = tb_enrollments.CourseID
        LEFT JOIN tb_users ON tb_courses.TeacherID = tb_users.UserID
        WHERE tb_enrollments.UserID = ? ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $_SESSION['UserID']);
        $stmt->execute();
        return $stmt;
    }

    public function CourseProgress($CourseID) {
        if(empty($_SESSION['UserID']) && @!$_SESSION['UserType'] == "student"){
            header("Location: ../../../");
            exit();
        }
        
        $sql = "SELECT
        COUNT(*) AS total_lessons,
       SUM(CASE WHEN tb_lesson_progress.LessProStatus = 'เรียนสำเร็จ'  THEN 1 ELSE 0 END) AS completed_lessons,
       ROUND((SUM(CASE WHEN tb_lesson_progress.LessProStatus = 'เรียนสำเร็จ'  THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) AS progress_percentage
       FROM
       tb_lesson_progress
       INNER JOIN tb_enrollments ON tb_enrollments.EnrollmentID = tb_lesson_progress.EnrollmentID
       WHERE
       tb_enrollments.UserID = ? AND tb_enrollments.CourseID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $_SESSION['UserID']);
        $stmt->bindParam(2, $CourseID);
        $stmt->execute();
        return $stmt;
    }

    public function LessonsTotal($CourseID) {
        $query = "SELECT COUNT(*) AS TotalLessons FROM tb_lessons WHERE CourseID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $CourseID);
        $stmt->execute();
        return $stmt;
    }

    public function CheckDoAssessment($CourseID) {
        $query = "SELECT COUNT(*) AS DoAssessment FROM tb_assessments_responses WHERE course_id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $CourseID);
        $stmt->bindParam(2, $_SESSION['UserID']);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
?>
