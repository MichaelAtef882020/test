<?php
include_once "../Classes/OrderClass.php";
$Order = new Order();
$Order->setId(intval($_GET["Id1"]));
$Order->Delete();
header("Location:Order.php");
echo(" <script> location.replace('Order.php'); </script>");