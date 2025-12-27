<?php
// include database and object files
include_once '../../../../php/Database/Database.php'; 
include_once '../../../../pages/Teacher/PhpClass/ClassQuizzes.php';
include_once '../../../../php/Uploadfile/ClassUploader.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$Quiz = new ClassQuizzes($db);

$QuizDelete = $Quiz->DeleteQuizzes($_POST['delete_id']);

print_r($QuizDelete);

?>