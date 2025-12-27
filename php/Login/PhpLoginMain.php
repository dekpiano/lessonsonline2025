<?php
include_once '../../php/Database/Database.php'; 
include_once '../../php/Login/ClassLogin.php'; 


$database = new Database();
$db = $database->getConnection();

$Login = new ClassLogin($db);

$Login->username = $_POST['username'];
$Login->password = $_POST['password'];

$response = array();

if($Login->LoginAdmin()) {
    echo json_encode(['Type'=>$Login->LoginAdmin(),'FullName'=>$_SESSION['FullName']]);
} else {
    echo 0;
}

?>