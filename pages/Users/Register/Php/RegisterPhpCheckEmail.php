<?php 
include_once '../../../../php/Database/Database.php'; 
include_once '../../../../pages/Users/PhpClass/ClassRegisterUser.php';
$database = new Database();
$db = $database->getConnection();
$User = new ClassRegisterUser($db);

echo $User->CheckEmail($_POST['Email']);
?>