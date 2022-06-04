<?php
include_once "../Classes.php";
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
$Form = new Form();
$Form->setActionFile("#");
$Form->setTitle("Update Daily Activity Details " . $OrderDetails->getProduct_Id());
$Form->Attach(new Text("NumberOfProduct","Number Of Product","number",$OrderDetails->getNumbers()));
$Form->Attach(new Submit("update","Set new value","submit"));
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
    echo(" <script> location.replace('index.php?OrderId=$OrderId'); </script>");
}