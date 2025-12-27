<?php 
include_once '../../../../php/Database/Database.php'; 
include_once '../../../../pages/Users/PhpClass/ClassRegisterUser.php';
$database = new Database();
$db = $database->getConnection();
$User = new ClassRegisterUser($db);
$Title = $User->TitleBar;



$User->UserCode = $User->getNewUserCode();
$User->UserFirstName = $_POST['UserFirstName'];
$User->UserPrefix = $_POST['UserPrefix'];
$User->UserLastName = $_POST['UserLastName'];
$User->UserBirthday = $_POST['UserBirthday'];
$User->UserPhone = $_POST['UserPhone'];
$User->UserIdCard = $_POST['UserIdCard'];
$User->Username = $_POST['Email'];
$User->Password = password_hash($_POST['Password'], PASSWORD_DEFAULT);
$User->UserRangeAge = $_POST['UserRangeAge'];
$User->UserLevelEdu = $_POST['UserLevelEdu'];
$User->UserTypeService = $_POST['UserTypeService'];
$User->Email = $_POST['Email'];
$User->UserType = "student";
$User->DateCreated = date('Y-m-d H:i:s');

echo $User->create();
?>