<?php
include_once "../Classes.php";
$UserId = $_SESSION["UserId"];
$UserFile = new FileManger("User.txt");
$Line = $UserFile->ValueIsThere($UserId, 0);
$User = User::FromStringToObject($Line);
HTML::Header($User->getType());
$Id = $_GET["Id1"];
$Product = new Product();
$Product = $Product->Get_Info_Of_Product($Id);
$Form = new Form();
$Form->setActionFile("#");
$Form->setTitle("Update Activity " . $Product->getId());
$Form->Attach(new Text("Name","Product Name","text",$Product->getName()));
$Form->Attach(new Text("Price","Product Price","number",$Product->getCost()));
$Form->Attach(new Submit("Update","Update","submit"));
$Form->DisplayForm();
HTML::Footer();
if($Form->InfoIsTaken())
{
    $Product->setId($Id);
    $Product->setName($_POST["Name"]);
    $Product->setCost($_POST["Price"]);
    $Product->Update();
    echo(" <script> location.replace('index.php'); </script>");
}