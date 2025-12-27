<?php
date_default_timezone_set('Asia/Bangkok'); // ตั้งค่า Time Zone ตามที่ต้องการ

class ClassEnrollmentUser {
    private $conn;
    private $table_name = "tb_enrollments";

    public $TitleBar = "ลงทะเบียนเรียน";

    public function __construct($db) {
        $this->conn = $db;

        // if(empty($_SESSION['UserID']) && @!$_SESSION['UserType'] == "student"){
        //     header("Location: ../../../");
        //     exit();
        // }
    }

        // เพิ่มสมัครเรียนใหม่
        public function EnrollmentUserInsert() {

            $data = array('CourseID','UserID','EnrollDate');
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

                $EnrollmentID = $this->conn->lastInsertId();

                $SelLesson = "SELECT LessonID FROM tb_lessons WHERE CourseID = ?";
                $Q_SelLesson = $this->conn->prepare($SelLesson);
                $Q_SelLesson->bindValue(1, $this->CourseID);
                $Q_SelLesson->execute();
                while ($RowSelLesson = $Q_SelLesson->fetch(PDO::FETCH_ASSOC)) {
                    $InsertLesson = "INSERT INTO tb_lesson_progress (EnrollmentID,LessonID) VALUE (?,?)";
                    $Q_InsertLesson = $this->conn->prepare($InsertLesson);
                    $Q_InsertLesson->bindValue(1, $EnrollmentID);
                    $Q_InsertLesson->bindValue(2, $RowSelLesson['LessonID']);
                    $Q_InsertLesson->execute();
                }
                
                return true;
            }


    
            return false;
        }

        public function CheckEnrollmentUser(){    

            $query = "SELECT * FROM " . $this->table_name . " WHERE CourseID = ? AND UserID = ?";
            $stmt = $this->conn->prepare($query);
             // ผูกค่าพารามิเตอร์
            $stmt->bindParam(1, $this->CourseID);
            $stmt->bindParam(2, $this->UserID);
            $stmt->execute();
            return $stmt->fetchColumn();
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
        $query = "SELECT tb_lessons.*,tb_courses.CourseName 
        FROM tb_lessons 
        JOIN tb_courses ON tb_courses.CourseID = tb_lessons.CourseID
        WHERE tb_lessons.CourseID = ? ORDER BY tb_lessons.LessonNo ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $CourseID);
        $stmt->execute();
        return $stmt;
    }

    
    public function EnrollmentProgressUpdateTimeSpent($LessProID, $CountTime, $CourseID) {
        // 1. Get current progress and LessonID
        $CheckTime = "SELECT LessProTimeSpent, LessonID FROM tb_lesson_progress WHERE LessProID = ?";
        $stmt = $this->conn->prepare($CheckTime);
        $stmt->bindValue(1, $LessProID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return 0;

        $CurrentTimeSpent = floatval($row['LessProTimeSpent']);
        $LessonID = $row['LessonID'];

        // 2. Get required Study Time for this Lesson directly by LessonID
        $CheckTimeLesson = "SELECT LessonStudyTime FROM tb_lessons WHERE LessonID = ?";
        $stmtTimeLesson = $this->conn->prepare($CheckTimeLesson);
        $stmtTimeLesson->bindValue(1, $LessonID);
        $stmtTimeLesson->execute();
        $rowTimeLesson = $stmtTimeLesson->fetch(PDO::FETCH_ASSOC);

        $LessonStudyTime = floatval($rowTimeLesson['LessonStudyTime']);
        $NewTimeSpent = $CurrentTimeSpent + floatval($CountTime);

        // 3. Logic to update time and status
        if ($NewTimeSpent >= $LessonStudyTime) {
            // Completed: Cap time at StudyTime and set status
            $UpdateSql = "UPDATE tb_lesson_progress SET LessProTimeSpent = ?, LessProStatus = ? WHERE LessProID = ?";
            $stmtUp = $this->conn->prepare($UpdateSql);
            $stmtUp->bindValue(1, $LessonStudyTime); // Cap at max
            $stmtUp->bindValue(2, "เรียนสำเร็จ");
            $stmtUp->bindValue(3, $LessProID);
            $stmtUp->execute();
            
            echo $LessonStudyTime; // Return max time
        } else {
            // Still in progress: Just update time
            $UpdateSql = "UPDATE tb_lesson_progress SET LessProTimeSpent = ? WHERE LessProID = ?";
            $stmtUp = $this->conn->prepare($UpdateSql);
            $stmtUp->bindValue(1, $NewTimeSpent);
            $stmtUp->bindValue(2, $LessProID);
            $stmtUp->execute();

            echo $NewTimeSpent; // Return incremented time
        }
    }

    public function CheckEnrollmentAll($CourseID){

        $CheckTime = "SELECT COUNT(*) AS SumAll FROM tb_enrollments WHERE CourseID = ?";
        $stmt = $this->conn->prepare($CheckTime);
        $stmt->bindValue(1, $CourseID);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function CheckEnrollmentSuccessful($CourseID){
        $Successful = "SELECT COUNT(*) AS SumAll FROM tb_enrollments WHERE EnrollCertificate != '' AND CourseID = $CourseID";
        $stmt = $this->conn->prepare($Successful);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } 
    
    
}
?>
