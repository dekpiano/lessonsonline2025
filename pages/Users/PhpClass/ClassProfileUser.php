<?php
class ClassProfileUser {
    private $conn;
    private $table_name = "tb_users";

    public $TitleBar = "โปรไฟล์";

    public function __construct($db) {
        $this->conn = $db;
    }


    public function SelectDataUser() {
        $query = "SELECT * FROM tb_users WHERE UserID = ".$_SESSION['UserID'];

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function UpdateProfileUser($Data,$UserID) {

        $Value = [];
        foreach ($Data as $key => $v_Data) {
            $Value[] =  $key.'=:'.$key;
        }
        $sub = implode(',',$Value);

        $query = "UPDATE " . $this->table_name . "
                  SET ".$sub."
                  WHERE UserID =:UserID";
        $stmt = $this->conn->prepare($query);
        foreach ($Data as $key => $v_data) {    
             $stmt->bindValue(":".$key, $v_data);
         }  
         $stmt->bindValue(":UserID", $UserID);
         $stmt->execute();
    
         if($stmt->execute()) {
            return true;
        }else{
            return false;
        }

    }

    public function UpdatePasswordUser($PasswordNew){
        $CheckPasswordNew =  password_hash($PasswordNew, PASSWORD_DEFAULT);
        $sql = "UPDATE tb_users SET password = :password WHERE UserID = :UserID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':password', $CheckPasswordNew, PDO::PARAM_STR);
        $stmt->bindValue(':UserID', $_SESSION['UserID']); // หรือ PDO::PARAM_STR หากคุณใช้ username
        $stmt->execute();

        if($stmt->execute()) {
            return true;
        }else{
            return false;
        }
    }

    public function CheckPasswordOld($PasswordOld){
    

        $Sql = "SELECT Password FROM tb_users WHERE UserID = :UserID";
        $stmt = $this->conn->prepare($Sql);
        $stmt->bindValue(':UserID', $_SESSION['UserID']);
        $stmt->execute();
        $userData = $stmt->fetch();
        if ($userData && password_verify($PasswordOld, $userData['Password'])) {
            echo "รหัสผ่านถูกต้อง";
        } else {
            echo "รหัสผ่านไม่ถูกต้อง";
        }
    }
    
}


?>
