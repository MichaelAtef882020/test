<?php
include_once "../Classes.php";
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
echo "<center>";
echo "Order Id: $OrderId<br>";
echo "<p>CLint Name: ".$User->getName()."</p>";
echo "<p>Date: ".$Order->getDate()."</p>";
echo "</center>";
HTML::DisplayTable($ListOrderDetails);
echo "<center>";
echo "<p>Total: ".$Order->getTotal()."</p><br>";
echo "</center>";
echo "<a href='index.php'> Return To Orders</a>";
HTML::Footer();
