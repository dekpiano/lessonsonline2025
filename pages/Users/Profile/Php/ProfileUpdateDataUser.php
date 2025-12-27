<?php 
include_once '../../../../php/Database/Database.php'; 
include_once '../../../../pages/Users/PhpClass/ClassProfileUser.php';
$database = new Database();
$db = $database->getConnection();
$Profile = new ClassProfileUser($db);

print_r($Profile->UpdateProfileUser($_POST,$_SESSION['UserID']));
?>