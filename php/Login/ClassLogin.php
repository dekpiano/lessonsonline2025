<?php
class ClassLogin {
    private $conn;
    private $table_name = "tb_users";

    public $username;
    public $password;

    public function __construct($db) {
        $this->conn = $db;       
    }

    public function LoginAdmin() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE Username = :Username";

        $stmt = $this->conn->prepare($query);

        //$this->username=htmlspecialchars(strip_tags($this->username));

        $stmt->bindParam(":Username", $this->username);

        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($this->password, $row['Password'])) {
                $_SESSION['UserID'] = $row['UserID'];
                $_SESSION['FullName'] = $row['UserPrefix'].$row['UserFirstName'].' '.$row['UserLastName'];
                $_SESSION['UserType'] = $row['UserType'];
                return $row['UserType'];
            }
        }
        return false;
    }

    public function Logout(){
        // ลบทุก session variables
        $_SESSION = array();

        // ถ้าต้องการทำลาย session อย่างสมบูรณ์, ลบ cookie ของ session ด้วย
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // สุดท้าย, ทำลาย session.
        session_destroy();

        // เปลี่ยนเส้นทางกลับไปยังหน้าเข้าสู่ระบบหรือหน้าแรก
        header("Location: ../");
        exit();
    }
}
?>