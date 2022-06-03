<?php
include_once "Classes.php";
HTML::Header("1");
$Form = new Form();
$Form->setActionFile("#");
$Form->setTitle("Types of Users");
$Form->Attach(new Text("Id","Type Id","number"));
$Form->Attach(new Text("Name","Type Name","text"));
$Input = new Select();
$Input->setName("Product");
$Text = ["Non","All","Add","Search"];
$Input->setText($Text);
$Input->setValue($Text);
$Input->setType("select");
$Form->Attach($Input);
$Input = new Select();
$Input->setName("Order");
$Text = ["Non","All","Add","Search"];
$Input->setText($Text);
$Input->setValue($Text);
$Input->setType("select");
$Form->Attach($Input);
$Input = new Select();
$Input->setName("User");
$Text = ["Non","All","Search"];
$Input->setText($Text);
$Input->setValue($Text);
$Input->setType("select");
$Form->Attach($Input);
$Form->Attach(new Submit("Add","Add","submit"));
$Form->Attach(new Submit("Search","Search","submit"));

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
} $flag = 0;
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
} if($flag == 0)
{
    $Type = new Type("0","","Non","Non","Non");
    $Display = $Type->Searsh();
    HTML::DisplayTable($Display,5,"TypeUpdate.php","TypeDel.php");
}