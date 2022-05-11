<?php
include_once "../Classes/UserClass.php";
include_once "../Classes/OutPutClass.php";
include_once "../Classes/FileMangerClass.php";
include_once "../Classes/OrderDetailsDisplay.php";
$Id = $_SESSION["UserId"];
$UserFile = new FileManger("User.txt");
$Line = $UserFile->ValueIsThere($Id, 0);
$User = User::FromStringToObject($Line);
$User->setDisplayType(new OrderDetailsDisplay());
$User->DisplayMenu();
include_once "../Classes/OrderDetailsClass.php";
if (isset($_POST["AddItem"])) {
    if ($_POST["ProductId"] == "Non") die("Product is Required!");
    if ($_POST["NumberOfProduct"] == "") die("Product Number is Required!!");
    $Product_Id = $_POST["ProductId"];
    $Product_Number = $_POST["NumberOfProduct"];
    $Object_of_order_details = new  Order_Details();
    $Object_of_order_details->setOrderId(intval($_GET["OrderId"]));
    $Object_of_order_details->setProduct_Id(intval($_POST["ProductId"]));
    $Object_of_order_details->setNumbers(intval($_POST["NumberOfProduct"]));
    $Object_of_order_details->Add();
    unset($_POST["AddItem"]);
    unset($_POST["ProductId"]);
    unset($_POST["NumberOfProduct"]);
}
$flag = 0;
if(isset($_POST["Searsh"]))
{
    $flag = 1;
    $OrderDetails = new Order_Details();
    $OrderDetails->setOrderId(intval($_GET["OrderId"]));
    $OrderDetails->setProduct_Id(intval($_POST["ProductId"]));
    $OrderDetails->setNumbers(intval($_POST["NumberOfProduct"]));
    $List = $OrderDetails->Searsh();
    if (in_array("Order-All", $Servis)) HTML::DisplayTable($List,4,"OrderDetailsUpdate.php","OrderDetailsDel.php");
    else HTML::DisplayTable($List);
    unset($_POST["ProductId"]);
    unset($_POST["NumberOfProduct"]);
}

if(isset($_POST["DeleteItem"]))
{
    $OrderDetails = new Order_Details();
    if($_POST["ProductId"] == "Non") exit("Product is Required");
    $OrderDetails->setOrderId(intval($_GET["OrderId"]));
    $OrderDetails->setProduct_Id(intval($_POST["ProductId"]));
    $OrderDetails->Delete();
    unset($_POST["ProductId"]);
    unset($_POST["NumberOfProduct"]);
}
if(isset($_POST["UpdateItem"]))
{
    $OrderDetails = new Order_Details();
    $OrderDetails->setOrderId(intval($_GET["OrderId"]));
    $OrderDetails->setProduct_Id($_POST["ProductId"]);
    $OrderDetails->setNumbers($_POST["NumberOfProduct"]);
    $OrderDetails->Update();
    unset($_POST["ProductId"]);
    unset($_POST["NumberOfProduct"]);
}
if($flag == 0)
{
    $OrderDetails = new Order_Details();
    $OrderDetails->setOrderId(intval($_GET["OrderId"]));
    $OrderDetails->setProduct_Id(0);
    $OrderDetails->setNumbers(0);
    $List = $OrderDetails->Searsh();
    if (in_array("Order-All", $User->GetServices())) HTML::DisplayTable($List,4,"OrderDetailsUpdate.php","OrderDetailsDel.php");
    else if(in_array("Order-Add", $User->GetServices())) HTML::DisplayTable($List,4,"OrderDetailsUpdate.php","OrderDetailsDel.php");
    else HTML::DisplayTable($List);
}