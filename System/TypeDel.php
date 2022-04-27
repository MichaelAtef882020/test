<?php
include_once "../Classes/TypeClass.php";
$Type = new Type();
$Type->setId($_GET["Id1"]);
$Type->Delete();
echo(" <script> location.replace('Type.php'); </script>");