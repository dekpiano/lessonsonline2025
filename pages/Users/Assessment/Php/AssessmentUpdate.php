<?php 
include_once '../../../../php/Database/Database.php'; 
include_once '../../../../pages/Users/PhpClass/ClassAssessment.php';
$database = new Database();
$db = $database->getConnection();
$Assessment = new ClassAssessment($db);

$Ass = $Assessment->AssessmentUpdate();

echo $Ass;
?>