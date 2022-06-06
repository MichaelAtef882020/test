<?php
include_once "../Classes.php";
if(!isset($_GET["OrderId"])) echo(" <script> location.replace('index.php'); </script>");
$Id = $_SESSION["UserId"];
$UserFile = new FileManger("User.txt");
$Line = $UserFile->ValueIsThere($Id, 0);
$User = User::FromStringToObject($Line);
HTML::Header($User->getType());
$OrderId = $_GET["OrderId"];
$File = new FileManger("Order.txt");
$Order = order::FromStringToObject($File->ValueIsThere($OrderId,0));
echo "<center>";
echo "Order Id: $OrderId<br>";
echo "<p>CLint Name: ".$User->getName()."</p>";
echo "<p>Date: ".$Order->getDate()."</p>";
echo "</center>";
$File = new FileManger("User.txt");
$User = User::FromStringToObject($File->ValueIsThere($Order->getClientId(), 0));
$OrderDetails = new Order_Details();
$OrderDetails->setOrderId($Order->getId());
$ListOrderDetails = $OrderDetails->Searsh();
HTML::DisplayTable($ListOrderDetails);
echo "<center>";
echo "<p>Total: ".$Order->getTotal()."</p><br>";
$Extra = "";
$File = new FileManger("Order Extras.txt");
$List = $File->GetAllContent();
foreach ($List as $Line) {
    $Id = explode(' ', $Line)[1];
    if ($Order->getId() == intval($Id)) {
        $Extra = $Line;
    }
}
echo $Extra."<br>";
echo "</center>";
$Form = new Form();
$Form->setActionFile("#");
$Form->setTitle(" ");
// Puting Pay Typs 
$File = new FileManger("Payments Type.txt");
$Payments = $File->GetAllContent();
foreach ($Payments as $Line) {
    $Line = str_replace("\r\n", "", $Line);
    $Form->Attach(new CheckBox("$Line", "Pay By $Line","checkbox","1"));        
}
$Form->Attach(new Submit("Submit","Place Order","submit"));
$Form->DisplayForm();
$Id = $Order->getId();
echo "<a href='../OrderDetails/index.php?OrderId=$Id'> Return To Order Details</a>";

// if(isset($_POST["Cash"])) $Order->SetPayObj(new Cash());
// if(isset($_POST["Fawry"])) $Order->SetPayObj(new Fawry());
// if(isset($_POST["Visa"])) $Order->SetPayObj(new Visa());
if(isset($_POST["Submit"])) {
    foreach ($Payments as $Pay ) {
        $Pay = str_replace("\r\n","",$Pay);
        if ($_POST[$Pay] == "1") {
            $Order->setPayObj(new $Pay());
            $c++;
        }    
    }
    if($c==0) echo "You Must Chose One from the options";
    else if($c > 1) echo "You Must Chose Only One from the options";
    else {
        $Order->FinishOrder();
        echo (" <script> location.replace('index.php'); </script>");
    }
}
HTML::Footer();
?>