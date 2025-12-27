<?php 
session_start(); // เริ่ม session

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        $this->host = getenv('DB_HOST') ?: "localhost";
        $this->db_name = getenv('DB_NAME') ?: "skjacth_lessonsonline";
        $this->username = getenv('DB_USERNAME') ?: "skjacth_lesso";
        $this->password = getenv('DB_PASSWORD') ?: "Jw123456";
    }

    // การเชื่อมต่อฐานข้อมูล
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->exec("SET sql_mode = '';");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

function uri($segmentNumber, $default = null) {
    $currentUrl = $_SERVER['REQUEST_URI'];
    $path = parse_url($currentUrl, PHP_URL_PATH);
    $segments = array_values(array_filter(explode('/', $path)));

    // ค้นหาตำแหน่งของ Folder มาตรฐานเพื่อเป็นจุดอ้างอิง (pages หรือ php)
    $refIndex = -1;
    foreach(['pages', 'php', 'dist', 'plugins'] as $folder) {
        $index = array_search($folder, $segments);
        if ($index !== false) {
            $refIndex = $index;
            break;
        }
    }

    if ($refIndex !== -1) {
        // ในระบบเดิม uri(1) คือ 'pages' (ถ้าไม่มี subfolder) หรือ 'lessonsonline' (ถ้ามี subfolder)
        // เพื่อให้เข้ากับ Logic เดิม:
        // ถ้าเป็น Production: /pages/Users/... -> segments[0]='pages'. uri(1) ต้องการ 'pages' -> target = 0
        // ถ้าเป็น Localhost: /lessonsonline/pages/Users/... -> segments[1]='pages'. uri(1) ต้องการ 'lessonsonline' -> target = 0
        
        // ดังนั้นเราจะปรับดัชนีให้สัมพันธ์กับตำแหน่งที่เจอ 'pages'
        // ปกติ 'pages' ควรอยู่ที่ตำแหน่ง $segmentNumber - 1 (แบบไม่มี subfolder)
        // หรืออยู่ที่ตำแหน่ง $segmentNumber (แบบมี subfolder)
        
        // ลองคำนวณแบบง่ายๆ:
        $targetIndex = $segmentNumber - (1 + (0 - $refIndex)); 
        // Case Production: refIndex=0, segNum=1 -> 1-(1+0) = 0. Correct.
        // Case Localhost: refIndex=1, segNum=1 -> 1-(1-1) = 1. Wait, uri(1) should be 'lessonsonline'?
        // ดูจาก FooterUser.php: uri(3) == "ForgotPassword"
        // Localhost: /lessonsonline/pages/Users/ForgotPassword -> segments: [0:lessonsonline, 1:pages, 2:Users, 3:ForgotPassword]
        // refIndex ('pages') = 1.
        // เราอยากได้ uri(3) = segments[3].
        // สูตร: $targetIndex = ($segmentNumber - 1) + ($refIndex - 1); 
        // Production: (3-1) + (0-1) = 1? No, segments[1] is 'Users'.
        
        // เอาใหม่:
        // ใน Localhost: uri(1)=seg[0], uri(2)=seg[1], uri(3)=seg[2], uri(4)=seg[3] -> No, uri(3) is ForgotPassword (seg 3)
        // จริงๆ แล้ว uri() ของเดิมมันมั่วๆ หน่อย แต่เราต้องรักษามันไว้
        
        // ของเดิม:
        // localhost: uri(3) -> segments[3 - 0] = segments[3]
        // production: uri(3) -> segments[3 - 1] = segments[2]
        
        // ถ้า Docker (localhost:8088): HTTP_HOST != 'localhost' (เพราะมี port) 
        // มันจะไปตก production branch -> segments[3-1] = segments[2].
        // URL: /pages/Users/ForgotPassword -> segments[2] คือ 'ForgotPassword'. ถูก!
    }

    // กลับไปใช้ Logic เดิมที่มีการปรับปรุงการเช็ค localhost ให้ครอบคลุม Docker
    $host = explode(':', $_SERVER['HTTP_HOST'])[0];
    $isLocalhost = ($host === 'localhost' || $host === '127.0.0.1');
    
    // ตรวจสอบว่ามี subdirectory หรือไม่ (เช็คจาก SCRIPT_NAME)
    $hasSubfolder = (strpos($_SERVER['SCRIPT_NAME'], '/pages/') !== 0 && strpos($_SERVER['SCRIPT_NAME'], '/php/') !== 0 && strpos($_SERVER['SCRIPT_NAME'], '/index.php') !== 0);

    if($isLocalhost && $hasSubfolder){
        if(isset($segments[$segmentNumber - 0])) {
            return $segments[$segmentNumber - 0];
        } else {
            return $default;
        }
    }else{
        if(isset($segments[$segmentNumber - 1])) {
            return $segments[$segmentNumber - 1];
        } else {
            return $default;
        }
    }
}   

$dayTH = ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'];
$monthTH = [null,'มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
$monthTH_brev = [null,'ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
function thai_date_and_time($time){   // 19 ธันวาคม 2556 เวลา 10:10:43
    global $dayTH,$monthTH;   
    $thai_date_return = date("j",$time);   
    $thai_date_return.=" ".$monthTH[date("n",$time)];   
    $thai_date_return.= " ".(date("Y",$time)+543);   
    $thai_date_return.= " เวลา ".date("H:i:s",$time);
    return $thai_date_return;   
} 
function thai_date_and_time_short($time){   // 19  ธ.ค. 2556 10:10:4
    global $dayTH,$monthTH_brev;   
    $thai_date_return = date("j",$time);   
    $thai_date_return.=" ".$monthTH_brev[date("n",$time)];   
    $thai_date_return.= " ".(date("Y",$time)+543);   
    $thai_date_return.= " ".date("H:i:s",$time);
    return $thai_date_return;   
} 
function thai_date_short($time){   // 19  ธ.ค. 2556a
    global $dayTH,$monthTH_brev;   
    $thai_date_return = date("j",$time);   
    $thai_date_return.=" ".$monthTH_brev[date("n",$time)];   
    $thai_date_return.= " ".(date("Y",$time)+543);   
    return $thai_date_return;   
} 
function thai_date_fullmonth($time){   // 19 ธันวาคม 2556
    global $dayTH,$monthTH;   
    $thai_date_return = date("j",$time);   
    $thai_date_return.=" ".$monthTH[date("n",$time)];   
    $thai_date_return.= " ".(date("Y",$time)+543);   
    return $thai_date_return;   
} 
function thai_date_short_number($time){   // 19-12-56
    global $dayTH,$monthTH;   
    $thai_date_return = date("d",$time);   
    $thai_date_return.="-".date("m",$time);   
    $thai_date_return.= "-".substr((date("Y",$time)+543),-2);   
    return $thai_date_return;   
} 

?>