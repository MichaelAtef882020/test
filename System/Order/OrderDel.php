<?php
include_once "../Classes.php";
$Order = new Order();
$Order->setId(intval($_GET["Id1"]));
$Order->Delete();
echo(" <script> location.replace('index.php'); </script>");