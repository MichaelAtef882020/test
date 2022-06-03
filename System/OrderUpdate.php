<?php
include_once "Classes.php";
$UserId = $_SESSION["UserId"];
$UserFile = new FileManger("User.txt");
$Line = $UserFile->ValueIsThere($UserId, 0);
$User = User::FromStringToObject($Line);
HTML::Header($User->getType());
$Order = new order();
$Order->setId(intval($_GET["Id1"]));
$File = new FileManger("Order.txt");
$Order = order::FromStringToObject($File->ValueIsThere($Order->getId(),0));
$Form = new Form();
$Form->setActionFile("#");
$Form->setTitle("Update Daily Activity " . $Order->getId());
if ($User->getType() != "3") $Form->Attach(new Text("ClintId","Clint Id","number",$Order->getClientId()));
$Form->Attach(new Text("Date","Date of order","date",$Order->getDate()));
$Form->Attach(new Submit("Update","Set new values","submit"));
$Form->DisplayForm();
HTML::Footer();
if($Form->InfoIsTaken())
{
    $UpdatedOrder = new order();
    $UpdatedOrder->setId($Order->getId());
    if($User->getType()!=3) $UpdatedOrder->setClientId(intval($_POST["ClintId"]));
    else $UpdatedOrder->setClientId($Order->getClientId());
    $UpdatedOrder->setDate($_POST["Date"]);
    $UpdatedOrder->Update();
    echo(" <script> location.replace('Order.php'); </script>");
}