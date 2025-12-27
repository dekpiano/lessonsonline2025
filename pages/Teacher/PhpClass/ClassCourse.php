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
       
        if(empty($_SESSION['UserID']) && !$_SESSION['UserType'] == "teacher"){
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
        $query = "SELECT tb_courses.*,CONCAT(tb_users.UserPrefix,tb_users.UserFirstName,' ',tb_users.UserLastName) As FullNmae FROM tb_courses JOIN tb_users ON tb_courses.TeacherID = tb_users.UserID";

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

        $data = array('CourseCode','CourseName','CourseDescription','CourseStartDate','CourseEndDate','CourseDuration','CourseType','CourseStatus');

        foreach ($data as $key => $value) {
            $this->$value = $row[$value];
        }

        $this->CourseImageOld = $row['CourseImage'];
    }

    // เพิ่มคอร์สเรียนใหม่
    public function create() {

        $data = array('CourseCode','CourseName','CourseDescription','CourseStartDate','CourseEndDate','CourseDuration','CourseType','CourseImage','CourseStatus','TeacherID','CourseDateCreated');
        $ASum = array();
        foreach ($data as $key => $v_data) {
            $ASum[] = $v_data."=:".$v_data;
        }
        $sub = implode(',',$ASum);
        
        $query = "INSERT INTO " . $this->table_name . " SET ". $sub;

        $stmt = $this->conn->prepare($query);

        foreach ($data as $key => $v_data) {      
            // $this->$v_data=htmlspecialchars(strip_tags($this->$v_data));      
             $stmt->bindParam(":".$v_data, $this->$v_data);
         }  

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


    public function UpdateCourse() {

        $data = array('CourseName','CourseDescription','CourseStartDate','CourseEndDate','CourseDuration','CourseType','CourseImage');
        $ASum = array();
        foreach ($data as $key => $v_data) {
            $ASum[] = $v_data."=:".$v_data;
        }
        $sub = implode(',',$ASum);
        

        $query = "UPDATE " . $this->table_name . "
                  SET ".$sub."
                  WHERE CourseCode = :CourseCode ";

        $stmt = $this->conn->prepare($query);

        // ผูกค่า
        foreach ($data as $key => $v_data) {      
            // $this->$v_data=htmlspecialchars(strip_tags($this->$v_data));      
             $stmt->bindParam(":".$v_data, $this->$v_data);
         }  
         
        $stmt->bindParam(':CourseCode', $this->CourseCode);

        // ประมวลผลคำสั่ง
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function CheckPackageCourse() {

        $query = "SELECT COUNT(*) FROM tb_courses";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchColumn();

    }

    public function CheckLessons() {

        $query = "SELECT COUNT(*) FROM tb_lessons";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchColumn();

    }

    public function CheckEnrollments() {
        $query = "SELECT COUNT(*) FROM tb_enrollments";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchColumn();

    }

    public function CheckGraduation() {
        $query = "SELECT COUNT(*) FROM tb_enrollments WHERE EnrollCertificate != ''";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchColumn();

    }
}
?>
