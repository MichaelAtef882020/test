<?php
include_once "../Classes/UserClass.php";
include_once "../Classes/OutPutClass.php";

HTML::Header("non");

$Inputs = [];
array_push($Inputs,new Input("UserName","Username","text"));
array_push($Inputs,new Input("Password","Password","password"));
array_push($Inputs,new Input("Login","Login","submit"));
$Form = new Form();
$Form->setActionFile("#");
$Form->setInputs($Inputs);
$Form->setTitle("Login");
$Form->DisplayForm();
HTML::Footer();
if ($Form->InfoIsTaken()) {
    if($_POST["UserName"] == "") die("UserName is required");
    if($_POST["Password"] == "") die("Password is required");
    $UserName = $_POST["UserName"];
    $Password = $_POST["Password"];
    $User = new User();
    $User->setName($UserName);
    $User->setPassword($Password);
    if($UserId = $User->Login())
    {
        session_start();
        $_SESSION["UserId"] = $UserId;
        header("Location:index.php");
    }
    else
    {
        echo "UserName or password is wrong!!";
    }
}
if (isset($_POST["SignUp"])) {
    header("Location:SignUp.php");
}
