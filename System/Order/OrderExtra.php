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
$Form->setTitle("Order Extra");
$Form->Attach(new Text("Comment","Comment","text"));
$Form->Attach(new CheckBox("Cheese","Cheese"));
$Form->Attach(new CheckBox("Milk","Milk"));
$Form->Attach(new CheckBox("Desert", "Desert"));
$Form->Attach(new Submit("Submit","Payment process","Submit"));
$Form->DisplayForm();
HTML::Footer();

if(isset($_POST["Submit"])) {
    $OrderId = $_GET["OrderId"];
    echo (" <script> location.replace('FinishOrder.php?OrderId=$OrderId'); </script>");
}