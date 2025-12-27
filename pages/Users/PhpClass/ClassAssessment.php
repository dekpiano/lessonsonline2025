<?php

class ClassAssessment {
    private $conn;
    private $table_name = "tb_lessons";

    public $TitleBar = "แบบประเมินความพึงพอใจของผู้เข้าเรียน";

    public function __construct($db) {
        $this->conn = $db;

        if(empty($_SESSION['UserID']) && @!$_SESSION['UserType'] == "student"){
            header("Location: ../../../");
            exit();
        }
    }


    // อ่านข้อมูลคำถามแบบประเมินทั้งหมด
    public function ReadQuestionAll() {
        $query = "SELECT * FROM tb_assessments_questions";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    //เอาไว้สร้าง Token
    function generateUUID() {
        // ใช้ฟังก์ชัน random_bytes เพื่อสร้าง UUID
        $data = random_bytes(16);
    
        // ตั้งค่า variant bits
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // version 4
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // variant
    
        // กลับมาเป็นรูปแบบ UUID
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function AssessmentInsert() {
     

        $query1 = "INSERT INTO tb_assessments_responses SET course_id=:course_id,question_id=:question_id,user_id=:user_id,response_text=:response_text,response_rating=:response_rating";
        $stmt = $this->conn->prepare($query1);       
        
        foreach ($_POST as $question_id => $answer_text) {
            if($question_id != "CourseID"){
                $stmt->bindValue(":course_id", $_POST['CourseID']); 
                $query = $this->conn->prepare("SELECT ass_question_type FROM tb_assessments_questions WHERE ass_question_id = :question_id");
                $query->bindParam(":question_id", $question_id);
                $query->execute();
                $question = $query->fetch();            
    
                if($question['ass_question_type'] == 'rating'){
                    $stmt->bindValue(":response_rating", $answer_text); 
                    $stmt->bindValue(":response_text", "");    
                }else{
                    $stmt->bindValue(":response_text", htmlspecialchars(strip_tags($answer_text))); 
                    $stmt->bindValue(":response_rating", "");    
                }            
                $stmt->bindValue(":question_id", $question_id);
                $stmt->bindValue(":user_id", $_SESSION['UserID']);               
                $stmt->execute();
            }
        }

        $UpdateKeyCertificate = "UPDATE tb_enrollments SET EnrollCertificate=:EnrollCertificate,EnrollCompletionDate=:EnrollCompletionDate,EnrollStatus=:EnrollStatus WHERE CourseID=:CourseID AND UserID=:UserID";
        $stmtUpdateKey = $this->conn->prepare($UpdateKeyCertificate); 
        $stmtUpdateKey->bindValue(":EnrollCertificate", $this->generateUUID());
        $stmtUpdateKey->bindValue(":EnrollCompletionDate", date('Y-m-d'));
        $stmtUpdateKey->bindValue(":CourseID", $_POST['CourseID']);
        $stmtUpdateKey->bindValue(":UserID", $_SESSION['UserID']);
        $stmtUpdateKey->bindValue(":EnrollStatus", "Success");
        $stmtUpdateKey->execute();

        // Return a JSON response
        echo json_encode(['status' => 'success', 'message' => 'Assessment submitted successfully']);
    }

    public function AssessmentUpdate() {
        $query1 = "UPDATE tb_assessments_responses SET response_text=:response_text,response_rating=:response_rating WHERE question_id=:question_id AND user_id=:user_id AND course_id=:course_id";
        $stmt = $this->conn->prepare($query1);       
        print_r($_POST);
        foreach ($_POST as $question_id => $answer_text) {
            if($question_id != "CourseID"){
                $query = $this->conn->prepare("SELECT ass_question_type FROM tb_assessments_questions WHERE ass_question_id = :question_id"); 
                $query->bindParam(":question_id", $question_id);
                $query->execute();
                $question = $query->fetch();            
                //print_r($_POST['CourseID']);
                if($question['ass_question_type'] == 'rating'){
                    $stmt->bindValue(":response_rating", $answer_text); 
                    $stmt->bindValue(":response_text", "");    
                }else{
                    $stmt->bindValue(":response_text", htmlspecialchars(strip_tags($answer_text))); 
                    $stmt->bindValue(":response_rating", "");    
                }            
                $stmt->bindValue(":question_id", $question_id);
                $stmt->bindValue(":user_id", $_SESSION['UserID']); 
                $stmt->bindValue(":course_id", $_POST['CourseID']);              
                $stmt->execute();
            }
           
        }

        $UpdateKeyCertificate = "UPDATE tb_enrollments SET EnrollCertificate=:EnrollCertificate,EnrollCompletionDate=:EnrollCompletionDate,EnrollStatus=:EnrollStatus WHERE CourseID=:CourseID AND UserID=:UserID";
        $stmtUpdateKey = $this->conn->prepare($UpdateKeyCertificate); 
        $stmtUpdateKey->bindValue(":EnrollCertificate", $this->generateUUID());
        $stmtUpdateKey->bindValue(":EnrollCompletionDate", date('Y-m-d'));
        $stmtUpdateKey->bindValue(":CourseID", $_POST['CourseID']);
        $stmtUpdateKey->bindValue(":UserID", $_SESSION['UserID']);
        $stmtUpdateKey->bindValue(":EnrollStatus", "Success");
        $stmtUpdateKey->execute();

        
        // Return a JSON response
        echo json_encode(['status' => 'success', 'message' => 'Assessment submitted successfully']);
    }

    public function EditAssessment($CourseID,$question_id) {
        $Query = "SELECT
            tb_assessments_responses.user_id,
            tb_assessments_responses.course_id,
            tb_assessments_responses.question_id,
            tb_assessments_responses.response_text,
            tb_assessments_responses.response_rating,
            tb_assessments_questions.ass_question_type
            FROM
            tb_assessments_responses
            INNER JOIN tb_assessments_questions ON tb_assessments_questions.ass_question_id = tb_assessments_responses.question_id
            INNER JOIN tb_assessments ON tb_assessments.assessment_id = tb_assessments_questions.assessment_id
            WHERE tb_assessments_responses.course_id = ? AND tb_assessments_responses.user_id = ? AND tb_assessments_responses.question_id = ? 
        ";
        $stmt = $this->conn->prepare($Query);
        $stmt->bindValue(1, $CourseID);
        $stmt->bindValue(2, $_SESSION['UserID']);
        $stmt->bindValue(3, $question_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function CheckAssessment($CourseID) {
        $Query = "SELECT
            tb_assessments.course_id,
            tb_assessments_responses.question_id
            FROM
            tb_assessments_responses
            INNER JOIN tb_assessments_questions ON tb_assessments_questions.ass_question_id = tb_assessments_responses.question_id
            INNER JOIN tb_assessments ON tb_assessments.assessment_id = tb_assessments_questions.assessment_id
        WHERE tb_assessments_responses.course_id = ? AND tb_assessments_responses.user_id = ?
    ";
        $stmt = $this->conn->prepare($Query);
        $stmt->bindValue(1, $CourseID);
        $stmt->bindValue(2, $_SESSION['UserID']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function LessonsAllWhereCourse($CourseID) {
        $QueryLessonsAll = "SELECT COUNT(*) AS LessonsAll FROM tb_lessons WHERE CourseID = ?";
        $stmtLessonsAll = $this->conn->prepare($QueryLessonsAll);
        $stmtLessonsAll->bindValue(1, $CourseID);
        $stmtLessonsAll->execute();
       return $stmtLessonsAll->fetch(PDO::FETCH_ASSOC);
    }

    public function LessonsCheckExamBefore($CourseID,$LessonNo) {

        $sql = "SELECT
        tb_questions.QuestionID,
        tb_questions.QuestionLessonID,
        tb_useranswers.UserAnswerCategory,
        tb_useranswers.UserID,
        tb_lessons.CourseID,
        tb_lessons.LessonNo
        FROM
        tb_questions
        INNER JOIN tb_useranswers ON tb_useranswers.QuestionID = tb_questions.QuestionID
        INNER JOIN tb_lessons ON tb_lessons.LessonID = tb_questions.QuestionLessonID
        WHERE tb_useranswers.UserID = ? AND tb_lessons.CourseID = ? AND tb_lessons.LessonNo = ? AND tb_useranswers.UserAnswerCategory = 'ก่อนเรียน'";
        $query = $this->conn->prepare($sql);
        $query->bindValue(1, $_SESSION['UserID']);
        $query->bindValue(2, $CourseID);
        $query->bindValue(3, $LessonNo);
        $query->execute();

        return $query->rowCount();

    }
    
}
?>
