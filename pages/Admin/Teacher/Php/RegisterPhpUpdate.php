<?php
include_once '../../../../php/Database/Database.php';
include_once '../../../../pages/Admin/PhpClass/ClassTeacher.php';

$database = new Database();
$db = $database->getConnection();
$Teacher = new ClassTeacher($db);

$Teacher->UserID = $_POST['UserID'];
$Teacher->UserPrefix = $_POST['UserPrefix'];
$Teacher->UserFirstName = $_POST['UserFirstName'];
$Teacher->UserLastName = $_POST['UserLastName'];
$Teacher->UserBirthday = $_POST['UserBirthday'];
$Teacher->UserPhone = $_POST['UserPhone'];
$Teacher->Email = $_POST['Email'];

if(!empty($_POST['Password'])){
    $Teacher->Password = password_hash($_POST['Password'], PASSWORD_DEFAULT);
}

if($Teacher->update()){
    echo 1;
} else {
    echo 0;
}
?>
