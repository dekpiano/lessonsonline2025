<?php
include_once '../../../../php/Database/Database.php';
include_once '../../../../pages/Admin/PhpClass/ClassTeacher.php';

$database = new Database();
$db = $database->getConnection();
$Teacher = new ClassTeacher($db);

$Teacher->UserID = $_POST['UserID'];

if($Teacher->delete()){
    echo 1;
} else {
    echo 0;
}
?>
