<?php 

include_once "../Classes/OrderClass.php";
include_once "../Classes/UserClass.php";
include_once "../Classes/OutPutClass.php";
include_once "../Classes/FileMangerClass.php";
$UserId = $_SESSION["UserId"];
$UserFile = new FileManger("User.txt");
$Line = $UserFile->ValueIsThere($UserId, 0);
$User = User::FromStringToObject($Line);
HTML::Header($User->getType());
$Order = new order();
$Order->setId(intval($_GET["Id1"]));
$File = new FileManger("Order.txt");
$Order = order::FromStringToObject($File->ValueIsThere($Order->getId(),0));

$Inputs = [];
if ($User->getType() != "3") array_push($Inputs,new Input("ClintId","Clint Id","number",$Order->getClientId()));
array_push($Inputs,new Input("Date","Date of order","date",$Order->getDate()));
array_push($Inputs,new Input("Update","Set new values","submit"));
$Form = new Form();
$Form->setActionFile("#");
$Form->setInputs($Inputs);
$Form->setTitle("Update Daily Activity ".$Order->getId());

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