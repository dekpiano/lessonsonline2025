<?php
session_start();

if (empty($_SESSION['UserID']) || !isset($_SESSION['UserType']) || $_SESSION['UserType'] !== "teacher") {
    header("Location: ../../../../");
    exit();
}

include_once '../../../../php/Database/Database.php';
include_once '../PhpClass/ClassCourse.php';
// Include ClassUploader.php here just in case, although ClassCourse includes it too. 
// However, ClassCourse uses relative path ../../../ from its location.
// CoursePhpDelete is in pages/Teacher/Course/Php.
// ClassCourse is in pages/Teacher/PhpClass.
// Relative to CoursePhpDelete, ClassUploader is ../../../../php/Uploadfile/ClassUploader.php

$database = new Database();
$db = $database->getConnection();

$course = new ClassCourse($db);

if (isset($_POST['CourseID'])) {
    if ($course->DeleteCourse($_POST['CourseID'])) {
        echo $_POST['CourseID']; // Return ID on success to update UI
    } else {
        echo 0;
    }
} else {
    echo 0;
}
?>
