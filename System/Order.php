<?php
session_start();
include_once "../Classes/UserClass.php";
include_once "../Classes/OutPutClass.php";
include_once "../Classes/FileMangerClass.php";
$Id = $_SESSION["UserId"];
$UserFile = new FileManger("User.txt");
$Line = $UserFile->ValueIsThere($Id, 0);
$User = User::FromStringToObject($Line);
$Servis = $User->GetServices();
HTML::Header($User->getType());
$Inputs = [];
array_push($Inputs,new Input("OrderId","Daily Activity Id","number"));
if ($User->getType() != "3") array_push($Inputs,new Input("ClintId","Clint Id","number"));
array_push($Inputs,new Input("Date","Date of Daily Activity","date"));
array_push($Inputs,new Input("Total","Total","number"));
if (in_array("Order-All", $Servis) || in_array("Order-Add", $Servis)) 
{   array_push($Inputs,new Input("AddOrder","Add Order","submit"));}
if (in_array("Order-All", $Servis))
{
    array_push($Inputs,new Input("UpdateOrder","Update Order","submit"));
    array_push($Inputs,new Input("DeleteOrder","Delete Order","submit"));
}
if (in_array("Order-All", $Servis) || in_array("Order-Search", $Servis))
{
    array_push($Inputs,new Input("SearchForOrder","Search for Order","submit"));
}
array_push($Inputs,new Input("ViewOrderDetails","See Order Details","submit"));
array_push($Inputs,new Input("PrintOrderInvoice","Print Order Invoice","submit"));
$Form = new Form();
$Form->setActionFile("#");
$Form->setInputs($Inputs);
$Form->setTitle("Daily Activities");
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
    unset($_POST["AddOrder"]);
    unset($_POST["ClintId"]);
    unset($_POST["Date"]);
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
    unset($_POST["SearchForOrder"]);
    unset($_POST["OrderId"]);
    unset($_POST["ClintId"]);
    unset($_POST["Date"]);
}
if (isset($_POST["ViewOrderDetails"])) {
    if ($_POST["OrderId"] == "") exit("Order Id is required");
    $OrderFile = new FileManger("Order.txt");
    if ($isexist = $OrderFile->ValueIsThere($_POST["OrderId"], 0)) {
        $Array = explode('~', $isexist);
        if ($Array[1] != $User->getId()) {
            if(!in_array("Order-All", $Servis) && !in_array("Order-Search", $Servis)) {
                exit("You cannot See the details of this order");
            }
        }
        $OrderId = $_POST["OrderId"];
        echo(" <script> location.replace('OrderDetails.php?OrderId=$OrderId'); </script>");
    } else exit("No Order with this Id");
}
if(isset($_POST["DeleteOrder"]))
{
    if ($_POST["OrderId"] == "") exit("Order Id is required");
    $order=new order();
    $order->setId(intval($_POST["OrderId"]));
    $order->Delete();
    unset($_POST["OrderId"]);
    unset($_POST["ClintId"]);
    unset($_POST["Date"]);
}
if(isset($_POST["PrintOrderInvoice"]))
{
    if($_POST["OrderId"] == "") exit("Order Id is required");
    $Id = $_POST["OrderId"];
    echo(" <script> location.replace('PrintInvoice.php?OrderId=$Id'); </script>");
}
if (isset($_POST["UpdateOrder"])) {
    if($_POST["OrderId"] == "") exit("Order Id is required");
    $Order = new order();
    $Order->setId(intval($_POST["OrderId"]));
    if ($User->getType() == "3") $Order->setClientId($User->getId());
    else {
        $Order->setClientId(intval($_POST["ClintId"]));
    }
    $Order->setDate($_POST["Date"]);
    $Order->Update();
}
if($flag == 0)
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