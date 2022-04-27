<?php
include_once "../Classes/OrderDetailsClass.php";
$OrderDetails = new Order_Details();
$OrderDetails->setOrderId(intval($_GET["Id1"]));
$ProductName = $_GET["Id2"];
$ProductName = str_replace("%20"," ",$ProductName);
$File = new FileManger("Product.txt");
$ProductId = explode("~",$File->ValueIsThere($ProductName,2))[0];
$OrderDetails->setProduct_Id(intval($ProductId));
$OrderDetails->Delete();
$Id1 = $_GET["Id1"];
echo(" <script> location.replace('OrderDetails.php?OrderId=$Id1'); </script>");
