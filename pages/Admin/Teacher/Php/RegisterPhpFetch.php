<?php
include_once '../../../../php/Database/Database.php';
include_once '../../../../pages/Admin/PhpClass/ClassTeacher.php';

$database = new Database();
$db = $database->getConnection();
$Teacher = new ClassTeacher($db);

$Teacher->UserID = $_POST['UserID'];
$Teacher->readOne();

$teacher_arr = array(
    "UserID" => $Teacher->UserID,
    "UserCode" => $Teacher->UserCode,
    "UserPrefix" => $Teacher->UserPrefix,
    "UserFirstName" => $Teacher->UserFirstName,
    "UserLastName" => $Teacher->UserLastName,
    "UserBirthday" => $Teacher->UserBirthday,
    "UserPhone" => $Teacher->UserPhone,
    "Email" => $Teacher->Email
);

print_r(json_encode($teacher_arr));
?>
