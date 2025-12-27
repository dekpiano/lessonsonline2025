<?php 
include_once '../../../../php/Database/Database.php'; 
include_once '../../../../pages/Users/PhpClass/ClassUserPasswordReset.php';
$database = new Database();
$db = $database->getConnection();
$UserReset = new ClassUserPasswordReset($db);


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['token']) && isset($_POST['ConfrimPassword'])) {
    $message = $UserReset->resetPassword($_POST['token'], $_POST['ConfrimPassword']);
    echo $message;
}



?>