<?php
include_once "../Classes.php";
$Type = new Type();
$Type->setId($_GET["Id1"]);
$Type->Delete();
echo(" <script> location.replace('index.php'); </script>");