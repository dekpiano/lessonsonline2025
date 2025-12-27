<?php 
include_once '../../../../php/Database/Database.php'; 
include_once '../../../../pages/Users/PhpClass/ClassUserPasswordReset.php';
$database = new Database();
$db = $database->getConnection();
$UserReset = new ClassUserPasswordReset($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['token']) && (isset($_POST['ConfrimPassword']) || isset($_POST['PasswordMain']))) {
    $password = isset($_POST['ConfrimPassword']) ? $_POST['ConfrimPassword'] : $_POST['PasswordMain'];
    $message = $UserReset->resetPassword($_POST['token'], $password);
    
    if ($message === "Invalid token.") {
        header("location:../index.php?Alert=invalid_token");
        exit;
    }
    // If successful, resetPassword will redirect to ConfrimPassword.php
} else {
    header("location:../index.php");
    exit;
}
?>