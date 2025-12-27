<?php 
include_once '../../../../php/Database/Database.php'; 
include_once '../../../../pages/Users/PhpClass/ClassEnrollmentUser.php';
$database = new Database();
$db = $database->getConnection();
$Enroll = new ClassEnrollmentUser($db);


echo $Enroll->EnrollmentProgressUpdateTimeSpent(@$_POST['LessProID'],@$_POST['CountTimeFull'],@$_POST['CourseID']);
?>