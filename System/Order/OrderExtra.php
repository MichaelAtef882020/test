<?php
session_start();
include_once "../Classes.php";
$Id = $_SESSION["UserId"];
$UserFile = new FileManger("User.txt");
$Line = $UserFile->ValueIsThere($Id, 0);
$User = User::FromStringToObject($Line);
$Servis = $User->GetServices();
HTML::Header($User->getType());
$Form = new Form();
$Form->setActionFile("#");
$Form->setTitle("Order Extra");
$Form->Attach(new Text("Comment","Comment","text"));
// Add Extras From File
$File = new FileManger("Extras Type.txt");
$List = $File->GetAllContent();
foreach ($List as $Line ) {
    $Array = explode("~",$Line);
    $Form->Attach(new CheckBox($Array[0], $Array[0],"checkbox","1"));
}
//$Form->Attach(new CheckBox("Cheese","Cheese"));
//$Form->Attach(new CheckBox("Milk","Milk"));
//$Form->Attach(new CheckBox("Desert", "Desert"));
$Form->Attach(new Submit("Submit","Payment process","Submit"));
$Form->DisplayForm();
$OrderId = $_GET["OrderId"];
$File = new FileManger("Order.txt");
$Order = order::FromStringToObject($File->ValueIsThere($OrderId, 0));
echo "<a href='../OrderDetails/index.php?OrderId=$OrderId'> Return To Order Details</a>";
HTML::Footer();

if(isset($_POST["Submit"])) {
    $AddOn = $Order;
    $t = 0;
    foreach ($List as $Line ) {
        $Array = explode("~",$Line);
        if(isset($_POST[$Array[0]])){
            if($t == 0){
                $String.="Order ".$Order->getId()." Has Extra ".$Array[0];
            } else {
                $String.=" and ".$Array[0];
            }
            $AddOn = new $Array[0]($AddOn);
            $t=1;
        }
    }
    $Total = $AddOn->CalculateTotal();
    $String.=" With Total ".$Total."\r\n";
    if($_POST["Comment"]!="") $String.="With Comment ". $_POST["Comment"];
    $File = new FileManger("Order Extras.txt");
    $File->Add($String);
    echo (" <script> location.replace('FinishOrder.php?OrderId=$OrderId'); </script>");
}