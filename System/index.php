<?php
include_once "../Classes/OutPutClass.php";
include_once "../Classes/FileMangerClass.php";
include_once "../Classes/UserClass.php";
if(session_id() == '') {
    session_start();
}
if(!isset($_SESSION["UserId"])) header("Location:Login.php");
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
$Servis = $User->GetServices();
$Inputs = [];
if(!str_contains($Servis[0],"Product-Non")) 
{
    array_push($Inputs,new Input("Product","Activity","submit"));
}
if(!str_contains($Servis[1],"Order-Non"))
{
    array_push($Inputs,new Input("Order","Daily Activities","submit"));
}
if(!str_contains($Servis[2],"User-Non"))
{
    array_push($Inputs,new Input("User","User","submit"));
}
if($User->getType() == "1")
{
    array_push($Inputs,new Input("Type","User Types","submit"));
}
array_push($Inputs,new Input("Profile","Profile","submit"));
$Form = new Form();
$Form->setActionFile("#");
$Form->setInputs($Inputs);
$Form->setTitle("Menu");
$Form->DisplayForm();

HTML::Footer();

if($Name = $Form->InfoIsTaken())
{
    if($Name == "Product") echo(" <script> location.replace('Product.php'); </script>");
    else if($Name == "Order") echo(" <script> location.replace('Order.php'); </script>");
    else if($Name == "User") echo(" <script> location.replace('User.php'); </script>");
    else if($Name == "Type") echo(" <script> location.replace('Type.php'); </script>");
    else if($Name == "Profile") echo(" <script> location.replace('Profile.php'); </script>");
    exit();
}
}