<?php
include_once "../Classes.php";
$Product = new Product();
$Product->setId(intval($_GET["Id1"]));
$Product->Delete();
echo(" <script> location.replace('index.php'); </script>");