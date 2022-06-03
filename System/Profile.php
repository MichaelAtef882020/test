
<?php
session_start();
include_once "Classes.php";
$Id = $_SESSION["UserId"];
$UserFile = new FileManger("User.txt");
$Line = $UserFile->ValueIsThere($Id, 0);
$User = User::FromStringToObject($Line);
$UserTypeFile = new FileManger("User Type.txt");
$Line = $UserTypeFile->ValueIsThere($User->getType(), 0);
$Array = explode('~', $Line);
$Type = $Array[1];
HTML::Header($User->getType());
$Form = new Form();
$Form->setActionFile("#");
$Form->setTitle("Profile Id: " . $User->getId() . "<br> The " . Type::GetTypeName($User->getType()) . " " . $User->getName());
$Form->Attach(new Text("Name","Name","text","'".$User->getName()."'"));
$Form->Attach(new Text("Password","Password","password"));
$Form->Attach(new Text("NewPassword","New Password","password"));
$Form->Attach(new Text("ConfirmPassword","Confirm Password","password"));
$Form->Attach(new Text("Date","Date of Birth","date",$User->getDateOfBirth()));
$Form->Attach(new Submit("UpdateName","Update Name","submit"));
$Form->Attach(new Submit("UpdatePassword","Update Password","submit"));
$Form->Attach(new Submit("UpdateDateOfBirth","Update Date Of Birth","submit"));
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

