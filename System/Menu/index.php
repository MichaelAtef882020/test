<?php
include_once "../Classes.php";
if(session_id() == '') {
    session_start();
}
if(!isset($_SESSION["UserId"])) header("Location:../Login/Login.php");
else {
$Id = $_SESSION["UserId"];
$UserFile = new FileManger("User.txt");
$Line = $UserFile->ValueIsThere($Id, 0);
if($Line!=null) 
{
    $User = User::FromStringToObject($Line);
    HTML::Header($User->getType());
}
else HTML::Header("non");

$Form = new Form();
$Form->setActionFile("#");
$Form->setTitle("Menu");
$Servis = $User->GetServices();
if(!str_contains($Servis[0],"Product-Non")) 
{
    $Form->Attach(new Submit("Product","Activity","submit"));
}
if(!str_contains($Servis[1],"Order-Non"))
{
    $Form->Attach(new Submit("Order","Daily Activities","submit"));
}
if(!str_contains($Servis[2],"User-Non"))
{
    $Form->Attach(new Submit("User","User","submit"));
}
if($User->getType() == "1")
{
    $Form->Attach(new Submit("Type","User Types","submit"));
    $Form->Attach(new Submit("View", "View Design Patterns","submit"));
}
$Form->Attach(new Submit("Profile","Profile","submit"));

$Form->DisplayForm();

HTML::Footer();

if($Name = $Form->InfoIsTaken())
{
    if($Name == "Product") echo(" <script> location.replace('../Product/index.php'); </script>");
    else if($Name == "Order") echo(" <script> location.replace('../Order/index.php'); </script>");
    else if($Name == "User") echo(" <script> location.replace('../User/index.php'); </script>");
    else if($Name == "Type") echo(" <script> location.replace('../Type/index.php'); </script>");
    else if($Name == "Profile") echo(" <script> location.replace('../User/Profile.php'); </script>");
    else if($Name == "View") echo " <script> location.replace('../View Design Patterns/index.php'); </script>";
    exit();
}
}