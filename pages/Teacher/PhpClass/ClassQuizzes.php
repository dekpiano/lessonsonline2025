<?php
date_default_timezone_set('Asia/Bangkok'); // ตั้งค่า Time Zone ตามที่ต้องการ
// include_once '../../../php/Uploadfile/ClassUploader.php';

class ClassQuizzes {
    private $conn;
    private $table_name = "tb_questions";

    public function __construct($db) {
        $this->conn = $db;
       
        if(empty($_SESSION['UserID']) && !$_SESSION['UserType'] == "teacher"){
            header("Location: ../../../");
            exit();
        }
    }

    public function CheckNameLesson($LessonID) {
        $query = "SELECT LessonTitle FROM tb_lessons WHERE LessonID = ?";

        $stmt = $this->conn->prepare($query);

        // ผูกค่าพารามิเตอร์
        $stmt->bindValue(1, $LessonID);

        $stmt->execute();
        return $stmt;
    }


    // อ่านข้อมูลบทเรียนทั้งหมด
    public function readAll($LessonID) {
        $query = "SELECT * FROM tb_questions WHERE QuestionLessonID = ?";

        $stmt = $this->conn->prepare($query);

        // ผูกค่าพารามิเตอร์
        $stmt->bindValue(1, $LessonID);

        $stmt->execute();
        return $stmt;
    }

    public function CorrectAnswer($QuestionID){

        $query = "SELECT OptChoice FROM tb_options WHERE OptQuestionID = ? AND OptAnswer = 1";

        $stmt = $this->conn->prepare($query);

        // ผูกค่าพารามิเตอร์
        $stmt->bindValue(1, $QuestionID);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);

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
    }

    // เพิ่มบทเรียนใหม่
    public function QuizzesPhpInsert($Question_Img) {

        try {
        $OptChoice = $_POST['OptChoice'] ?? []; // รับค่า options จากฟอร์ม
        $OptAnswer = $_POST['OptAnswer'] ?? []; // รับค่า correct_options จากฟอร์ม
   
        $query = "INSERT INTO tb_questions (QuestionLessonID,QuestionText,QuestionImg) VALUES (?,?,?)";

        $stmt = $this->conn->prepare($query);       
        $stmt->bindValue(1, $_POST['LessonID']);
        $stmt->bindValue(2, $_POST['QuestionText']);
        $stmt->bindValue(3, $Question_Img);
        $stmt->execute();

        $question_id = $this->conn->lastInsertId();
       
        foreach ($OptChoice  as $key => $v_OptChoice) {
            $imageUploader = new ClassUploader($_FILES["OptImg"]["name"][$key],$_FILES["OptImg"]["tmp_name"][$key], 500,"Options"); // Resize to 500x500
            $array = json_decode($imageUploader->upload());

            $Choice = "INSERT INTO tb_options (OptQuestionID,OptChoice,OptAnswer,OptImg) VALUES (?,?,?,?)";
            $stmtChoice = $this->conn->prepare($Choice);       
            $stmtChoice->bindValue(1,$question_id);
            $stmtChoice->bindValue(2, $v_OptChoice);
            $stmtChoice->bindValue(3, $OptAnswer[$key]);
            $stmtChoice->bindValue(4, $array->Text);
            $stmtChoice->execute();
        }
        echo 1;
       
    } catch (PDOException $e) {
        die("เกิดข้อผิดพลาดในการเชื่อมต่อ: " . $e->getMessage());
    }

    
       // print_r($_POST); 
        exit();
    }

    public function QuizzesPhpUpdate($UpdateQuestion_Img = null) {

        
        if($_FILES["UpdateQuestionImg"]["error"] == 0){ 
            // ลบรูปเก่าก่อน 
            $delQuiz = "SELECT QuestionImg FROM tb_questions WHERE QuestionID = ?";
            $stmtDelQuiz = $this->conn->prepare($delQuiz);
            $stmtDelQuiz->bindValue(1, $_POST['UpdateQuestionID']);
            $stmtDelQuiz->execute();
            $imageUploader = new ClassUploader(0,0, 500,"Question"); // Resize to 500x500
            $array = ($imageUploader->deleteImage("../../../../uploads/Question/".$stmtDelQuiz->fetch(PDO::FETCH_ASSOC)['QuestionImg']));
            
            // อัพเดตรูปใหม่
            $imageUploader = new ClassUploader($_FILES["UpdateQuestionImg"]["name"],$_FILES["UpdateQuestionImg"]["tmp_name"], 500,"Question"); 
            $array = json_decode($imageUploader->upload());
            $UpdateQuestion_Img =  $array->Text;   
            $queryQuestions = "UPDATE tb_questions SET QuestionText = ?,QuestionImg = ? WHERE QuestionID = ?";
            $stmtQuestions = $this->conn->prepare($queryQuestions);
            $stmtQuestions->bindValue(1,$_POST['UpdateQuestionText']);
            $stmtQuestions->bindValue(3,$_POST['UpdateQuestionID']);
            $stmtQuestions->bindValue(2, $UpdateQuestion_Img);
            $stmtQuestions->execute();
            
        }else{
            $queryQuestions = "UPDATE tb_questions SET QuestionText = ? WHERE QuestionID = ?";
            $stmtQuestions = $this->conn->prepare($queryQuestions);
            $stmtQuestions->bindValue(1,$_POST['UpdateQuestionText']);
            $stmtQuestions->bindValue(2,$_POST['UpdateQuestionID']);
            $stmtQuestions->execute();
        }           
              
         // อัพเดตตัวเลือก

         
        // print_r($_POST);
        // print_r($_FILES);
        // exit();

        $SelIDOption = "SELECT OptID FROM tb_options WHERE OptQuestionID = ?";
        $stmtIDOption = $this->conn->prepare($SelIDOption);
        $stmtIDOption->bindValue(1,$_POST['UpdateQuestionID']);
        $stmtIDOption->execute();
        $i = 0;
        while ($rowIDOption = $stmtIDOption->fetch(PDO::FETCH_ASSOC)) { 
            
            if($_FILES["OptImg"]["error"][$i] == 0){
                $delQuiz = "SELECT OptImg FROM tb_options WHERE OptID = ?";
                $stmtDelQuiz = $this->conn->prepare($delQuiz);
                $stmtDelQuiz->bindValue(1, $rowIDOption['OptID']);
                $stmtDelQuiz->execute();
                $imageUploader = new ClassUploader(0,0, 500,"Question"); // Resize to 500x500
                $array = ($imageUploader->deleteImage("../../../../uploads/Options/".$stmtDelQuiz->fetch(PDO::FETCH_ASSOC)['OptImg']));

                $imageUploader = new ClassUploader($_FILES["OptImg"]["name"][$i],$_FILES["OptImg"]["tmp_name"][$i], 500,"Options"); 
                $array = json_decode($imageUploader->upload());
                $UpdateOptions_Img =  $array->Text;   

                $query = "UPDATE tb_options SET OptChoice = ?, OptAnswer = ?, OptImg = ? WHERE OptID = ?";
                $stmtUpdateData = $this->conn->prepare($query);
                $stmtUpdateData->bindValue(1,$_POST['UpdateOptChoice'][$i]);
                $stmtUpdateData->bindValue(2,$_POST['UpdateOptAnswer'][$i]);
                $stmtUpdateData->bindValue(3,$UpdateOptions_Img);
                $stmtUpdateData->bindValue(4,$rowIDOption['OptID']);
                $stmtUpdateData->execute();
            }else{
                $query = "UPDATE tb_options SET OptChoice = ?, OptAnswer = ? WHERE OptID = ?";
                $stmtUpdateData = $this->conn->prepare($query);
                $stmtUpdateData->bindValue(1,$_POST['UpdateOptChoice'][$i]);
                $stmtUpdateData->bindValue(2,$_POST['UpdateOptAnswer'][$i]);
                $stmtUpdateData->bindValue(3,$rowIDOption['OptID']);
                $stmtUpdateData->execute();
            }           
            $i++;
        }

       
        
        if(!empty($_POST['OptChoice'])){
            foreach ($_POST['OptChoice']  as $key => $v_OptChoice) {
                $Choice = "INSERT INTO tb_options (OptQuestionID,OptChoice,OptAnswer) VALUES (?,?,?)";    
                $stmtChoice = $this->conn->prepare($Choice);       
                $stmtChoice->bindValue(1,$_POST['UpdateQuestionID']);
                $stmtChoice->bindValue(2, $v_OptChoice);
                $stmtChoice->bindValue(3, $_POST['OptAnswer'][$key]);
                $stmtChoice->execute();
            }
        }
        return 1;
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

    public function EditQuizzes($IDQuestion){
        $sqlquestions = "SELECT
        tb_options.OptChoice,
        tb_options.OptAnswer,
        tb_questions.QuestionText,
        tb_questions.QuestionID,
        tb_options.OptID,
        tb_options.OptImg,
        tb_questions.QuestionImg
        FROM
        tb_questions
        INNER JOIN tb_options ON tb_questions.QuestionID = tb_options.OptQuestionID
         WHERE QuestionID = :QuestionID";
        $stmtquestions = $this->conn->prepare($sqlquestions);
        $stmtquestions->bindValue(':QuestionID', $IDQuestion);
        $stmtquestions->execute();
        $result =array();
        while ($row = $stmtquestions->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }

        echo json_encode($result);
    }

    public function DeleteQuizzes($delete_id){

        $delQuiz = "SELECT QuestionImg FROM tb_questions WHERE QuestionID = ?";
        $stmtDelQuiz = $this->conn->prepare($delQuiz);
        $stmtDelQuiz->bindValue(1, $delete_id);
        $stmtDelQuiz->execute();
        $imageUploader = new ClassUploader(0,0, 500,"Question"); // Resize to 500x500
        $array = ($imageUploader->deleteImage("../../../../uploads/Question/".$stmtDelQuiz->fetch(PDO::FETCH_ASSOC)['QuestionImg']));

        $sql = "DELETE FROM tb_useranswers WHERE QuestionID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $delete_id);
        $stmt->execute();

        $sql = "DELETE FROM tb_questions WHERE QuestionID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $delete_id);
        $stmt->execute();
        
        // ตรวจสอบว่าลบข้อมูลสำเร็จหรือไม่
        if ($stmt->rowCount() > 0) {

            $delOptions = "SELECT OptImg FROM tb_options WHERE OptQuestionID = ?";
            $stmtDelOptions = $this->conn->prepare($delOptions);
            $stmtDelOptions->bindValue(1, $delete_id);
            $stmtDelOptions->execute();
            $imageUploader = new ClassUploader(0,0,0,"Options"); // Resize to 500x500

            while ($row = $stmtDelOptions->fetch(PDO::FETCH_ASSOC)) {
                $array = ($imageUploader->deleteImage("../../../../uploads/Options/".$row['OptImg']));
            }

            $sqlOpt = "DELETE FROM tb_options WHERE OptQuestionID = ?";
            $stmtOpt = $this->conn->prepare($sqlOpt);
            $stmtOpt->bindValue(1, $delete_id);
            $stmtOpt->execute();
            return $delete_id;
        } else {
            return 0;
        }
    }

}


?>