<?php
session_start();
include_once "Classes.php";
$Id = $_SESSION["UserId"];
$UserFile = new FileManger("User.txt");
$Line = $UserFile->ValueIsThere($Id, 0);
$User = User::FromStringToObject($Line);
$Servis = $User->GetServices();
HTML::Header($User->getType());
$Form = new Form();
$Form->setActionFile("#");
$Form->setTitle("Daily Activities");
$Form->Attach(new Text("OrderId","Daily Activity Id","number"));
if ($User->getType() != "3") $Form->Attach(new Text("ClintId","Clint Id","number"));
$Form->Attach(new Text("Date","Date of Daily Activity","date"));
$Form->Attach(new Text("Total","Total","number"));
if (in_array("Order-All", $Servis) || in_array("Order-Add", $Servis)) 
{ 
    $Form->Attach(new Submit("AddOrder","Add Order","submit"));
}
if (in_array("Order-All", $Servis) || in_array("Order-Search", $Servis))
{
    $Form->Attach(new Submit("SearchForOrder","Search for Order","submit"));
}
$Form->DisplayForm();
HTML::Footer();
include_once "../Classes/OrderClass.php";
if (isset($_POST["AddOrder"])) {

    $Order = new Order();
    if ($User->getType() == "3") $Order->setClientId($User->getId());
    else {
        if ($_POST["ClintId"] == "") die("Clint Id is unset!!");
        $Order->setClientId(intval($_POST["ClintId"]));
    }
    $Order->setDate($_POST["Date"]);
    $Order->Add();
    $OrderId = $Order->getId();
    echo(" <script> location.replace('OrderDetails.php?OrderId=$OrderId'); </script>");
}
$flag = 0;
if(isset($_POST["SearchForOrder"]))
{
    $flag = 1;
    $order=new order();
    $order->setId(intval($_POST["OrderId"]));
    $order->setClientId(intval($_POST["ClintId"]));
    $order->setDate($_POST["Date"]);
    $order->setTotal(intval($_POST["Total"]));
    $List = $order->Searsh();
    if (in_array("Order-All", $Servis)) HTML::DisplayTable($List,3,"OrderUpdate.php","OrderDel.php");
    else if(in_array("Order-Search", $Servis)) HTML::DisplayTable($List,3);
    else HTML::DisplayTable($List);
} if($flag == 0)
{
    $order=new order();
    $order->setId(0);
    $order->setClientId(0);
    $order->setDate("");
    $List = $order->Searsh();
    if (in_array("Order-All", $Servis)) HTML::DisplayTable($List,3,"OrderUpdate.php","OrderDel.php");
    else if(in_array("Order-Search", $Servis)) HTML::DisplayTable($List,3);
    else HTML::DisplayTable($List);
}