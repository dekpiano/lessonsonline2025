<?php
class ClassTeacher {
    private $conn;
    private $table_name = "tb_users";

    public $TitleBar = "จัดการครูผู้สอน";
    public $CourseID;
    public $CourseName;
    public $Description;
    public $TeacherID;
    public $CourseDateCreated;

    public function __construct($db) {
        $this->conn = $db;
        if(empty($_SESSION['UserID']) && !$_SESSION['UserType'] == "admin"){
            header("Location: ../../../");
            exit();
        }
    }

    public function getNewTeacherCode() {
        $query = "SELECT UserCode FROM " . $this->table_name . " ORDER BY UserCode DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $lastCode = $stmt->fetchColumn();
        
        if ($lastCode) {
            $number = str_replace("User_", "", $lastCode); // ลบส่วนของข้อความ "Con_" ออก
            $newNumber = str_pad((int)$number + 1, 4, "0", STR_PAD_LEFT); // แปลงเป็นตัวเลข, เพิ่มค่าขึ้น 1, แล้วเติม 0 ให้ครบ 3 หลัก
            $newCode = "User_" . $newNumber;
        } else {
            // หากไม่มีรหัสใดๆ ในฐานข้อมูล
            $newCode = "User_0001";
        }
        
        return $newCode;
    }


    // อ่านข้อมูลคอร์สเรียนทั้งหมด
    public function read() {
        $query = "SELECT * FROM " . $this->table_name ." WHERE UserType='teacher'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

     // เพิ่มสมัครเรียนใหม่
     public function create() {

        $data = array('UserCode','UserPrefix','UserFirstName','UserLastName','UserBirthday','UserPhone','Username','Password','Email','UserType','DateCreated');
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
}
?>
