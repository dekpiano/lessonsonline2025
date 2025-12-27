<?php
// include database and object files
header('Content-Type: application/json');
include_once '../../../../php/Database/Database.php'; 
include_once '../../../../pages/Teacher/PhpClass/ClassQuizzes.php';
include_once '../../../../php/Uploadfile/ClassUploader.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$Quiz = new ClassQuizzes($db);

$QuizEdit = $Quiz->EditQuizzes($_POST['IDQuestion']);
// print_r($QuizEdit);

print_r($QuizEdit);

?>