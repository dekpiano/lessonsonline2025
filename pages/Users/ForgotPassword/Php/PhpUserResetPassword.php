<?php 
include_once '../../../../php/Database/Database.php'; 
include_once '../../../../pages/Users/PhpClass/ClassUserPasswordReset.php';
$database = new Database();
$db = $database->getConnection();
$UserReset = new ClassUserPasswordReset($db);

$Email = $_POST['Email'];
$UserReset->requestPasswordReset($Email);


?>