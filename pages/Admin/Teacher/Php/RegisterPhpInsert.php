<?php 
include_once '../../../../php/Database/Database.php'; 
include_once '../../../../pages/Admin/PhpClass/ClassTeacher.php';
$database = new Database();
$db = $database->getConnection();
$Teacher = new ClassTeacher($db);
$Title = $Teacher->TitleBar;



$Teacher->UserCode = $Teacher->getNewTeacherCode();
$Teacher->UserFirstName = $_POST['UserFirstName'];
$Teacher->UserPrefix = $_POST['UserPrefix'];
$Teacher->UserLastName = $_POST['UserLastName'];
$Teacher->UserBirthday = $_POST['UserBirthday'];
$Teacher->UserPhone = $_POST['UserPhone'];
$Teacher->Username = $_POST['Email'];
$Teacher->Password = password_hash($_POST['Password'], PASSWORD_DEFAULT);
$Teacher->Email = $_POST['Email'];
$Teacher->UserType = "teacher";
$Teacher->DateCreated = date('Y-m-d H:i:s');

$result = $Teacher->create();

if($result === "LIMIT_EXCEEDED") {
    echo "limit";
} else if($result) {
    echo 1;
} else {
    echo 0;
}
?>