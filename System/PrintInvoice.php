<?php
include_once "../Classes/OutPutClass.php";
include_once "../Classes/OrderClass.php";
include_once "../Classes/UserClass.php";
include_once "../Classes/OrderDetailsClass.php";
if(!isset($_GET["OrderId"])) echo(" <script> location.replace('index.php'); </script>");
$Id = $_SESSION["UserId"];
$UserFile = new FileManger("User.txt");
$Line = $UserFile->ValueIsThere($Id, 0);
$User = User::FromStringToObject($Line);
HTML::Header($User->getType());
$OrderId = $_GET["OrderId"];
$File = new FileManger("Order.txt");
$Order = order::FromStringToObject($File->ValueIsThere($OrderId,0));
$File = new FileManger("User.txt");
$User = User::FromStringToObject($File->ValueIsThere($Order->getClientId(),0));
$OrderDetails = new Order_Details();
$OrderDetails->setOrderId($Order->getId());
$ListOrderDetails = $OrderDetails->Searsh();
echo "Order Id: $OrderId<br><br>";
echo "<p>CLint Name: ".$User->getName()."</p><br>";
echo "<p>Date: ".$Order->getDate()."</p><br>";
HTML::DisplayTable($ListOrderDetails);
echo "<p>     Total: ".$Order->getTotal()."</p><br><br>";
echo "<a href='Order.php'> Return To Orders</a>";
HTML::Footer();
