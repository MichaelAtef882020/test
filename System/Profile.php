
<?php
session_start();
include_once "../Classes/UserClass.php";
include_once "../Classes/OutPutClass.php";
include_once "../Classes/TypeClass.php";
include_once "../Classes/FileMangerClass.php";
$Id = $_SESSION["UserId"];
$UserFile = new FileManger("User.txt");
$Line = $UserFile->ValueIsThere($Id, 0);
$User = User::FromStringToObject($Line);
$UserTypeFile = new FileManger("User Type.txt");
$Line = $UserTypeFile->ValueIsThere($User->getType(), 0);
$Array = explode('~', $Line);
$Type = $Array[1];
HTML::Header($User->getType());
$Inputs = [];
array_push($Inputs,new Input("Name","Name","text","'".$User->getName()."'"));
array_push($Inputs,new Input("Password","Password","password"));
array_push($Inputs,new Input("NewPassword","New Password","password"));
array_push($Inputs,new Input("ConfirmPassword","Confirm Password","password"));
array_push($Inputs,new Input("Date","Date of Birth","date",$User->getDateOfBirth()));
array_push($Inputs,new Input("UpdateName","Update Name","submit"));
array_push($Inputs,new Input("UpdatePassword","Update Password","submit"));
array_push($Inputs,new Input("UpdateDateOfBirth","Update Date Of Birth","submit"));
$Form = new Form();
$Form->setActionFile("#");
$Form->setInputs($Inputs);
$Form->setTitle("Profile Id: ".$User->getId()."<br> The ".Type::GetTypeName($User->getType())." ".$User->getName() );
$Form->DisplayForm();
HTML::Footer();
include_once "../Classes/UserClass.php";
if (isset($_POST["UpdateName"])) {
    if ($_POST["Password"] == "") die("You Must write your Password");
    if ($_POST["Name"] == "") die("You Must write new name");
    $Password = $_POST["Password"];
    if (sha1($Password) != $User->getPassword()) die("wrong Password");
    $UpdatedUser = new User();
    $UpdatedUser->setId($User->getId());
    $UpdatedUser->setName($_POST["Name"]);
    $UpdatedUser->Update();
    echo(" <script> location.replace('Profile.php'); </script>");
}
if (isset($_POST["UpdateDateOfBirth"])) {
    if(!isset($_POST["Date"])) die("Date is unset!!");
    $Date = $_POST["Date"];
    $UpdatedUser = new User();
    $UpdatedUser->setId($User->getId());
    $UpdatedUser->setDateOfBirth($Date);
    $UpdatedUser->Update();
    echo(" <script> location.replace('Profile.php'); </script>");
}
if (isset($_POST["UpdatePassword"])) {
    if ($_POST["Password"] == "") die("You Must write your Password");
    $Password = $_POST["Password"];
    if (sha1($Password) != $User->getPassword()) die("wrong Password");
    if ($_POST["NewPassword"] == "") die("You Must wite the new Password");
    if ($_POST["ConfirmPassword"] != $_POST["NewPassword"]) die("Must be the same Password!!");
    $UpdatedUser = new User();
    $UpdatedUser->setId($User->getId());
    $UpdatedUser->setPassword($_POST["NewPassword"]);
    $UpdatedUser->Update();
    echo(" <script> location.replace('Profile.php'); </script>");
}

