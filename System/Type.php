<?php 
include_once "../Classes/OutPutClass.php";
include_once "../Classes/TypeClass.php";
HTML::Header("1");
$Inputs =[];
array_push($Inputs,new Input("Id","Type Id","number"));
array_push($Inputs,new Input("Name","Type Name","text"));
$Input = new Input();
$Input->setName("Product");
$Text = ["Non","All","Add","Search"];
$Input->setText($Text);
$Input->setValue($Text);
$Input->setType("select");
array_push($Inputs,$Input);
$Input = new Input();
$Input->setName("Order");
$Text = ["Non","All","Add","Search"];
$Input->setText($Text);
$Input->setValue($Text);
$Input->setType("select");
array_push($Inputs,$Input);
$Input = new Input();
$Input->setName("User");
$Text = ["Non","All","Search"];
$Input->setText($Text);
$Input->setValue($Text);
$Input->setType("select");
array_push($Inputs,$Input);
array_push($Inputs,new Input("Add","Add","submit"));
array_push($Inputs,new Input("Update","Update","submit"));
array_push($Inputs,new Input("Search","Search","submit"));
array_push($Inputs,new Input("Delete","Delete","submit"));
$Form = new Form();
$Form->setActionFile("#");
$Form->setInputs($Inputs);
$Form->setTitle("Types of Users");
$Form->DisplayForm();
HTML::Footer();
if(isset($_POST["Add"]))
{
    if($_POST["Name"] == "") die("Name is Unset!!");
    $Name = $_POST["Name"];
    $Product = $_POST["Product"];
    $Order = $_POST["Order"];
    $User = $_POST["User"];
    $Type = new Type(-1,$Name,$Product,$Order,$User);
    $Type->Add();
}
if(isset($_POST["Update"]))
{
    if(isset($_POST["Id"]) == "") die("Id is unset!!");
    $Id = $_POST["Id"];
    $Type = new Type($Id,$_POST["Name"],$_POST["Product"],$_POST["Order"],$_POST["User"]);
    $Type->Update();
}
$flag = 0;
if(isset($_POST["Search"])) {
    $flag = 1;
    $Name = $_POST["Name"];
    $Id = $_POST["Id"];
    $Product = $_POST["Product"];
    $Order = $_POST["Order"];
    $User = $_POST["User"];
    $Type = new Type($Id,$Name,$Product,$Order,$User);
    $Display = $Type->Searsh();
    HTML::DisplayTable($Display,5,"TypeUpdate.php","TypeDel.php");
}
if(isset($_POST["Delete"]))
{
    if(isset($_POST["Id"]) == "") die("Id is unset!!");
    $Type = new Type();
    $Type->setId($_POST["Id"]);
    $Type->Delete();
}

if($flag == 0)
{
    $Type = new Type("0","","Non","Non","Non");
    $Display = $Type->Searsh();
    HTML::DisplayTable($Display,5,"TypeUpdate.php","TypeDel.php");
}