<?php
include_once "../Classes.php";
$Order = new Order();
$Order->setId(intval($_GET["Id1"]));
$Order->Delete();
header("Location:Order.php");
echo(" <script> location.replace('index.php'); </script>");