<?php
class ClassTeacher {
    private $conn;
    private $table_name = "tb_users";

    public $TitleBar = "จัดการครูผู้สอน | บทเรียนออนไลน์ สกร.นครสวรรค์";
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
        // Check Limit
        include_once '../../../pages/Admin/PhpClass/ClassSystemSettings.php';
        $Settings = new ClassSystemSettings($this->conn);
        $MaxTeachers = (int)$Settings->getSetting('max_teachers', 10);

        // Count current teachers
        $queryCheck = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE UserType = 'teacher'";
        $stmtCheck = $this->conn->prepare($queryCheck);
        $stmtCheck->execute();
        $CurrentTeachers = $stmtCheck->fetchColumn();

        if ($CurrentTeachers >= $MaxTeachers) {
            return "LIMIT_EXCEEDED"; 
        }

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
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE UserID = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->UserID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->UserID = $row['UserID'];
        $this->UserCode = $row['UserCode'];
        $this->UserPrefix = $row['UserPrefix'];
        $this->UserFirstName = $row['UserFirstName'];
        $this->UserLastName = $row['UserLastName'];
        $this->UserBirthday = $row['UserBirthday'];
        $this->UserPhone = $row['UserPhone'];
        $this->Username = $row['Username'];
        $this->Email = $row['Email'];
    }

    public function update() {
        // If password is set, update it too, otherwise skip
        $password_set = !empty($this->Password);

        $query = "UPDATE " . $this->table_name . "
                  SET UserPrefix = :UserPrefix,
                      UserFirstName = :UserFirstName,
                      UserLastName = :UserLastName,
                      UserBirthday = :UserBirthday,
                      UserPhone = :UserPhone,
                      Email = :Email";
        
        if ($password_set) {
            $query .= ", Password = :Password";
        }

        $query .= " WHERE UserID = :UserID";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':UserPrefix', $this->UserPrefix);
        $stmt->bindParam(':UserFirstName', $this->UserFirstName);
        $stmt->bindParam(':UserLastName', $this->UserLastName);
        $stmt->bindParam(':UserBirthday', $this->UserBirthday);
        $stmt->bindParam(':UserPhone', $this->UserPhone);
        $stmt->bindParam(':Email', $this->Email);
        $stmt->bindParam(':UserID', $this->UserID);

        if ($password_set) {
            $stmt->bindParam(':Password', $this->Password);
        }

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE UserID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->UserID);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
