<?php
session_start();
include_once "../Classes/UserClass.php";
include_once "../Classes/OutPutClass.php";
include_once "../Classes/FileMangerClass.php";
$Id = $_SESSION["UserId"];
$UserFile = new FileManger("User.txt");
$Line = $UserFile->ValueIsThere($Id, 0);
$User = User::FromStringToObject($Line);
$Servis = $User->GetServices();

HTML::Header($User->getType());
$Inputs = [];
array_push($Inputs,new Input("UserId","User Id","number"));
array_push($Inputs,new Input("UserName","User Name","text"));
array_push($Inputs,new Input("DateOfBirth","Date of Birth","date"));
$Input = new Input();
$Texts = ["Non"];
$Values = ["0"];
$UserTypeFile = new FileManger("User Type.txt");
$List = $UserTypeFile->GetAllContent();
for ($i = 0; $i < count($List); $i++) {
    $Array = explode('~', $List[$i]);
    $Type = $Array[1];
    $TypeId = $Array[0];
    array_push($Texts,$Type);
    array_push($Values,$TypeId);
}
$Input->setText($Texts);
$Input->setName("UserType");
$Input->setValue($Values);
$Input->setType("select");
array_push($Inputs,$Input);
if (in_array("User-All", $Servis))
{
    array_push($Inputs,new Input("AddUser","Add User","submit"));
    array_push($Inputs,new Input("UpdateUserType","Update User Type","submit"));
    array_push($Inputs,new Input("SearshForUser","Searsh For User","submit"));
    array_push($Inputs,new Input("DeleteUser","Delete User","submit"));
}
else if(in_array("User-Search", $Servis))
{
    array_push($Inputs,new Input("SearshForUser","Searsh For User","submit"));
}
$Form = new Form();
$Form->setActionFile("#");
$Form->setInputs($Inputs);
$Form->setTitle("Users");
$Form->DisplayForm();
HTML::Footer();
include_once "../Classes/UserClass.php";
if (isset($_POST["AddUser"])) {
    echo(" <script> location.replace('SignUp.php'); </script>");
}
if (isset($_POST["UpdateUserType"])) {
    $User = new User();
    if ($_POST["UserId"] == "") die("User Id is unset!!");
    if ($_POST["UserType"] == "") die("User type unset!!");
    $User->setId(intval($_POST["UserId"]));
    $User->setType($_POST["UserType"]);
    $User->Update();
}
$flag = 0;
if (isset($_POST["SearshForUser"])) {
    $flag = 1;
    $User = new User();
    $User->setId(intval($_POST["UserId"]));
    $User->setName($_POST["UserName"]);
    $User->setDateOfBirth($_POST["DateOfBirth"]);
    $User->setType($_POST["UserType"]);
    $List = $User->Searsh();
    if (in_array("User-All", $Servis)) HTML::DisplayTable($List,1,"UserUpdate.php","UserDel.php");
    else HTML::DisplayTable($List);
}
if (isset($_POST["DeleteUser"])) {
    if ($_POST["UserId"] == "") die("User Id unset!!");
    $User = new User();
    $User->setId(intval($_POST["UserId"]));
    $User->Delete();
}
if($flag == 0)
{
    if(in_array("User-All", $Servis))
    {
        $User = new User();
        $User->setId(0);
        $User->setName("");
        $User->setType("");
        $List = $User->Searsh();
        if (in_array("User-All", $Servis)) HTML::DisplayTable($List,1,"UserUpdate.php","UserDel.php");
        else HTML::DisplayTable($List);
    }
    else if(in_array("User-Search", $Servis))
    {
        $User = new User();
        $User->setId(0);
        $User->setName("");
        $User->setType("");
        $List = $User->Searsh();
        if (in_array("User-All", $Servis)) HTML::DisplayTable($List,1,"UserUpdate.php","UserDel.php");
        else HTML::DisplayTable($List);
    }
}