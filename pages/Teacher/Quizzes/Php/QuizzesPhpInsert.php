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

if($_FILES["QuestionImg"]["error"] == 0){ 
    $imageUploader = new ClassUploader($_FILES["QuestionImg"]["name"],$_FILES["QuestionImg"]["tmp_name"], 500,"Question"); // Resize to 500x500
    $array = json_decode($imageUploader->upload());
    $Question_Img =  $array->Text;
    
}else{
    $Question_Img = "";
}
$QuizInsert = $Quiz->QuizzesPhpInsert($Question_Img);


echo $QuizInsert;

?>