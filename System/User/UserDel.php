<?php
include_once "../Classes.php";
$User = new User();
$User->setId(intval($_GET["Id1"]));
$User->Delete();
echo(" <script> location.replace('index.php'); </script>");
