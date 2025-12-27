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
        try {
            // 1. Update Question Data
            if ($_FILES["UpdateQuestionImg"]["error"] == 0) { 
                // Get old image to delete
                $stmt = $this->conn->prepare("SELECT QuestionImg FROM tb_questions WHERE QuestionID = ?");
                $stmt->execute([$_POST['UpdateQuestionID']]);
                $oldImg = $stmt->fetchColumn();
                if ($oldImg) {
                    $uploader = new ClassUploader("", "", 0, "Question");
                    $uploader->deleteImage("../../../../uploads/Question/" . $oldImg);
                }
                
                // Upload new image
                $uploader = new ClassUploader($_FILES["UpdateQuestionImg"]["name"], $_FILES["UpdateQuestionImg"]["tmp_name"], 800, "Question");
                $uploadResult = json_decode($uploader->upload());
                $UpdateQuestion_Img = $uploadResult->Text;
                
                $stmt = $this->conn->prepare("UPDATE tb_questions SET QuestionText = ?, QuestionImg = ? WHERE QuestionID = ?");
                $stmt->execute([$_POST['UpdateQuestionText'], $UpdateQuestion_Img, $_POST['UpdateQuestionID']]);
            } else {
                // Check if user requested to DELETE the image without uploading new one
                if (isset($_POST['UpdateQuestionImgDelete']) && $_POST['UpdateQuestionImgDelete'] == '1') {
                    $stmt = $this->conn->prepare("SELECT QuestionImg FROM tb_questions WHERE QuestionID = ?");
                    $stmt->execute([$_POST['UpdateQuestionID']]);
                    $oldImg = $stmt->fetchColumn();
                    if ($oldImg) {
                        $uploader = new ClassUploader("", "", 0, "Question");
                        $uploader->deleteImage("../../../../uploads/Question/" . $oldImg);
                    }
                    $stmt = $this->conn->prepare("UPDATE tb_questions SET QuestionText = ?, QuestionImg = '' WHERE QuestionID = ?");
                    $stmt->execute([$_POST['UpdateQuestionText'], $_POST['UpdateQuestionID']]);
                } else {
                    $stmt = $this->conn->prepare("UPDATE tb_questions SET QuestionText = ? WHERE QuestionID = ?");
                    $stmt->execute([$_POST['UpdateQuestionText'], $_POST['UpdateQuestionID']]);
                }
            }

            // 2. Handle Options
            $UpdateOptChoice = $_POST['UpdateOptChoice'] ?? [];
            $UpdateOptAnswer = $_POST['UpdateOptAnswer'] ?? [];
            $OptID = $_POST['OptID'] ?? []; // Existing IDs
            $UpdateOptImgDelete = $_POST['UpdateOptImgDelete'] ?? []; // Deletion flags
            
            // Note: OptID only has entries for existing options. 
            // UpdateOptChoice has entries for BOTH existing and new options.
            
            foreach ($UpdateOptChoice as $index => $choiceText) {
                $answer = $UpdateOptAnswer[$index] ?? 0;
                $currentOptID = $OptID[$index] ?? null;
                $hasNewImg = isset($_FILES["OptImg"]["error"][$index]) && $_FILES["OptImg"]["error"][$index] == 0;
                $shouldDeleteImg = isset($UpdateOptImgDelete[$index]) && $UpdateOptImgDelete[$index] == '1';
                
                $newImgName = null;
                if ($hasNewImg) {
                    $uploader = new ClassUploader($_FILES["OptImg"]["name"][$index], $_FILES["OptImg"]["tmp_name"][$index], 500, "Options");
                    $uploadResult = json_decode($uploader->upload());
                    $newImgName = $uploadResult->Text;
                }

                if ($currentOptID) {
                    // Update existing option
                    if ($hasNewImg) {
                        // Delete old option image
                        $stmt = $this->conn->prepare("SELECT OptImg FROM tb_options WHERE OptID = ?");
                        $stmt->execute([$currentOptID]);
                        $oldOptImg = $stmt->fetchColumn();
                        if ($oldOptImg) {
                            $uploader = new ClassUploader("", "", 0, "Options");
                            $uploader->deleteImage("../../../../uploads/Options/" . $oldOptImg);
                        }
                        
                        $stmt = $this->conn->prepare("UPDATE tb_options SET OptChoice = ?, OptAnswer = ?, OptImg = ? WHERE OptID = ?");
                        $stmt->execute([$choiceText, $answer, $newImgName, $currentOptID]);
                    } elseif ($shouldDeleteImg) {
                        // User clicked X to remove image
                        $stmt = $this->conn->prepare("SELECT OptImg FROM tb_options WHERE OptID = ?");
                        $stmt->execute([$currentOptID]);
                        $oldOptImg = $stmt->fetchColumn();
                        if ($oldOptImg) {
                            $uploader = new ClassUploader("", "", 0, "Options");
                            $uploader->deleteImage("../../../../uploads/Options/" . $oldOptImg);
                        }
                        $stmt = $this->conn->prepare("UPDATE tb_options SET OptChoice = ?, OptAnswer = ?, OptImg = '' WHERE OptID = ?");
                        $stmt->execute([$choiceText, $answer, $currentOptID]);
                    } else {
                        $stmt = $this->conn->prepare("UPDATE tb_options SET OptChoice = ?, OptAnswer = ? WHERE OptID = ?");
                        $stmt->execute([$choiceText, $answer, $currentOptID]);
                    }
                } else {
                    // Insert new option added during edit
                    $stmt = $this->conn->prepare("INSERT INTO tb_options (OptQuestionID, OptChoice, OptAnswer, OptImg) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$_POST['UpdateQuestionID'], $choiceText, $answer, $newImgName]);
                }
            }

            // 3. Delete options that were removed in UI
            $stmt = $this->conn->prepare("SELECT OptID, OptImg FROM tb_options WHERE OptQuestionID = ?");
            $stmt->execute([$_POST['UpdateQuestionID']]);
            $existingOptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($existingOptions as $opt) {
                if (!in_array($opt['OptID'], $OptID)) {
                    // This option was removed by user
                    if ($opt['OptImg']) {
                        $uploader = new ClassUploader("", "", 0, "Options");
                        $uploader->deleteImage("../../../../uploads/Options/" . $opt['OptImg']);
                    }
                    $stmt = $this->conn->prepare("DELETE FROM tb_options WHERE OptID = ?");
                    $stmt->execute([$opt['OptID']]);
                }
            }

            return 1;
        } catch (Exception $e) {
            return json_encode(['Msg' => 0, 'Text' => $e->getMessage()]);
        }
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