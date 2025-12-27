<?php
date_default_timezone_set('Asia/Bangkok'); // ตั้งค่า Time Zone ตามที่ต้องการ

class ClassLesson {
    private $conn;
    private $table_name = "tb_lessons";

    public $TitleBar = "บทเรียน";
    public $CourseID;
    public $LessonCode;
    public $LessonNo;
    public $LessonTitle;
    public $LessonContent;
    public $LessonVideoURL;
    public $LessonDateCreated;
    public $CourseName;
    public $CourseCode;

    public function __construct($db) {
        $this->conn = $db;
       
        if(empty($_SESSION['UserID']) && !$_SESSION['UserType'] == "teacher"){
            header("Location: ../../../");
            exit();
        }
    }

    public function getNewLessonCode() {
        $query = "SELECT LessonCode FROM " . $this->table_name . " ORDER BY LessonCode DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $lastCode = $stmt->fetchColumn();
        
        if ($lastCode) {
            $number = str_replace("Lesson_", "", $lastCode); // ลบส่วนของข้อความ "Con_" ออก
            $newNumber = str_pad((int)$number + 1, 4, "0", STR_PAD_LEFT); // แปลงเป็นตัวเลข, เพิ่มค่าขึ้น 1, แล้วเติม 0 ให้ครบ 3 หลัก
            $newCode = "Lesson_" . $newNumber;
        } else {
            // หากไม่มีรหัสใดๆ ในฐานข้อมูล
            $newCode = "Lesson_0001";
        }
        
        return $newCode;
    }


    // อ่านข้อมูลบทเรียนทั้งหมด
    public function read() {
        $query = "SELECT * FROM tb_lessons WHERE CourseID = ?";

        $stmt = $this->conn->prepare($query);

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(1, $this->CourseID);

        $stmt->execute();
        return $stmt;
    }

    public function readCourse() {
        $query = "SELECT * FROM tb_courses WHERE CourseID = ?";

        $stmt = $this->conn->prepare($query);

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(1, $this->CourseID);

        $stmt->execute();
       
        $row = $stmt->fetch(PDO::FETCH_ASSOC);    
       
        //print_r($row['CourseCode']);
        // กำหนดค่าให้กับ properties

        $this->CourseCode = $row['CourseCode'];
        $this->CourseName = $row['CourseName'];
        $this->CourseDescription = $row['CourseDescription'];
    }

    public function readLessonEdit() {
        $query = "SELECT tb_lessons.*,tb_courses.CourseName FROM " . $this->table_name . " 
        JOIN tb_courses ON tb_courses.CourseID = tb_lessons.CourseID
        WHERE LessonID = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        // ผูกค่าพารามิเตอร์
        $stmt->bindParam(1, $this->LessonID);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //print_r($row);
        // กำหนดค่าให้กับ properties
        $this->CourseID = $row['CourseID'];
        $this->CourseName = $row['CourseName'];
        $this->LessonCode = $row['LessonCode'];
        $this->LessonTitle = $row['LessonTitle'];
        $this->LessonNo = $row['LessonNo'];
        $this->LessonContent = $row['LessonContent'];
        $this->LessonVideoURL = $row['LessonVideoURL'];
        $this->LessonStudyTime = $row['LessonStudyTime'];
    }

    // เพิ่มบทเรียนใหม่
    public function create() {
        $query = "INSERT INTO tb_lessons (CourseID,LessonCode,LessonNo,LessonTitle,LessonContent,LessonVideoURL,LessonDateCreated,TeacherID,LessonStudyTime) VALUES (?,?,?,?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($query);
        $data = array('CourseID','LessonCode','LessonNo','LessonTitle','LessonContent','LessonVideoURL','LessonDateCreated','TeacherID','LessonStudyTime');
        // sanitize
        foreach ($data as $key => $v_data) {      
           // $this->$v_data=htmlspecialchars(strip_tags($this->$v_data));      
            $stmt->bindValue(($key+1), $this->$v_data);
        }       

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function UpdateLesson() {
        $query = "UPDATE " . $this->table_name . "
                  SET LessonNo=:LessonNo,LessonTitle=:LessonTitle,LessonContent=:LessonContent,LessonVideoURL=:LessonVideoURL,LessonStudyTime=:LessonStudyTime
                  WHERE LessonCode = :LessonCode";

        $stmt = $this->conn->prepare($query);

        $data = array('LessonCode','LessonNo','LessonTitle','LessonContent','LessonVideoURL','LessonStudyTime');
        // sanitize
        foreach ($data as $key => $v_data) {      
           // $this->$v_data=htmlspecialchars(strip_tags($this->$v_data));      
            $stmt->bindParam(":".$v_data, $this->$v_data);
        }   

        // ประมวลผลคำสั่ง LessonCode=:LessonCode,
        if($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
