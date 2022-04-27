<?php
include_once "../Classes/ProductClass.php";
$Product = new Product();
$Product->setId(intval($_GET["Id1"]));
$Product->Delete();
header("Location:Product.php");
echo(" <script> location.replace('Product.php'); </script>");