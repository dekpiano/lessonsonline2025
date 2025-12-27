<?php
// include database and object files
include_once '../../../../php/Database/Database.php'; 
include_once '../../../../pages/Teacher/PhpClass/ClassLesson.php';
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare object
$Lesson = new ClassLesson($db);

// set Lesson property values
$Lesson->CourseID = $_POST['CourseID']; 
$Lesson->LessonCode = $_POST['LessonCode'];
$Lesson->LessonNo = $_POST['LessonNo'];
$Lesson->LessonTitle = $_POST['LessonTitle'];
$Lesson->LessonContent = $_POST['LessonContent'];
$Lesson->LessonVideoURL = $_POST['LessonVideoURL'];
$Lesson->LessonStudyTime = $_POST['LessonStudyTime'];
$Lesson->LessonDateCreated = date("Y-m-d H:i:s");
$Lesson->TeacherID = $_SESSION['UserID'];

// create the Lesson
if($Lesson->create()) {
    echo json_encode(array('message' => 1 , 'CourseID'=>$Lesson->CourseID));
} else {
    echo 0;
}
?>