<?php
session_start();
include_once "../Classes.php";
$Id = $_SESSION["UserId"];
$UserFile = new FileManger("User.txt");
$Line = $UserFile->ValueIsThere($Id, 0);
$User = User::FromStringToObject($Line);
$Servis = $User->GetServices();

HTML::Header($User->getType());
$Form = new Form();
$Form->setActionFile("#");
$Form->setTitle("Users");
$Form->Attach(new Text("UserId","User Id","number"));
$Form->Attach(new Text("UserName","User Name","text"));
$Form->Attach(new Text("DateOfBirth","Date of Birth","date"));
$Input = new Select();
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

$Form->Attach($Input);
if (in_array("User-All", $Servis))
{
    $Form->Attach(new Submit("AddUser","Add User","submit"));
    $Form->Attach(new Submit("SearshForUser","Search For User","submit"));
}
else if(in_array("User-Search", $Servis))
{
    $Form->Attach(new Submit("SearshForUser","Search For User","submit"));
}
$Form->DisplayForm();
HTML::Footer();
include_once "../Classes/UserClass.php";
if (isset($_POST["AddUser"])) {
    echo(" <script> location.replace('../Login/SignUp.php'); </script>");
} $flag = 0;
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
} if($flag == 0)
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