<?php 
include_once '../../../../php/Database/Database.php'; 
include_once '../../../../pages/Users/PhpClass/ClassEnrollmentUser.php';
$database = new Database();
$db = $database->getConnection();
$Enroll = new ClassEnrollmentUser($db);

$Enroll->CourseID = $_GET['Course'];
$Enroll->UserID = $_SESSION['UserID'];
$Enroll->EnrollDate = date("Y-m-d H:i:s");

if($Enroll->EnrollmentUserInsert()){
    header("Location: ../../Learn/?Course=".$Enroll->CourseID);
}
?>