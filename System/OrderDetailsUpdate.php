<?php
include_once "../Classes/OutPutClass.php";
include_once "../Classes/OrderDetailsClass.php";
include_once "../Classes/UserClass.php";
include_once "../Classes/FileMangerClass.php";
include_once "../Classes/ProductClass.php";
$UserId = $_SESSION["UserId"];
$UserFile = new FileManger("User.txt");
$Line = $UserFile->ValueIsThere($UserId, 0);
$User = User::FromStringToObject($Line);
HTML::Header($User->getType());
$ProductName = $_GET["Id2"];
$ProductName = str_replace("%20"," ",$ProductName);
$File = new FileManger("Product.txt");
$ProductId = explode("~",$File->ValueIsThere($ProductName,2))[0];
$OrderDetails = Order_Details::GetOrderDetail(intval($_GET["Id1"]),intval($ProductId));
$Inputs = [];
array_push($Inputs,new Input("NumberOfProduct","Number Of Product","number",$OrderDetails->getNumbers()));
array_push($Inputs,new Input("Set new Values"));
array_push($Inputs,new Input("update","Set new value","submit"));
$Form = new Form();
$Form->setActionFile("#");
$Form->setInputs($Inputs);
$Form->setTitle("Update Daily Activity Details ".$OrderDetails->getProduct_Id());

$Form->DisplayForm();
HTML::Footer();

if($Form->InfoIsTaken())
{
    $UpdatedOrderDetail = new Order_Details();
    $UpdatedOrderDetail->setOrderId($OrderDetails->getOrderId());
    $UpdatedOrderDetail->setProduct_Id($OrderDetails->getProduct_Id());
    $UpdatedOrderDetail->setNumbers($_POST["NumberOfProduct"]);
    $UpdatedOrderDetail->Update();
    $OrderId = $_GET["Id1"];
    echo(" <script> location.replace('OrderDetails.php?OrderId=$OrderId'); </script>");
}