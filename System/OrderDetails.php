<?php
include_once "../Classes/UserClass.php";
include_once "../Classes/OutPutClass.php";
include_once "../Classes/FileMangerClass.php";
$Id = $_SESSION["UserId"];
$UserFile = new FileManger("User.txt");
$Line = $UserFile->ValueIsThere($Id, 0);
$User = User::FromStringToObject($Line);
$Servis = $User->GetServices();
HTML::Header($User->getType());
$Input = new Input();
$Input->setName("ProductId");
$Texts = [];
$Values = [];
array_push($Texts,"Non");
array_push($Values,"Non");
$ProductFile = new FileManger("Product.txt");
$List = $ProductFile->GetAllContent();
for ($i = 0; $i < count($List); $i++) {
    $Line = explode('~', $List[$i]);
    $Id = $Line[0];
    array_push($Texts,$Line[2]);
    array_push($Values,$Id);
}
$Input->setName("ProductId");
$Input->setText($Texts);
$Input->setValue($Values);
$Input->setType("select");
$Inputs = [];
array_push($Inputs,$Input);
array_push($Inputs,new Input("NumberOfProduct","Number Of Product","number"));
if(in_array("Order-Add", $Servis) ||in_array("Order-All", $Servis) )
{
    array_push($Inputs,new Input("AddItem","Add Item","submit"));
    array_push($Inputs,new Input("DeleteItem","Delete Item","submit"));
    array_push($Inputs,new Input("UpdateItem","Update Item","submit"));
    array_push($Inputs,new Input("Searsh","Search For An item","submit"));
    array_push($Inputs,new Input("PrintOrderInvoice","Print Order Invoice","submit"));
}
if(in_array("Order-Search", $Servis))
{
    array_push($Inputs,new Input("Searsh","Search For An item","submit"));
}
$Form = new Form();
$Form->setActionFile("#");
$Form->setInputs($Inputs);
$Header = "<a href='Order.php'>Daily Activity</a>";
$Form->setTitle("Daily Activity Details for ".$Header." ".$_GET["OrderId"]);
$Form->DisplayForm();
HTML::Footer();
include_once "../Classes/OrderDetailsClass.php";
if (isset($_POST["Logout"])) {
    session_unset();
    session_destroy();
    header("Location:Login.php");
}
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
    if (in_array("Order-All", $Servis)) HTML::DisplayTable($List,4,"OrderDetailsUpdate.php","OrderDetailsDel.php");
    else if(in_array("Order-Add", $Servis)) HTML::DisplayTable($List,4,"OrderDetailsUpdate.php","OrderDetailsDel.php");
    else HTML::DisplayTable($List);
}