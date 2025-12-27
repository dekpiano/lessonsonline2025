<?php
include_once '../../../../php/Database/Database.php';
include_once '../../PhpClass/ClassSystemSettings.php';

$database = new Database();
$db = $database->getConnection();
$Settings = new ClassSystemSettings($db);

if ($_POST) {
    $success = true;
    
    if(isset($_POST['max_total_courses'])){
        if(!$Settings->updateSetting('max_total_courses', $_POST['max_total_courses'])) $success = false;
    }
    
    if(isset($_POST['max_teachers'])){
         if(!$Settings->updateSetting('max_teachers', $_POST['max_teachers'])) $success = false;
    }

    echo $success ? "1" : "0";
}
?>
