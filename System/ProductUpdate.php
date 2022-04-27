<?php
include_once "../Classes/OutPutClass.php";
include_once "../Classes/ProductClass.php";
include_once "../Classes/UserClass.php";
include_once "../Classes/FileMangerClass.php";
$UserId = $_SESSION["UserId"];
$UserFile = new FileManger("User.txt");
$Line = $UserFile->ValueIsThere($UserId, 0);
$User = User::FromStringToObject($Line);
HTML::Header($User->getType());
$Id = $_GET["Id1"];
$Product = new Product();
$Product = $Product->Get_Info_Of_Product($Id);
$Inputs = [];
array_push($Inputs,new Input("Name","Product Name","text",$Product->getName()));
array_push($Inputs,new Input("Price","Product Price","number",$Product->getCost()));
array_push($Inputs,new Input("Update","Update","submit"));
$Form = new Form();
$Form->setActionFile("#");
$Form->setInputs($Inputs);
$Form->setTitle("Update Activity ".$Product->getId());
$Form->DisplayForm();
HTML::Footer();
if($Form->InfoIsTaken())
{
    $Product->setId($Id);
    $Product->setName($_POST["Name"]);
    $Product->setCost($_POST["Price"]);
    $Product->Update();
    echo(" <script> location.replace('Product.php'); </script>");
}