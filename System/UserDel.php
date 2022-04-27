<?php
include_once "../Classes/UserClass.php";
$User = new User();
$User->setId(intval($_GET["Id1"]));
$User->Delete();
header("Location:User.php");
echo(" <script> location.replace('User.php'); </script>");
