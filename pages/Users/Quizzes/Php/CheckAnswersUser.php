<?php 
include_once '../../../../php/Database/Database.php'; 
include_once '../../../../pages/Users/PhpClass/ClassQuizzesUser.php';
$database = new Database();
$db = $database->getConnection();
$Quiz = new ClassQuizzesUser($db);

$Check = $Quiz->CheckAnswersUser($_POST);
print_r($Check); 

// foreach ($_POST as $key => $value) {
//     echo $value;
// }

exit();
?>