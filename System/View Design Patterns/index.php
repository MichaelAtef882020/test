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
$Form->setTitle("Daily Activities");
$Form->Attach(new Submit("Payments","Order Payments","submit"));
$Form->Attach(new Submit("Notify", "Order Notification", "submit"));
$Form->Attach(new Submit("Extras", "Order Extras", "submit"));
$Form->DisplayForm();
HTML::Footer();
if(isset($_POST["Payments"])) {
    $File = new FileManger("Order Payments.txt");
    $List = $File->GetAllContent();
    $DisplayedList = [];
    array_push($DisplayedList, ["Payments",""]);
    for ($i=0; $i < count($List); $i++) { 
        $Array = [$List[$i],""];
        array_push($DisplayedList,$Array);
    }
    HTML::DisplayTable($DisplayedList);
} else if(isset($_POST["Notify"])) {
    $File = new FileManger("Notification.txt");
    $List = $File->GetAllContent();
    $DisplayedList = [];
    array_push($DisplayedList, ["Notifications", ""]);
    for ($i = 0; $i < count($List); $i++) {
        $Array = [$List[$i], ""];
        array_push($DisplayedList, $Array);
    }
    HTML::DisplayTable($DisplayedList);
} else if(isset($_POST["Extras"])) {
    $File = new FileManger("Order Extras.txt");
    $List = $File->GetAllContent();
    $DisplayedList = [];
    array_push($DisplayedList, ["Order Extras", ""]);
    for ($i = 0; $i < count($List); $i++) {
        $Array = [$List[$i], ""];
        array_push($DisplayedList, $Array);
    }
    HTML::DisplayTable($DisplayedList);
}