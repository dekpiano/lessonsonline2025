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


//print_r($_FILES);
//print_r(count($_FILES["OptImg"]["error"]));
//    for ($i=0; $i < count($_FILES["OptImg"]["error"]); $i++) { 
//         //print_r($_FILES["OptImg"]["error"][$i]);
//         if($_FILES["OptImg"]["error"][$i] == 0){
//             echo "มีรูป";
//         }else{
//             echo "ไม่มีรูป";

//             echo $_POST['OptID'][$i];
//         }
//    }


$QuizUpdate = $Quiz->QuizzesPhpUpdate();




echo $QuizUpdate;

?>