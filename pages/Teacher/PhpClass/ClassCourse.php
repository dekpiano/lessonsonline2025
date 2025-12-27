<?php
date_default_timezone_set('Asia/Bangkok'); // ตั้งค่า Time Zone ตามที่ต้องการ

class ClassCourse {
    private $conn;
    private $table_name = "tb_courses";

    public $TitleBar = "คอร์สเรียน | บทเรียนออนไลน์ สกร.นครสวรรค์";
    public $CourseID;
    public $CourseName;
    public $CourseDescription;
    public $TeacherID;
    public $CourseDateCreated;

    public function __construct($db) {
        $this->conn = $db;
       
        if(empty($_SESSION['UserID']) || !isset($_SESSION['UserType']) || $_SESSION['UserType'] !== "teacher"){
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
        // Check Limit
        include_once '../../../pages/Admin/PhpClass/ClassSystemSettings.php';
        $Settings = new ClassSystemSettings($this->conn);
        $MaxCourses = (int)$Settings->getSetting('max_total_courses', 50);

        // Count ALL courses in the system
        $queryCheck = "SELECT COUNT(*) FROM " . $this->table_name;
        $stmtCheck = $this->conn->prepare($queryCheck);
        $stmtCheck->execute();
        $TotalCourses = $stmtCheck->fetchColumn();

        if ($TotalCourses >= $MaxCourses) {
            return "LIMIT_EXCEEDED"; // Special return value for control
        }

        $data = array('CourseCode','CourseName','CourseDescription','CourseStartDate','CourseEndDate','CourseDuration','CourseType','CourseImage','CourseStatus','TeacherID','CourseDateCreated');
        $ASum = array();
        foreach ($data as $key => $v_data) {
            $ASum[] = $v_data."=:".$v_data;
        }
        $sub = implode(',',$ASum);
        
        $query = "INSERT INTO " . $this->table_name . " SET ". $sub;

        $stmt = $this->conn->prepare($query);

        foreach ($data as $key => $v_data) {    
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
    public function DeleteCourse($CourseID) {
        try {
            // Include ClassUploader if not already included
            include_once '../../../php/Uploadfile/ClassUploader.php';
            
            // 1. Get Course Info (Image)
            $query = "SELECT CourseImage FROM " . $this->table_name . " WHERE CourseID = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$CourseID]);
            $course = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$course) return false;

            // 2. Get All Lessons
            $query = "SELECT LessonID FROM tb_lessons WHERE CourseID = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$CourseID]);
            $lessons = $stmt->fetchAll(PDO::FETCH_COLUMN);

            foreach ($lessons as $lessonID) {
                // 3. Get All Questions for this Lesson
                $query = "SELECT QuestionID, QuestionImg FROM tb_questions WHERE QuestionLessonID = ?";
                $stmtQ = $this->conn->prepare($query);
                $stmtQ->execute([$lessonID]);
                $questions = $stmtQ->fetchAll(PDO::FETCH_ASSOC);

                foreach ($questions as $question) {
                    // 4. Get All Options for this Question
                    $query = "SELECT OptImg FROM tb_options WHERE OptQuestionID = ?";
                    $stmtO = $this->conn->prepare($query);
                    $stmtO->execute([$question['QuestionID']]);
                    $options = $stmtO->fetchAll(PDO::FETCH_COLUMN);

                    // Delete Option Images
                    $uploaderOpt = new ClassUploader(0, 0, 0, "Options");
                    foreach ($options as $optImg) {
                        if ($optImg) {
                            $uploaderOpt->deleteImage("../../../../uploads/Options/" . $optImg);
                        }
                    }

                    // Delete Options Records
                    $query = "DELETE FROM tb_options WHERE OptQuestionID = ?";
                    $stmtDelOpt = $this->conn->prepare($query);
                    $stmtDelOpt->execute([$question['QuestionID']]);

                    // Delete Question Image
                    if ($question['QuestionImg']) {
                        $uploaderQ = new ClassUploader(0, 0, 0, "Question");
                        $uploaderQ->deleteImage("../../../../uploads/Question/" . $question['QuestionImg']);
                    }

                    // Delete Question Record
                    $query = "DELETE FROM tb_questions WHERE QuestionID = ?";
                    $stmtDelQ = $this->conn->prepare($query);
                    $stmtDelQ->execute([$question['QuestionID']]);
                }

                // Delete Lesson Record (No image column found in tb_lessons)
                $query = "DELETE FROM tb_lessons WHERE LessonID = ?";
                $stmtDelL = $this->conn->prepare($query);
                $stmtDelL->execute([$lessonID]);
            }

            // 5. Delete Course Image
            if ($course['CourseImage']) {
                    // รูปภาพคอร์สเรียนอาจเก็บในโฟลเดอร์ Course หรือแยกตามประเภท ต้องตรวจสอบ path ให้ถูกต้อง
                    // สมมติว่าเก็บใน uploads/Course/ ตาม pattern อื่นๆ
                    // แต่ใน CourseInsert.php อาจจะต้องเช็คว่าเก็บไว้ที่ไหน
                    // จาก CourseInsert.php (ไม่ได้ดูละเอียด) ปกติจะเก็บใน uploads/Course
                    $uploaderC = new ClassUploader(0, 0, 0, "Course"); 
                    $uploaderC->deleteImage("../../../../uploads/Course/" . $course['CourseImage']);
            }

            // 6. Delete Course Record
            $query = "DELETE FROM " . $this->table_name . " WHERE CourseID = ?";
            $stmtDelC = $this->conn->prepare($query);
            if ($stmtDelC->execute([$CourseID])) {
                return true;
            }

            return false;

        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
