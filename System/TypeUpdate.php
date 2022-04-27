<?php

include_once "../Classes/OutPutClass.php";
include_once "../Classes/UserClass.php";
include_once "../Classes/TypeClass.php";
include_once "../Classes/FileMangerClass.php";
$UserId = $_SESSION["UserId"];
$UserFile = new FileManger("User.txt");
$Line = $UserFile->ValueIsThere($UserId, 0);
$User = User::FromStringToObject($Line);
HTML::Header($User->getType());
$UserTypeMenuFile = new FileManger("User Type Menu.txt");
$Type = Type::FromStringToObject($UserTypeMenuFile->ValueIsThere($_GET["Id1"],0));
$UserTypeFile = new FileManger("User Type.txt");
$Type->setName(explode('~',$UserTypeFile->ValueIsThere($Type->getId(),0))[1]);
$Inputs = [];
array_push($Inputs,new Input("Name","Type Name","text",$Type->getName()));
$Input = new Input();
$Input->setName("Product");
$Text = ["Non","All","Add","Search"];
if($Type->getProduct() == "Product-Non") $Text[0].="~"; // To make the selected
if($Type->getProduct() == "Product-All") $Text[1].="~";
if($Type->getProduct() == "Product-Add") $Text[2].="~";
if($Type->getProduct() == "Product-Search") $Text[3].="~";
$Input->setText($Text);
$Value = ["Non","All","Add","Search"];
$Input->setValue($Value);
$Input->setType("select");
array_push($Inputs,$Input);
$Input = new Input();
$Input->setName("Order");
$Text = ["Non","All","Add","Search"];
if($Type->getOrder() == "Order-Non") $Text[0].="~"; // To make the selected
if($Type->getOrder() == "Order-All") $Text[1].="~";
if($Type->getOrder() == "Order-Add") $Text[2].="~";
if($Type->getOrder() == "Order-Search") $Text[3].="~";
$Input->setText($Text);
$Value = ["Non","All","Add","Search"];
$Input->setValue($Value);
$Input->setType("select");
array_push($Inputs,$Input);
$Input = new Input();
$Input->setName("User");
$Text = ["Non","All","Search"];
if($Type->getUser() == "User-Non") $Text[0].="~"; // To make the selected
if($Type->getUser() == "User-All") $Text[1].="~";
if($Type->getUser() == "User-Search") $Text[2].="~";
$Input->setText($Text);
$Value = ["Non","All","Search"];
$Input->setValue($Value);
$Input->setType("select");
array_push($Inputs,$Input);

array_push($Inputs,new Input("Update","Set new values","submit"));
$Form = new Form();
$Form->setActionFile("#");
$Form->setInputs($Inputs);
$Form->setTitle("Update Type ".$Type->getName());
$Form->DisplayForm();
HTML::Footer();

if($Form->InfoIsTaken())
{
    $UpdatedType = new Type($Type->getId(),$_POST["Name"],$_POST["Product"],$_POST["Order"],$_POST["User"]);
    $UpdatedType->Update();
    echo(" <script> location.replace('Type.php'); </script>");
}