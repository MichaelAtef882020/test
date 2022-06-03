<?php
include_once "Classes.php";
HTML::Header("non");
$Form = new Form();
$Form->setActionFile("#");
$Form->setTitle("Login");
$Form->Attach(new Text("UserName","Username","text"));
$Form->Attach(new Text("Password","Password","password"));
$Form->Attach(new Submit("Login","Login","submit"));
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
        echo(" <script> location.replace('index.php'); </script>");
    }
    else
    {
        echo "UserName or password is wrong!!";
    }
}
if (isset($_POST["SignUp"])) {
    echo(" <script> location.replace('SignUp.php'); </script>");
}
