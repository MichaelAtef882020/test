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
echo "</center>";
$Form = new Form();
$Form->setActionFile("#");
$Form->setTitle(" ");
$Form->Attach(new CheckBox("Visa","Pay By Visa"));
$Form->Attach(new CheckBox("Cash", "Pay By Cash"));
$Form->Attach(new CheckBox("Fawry", "Pay By Fawry"));
$Form->Attach(new Submit("Submit","Place Order","submit"));
echo "<a href='Order.php'> Return To Orders</a>";
$Form->DisplayForm();
if(isset($_POST["Submit"])) {
    if(isset($_POST["Visa"])) {
        $Order->setPayObj(new Visa());
        $c++;
    } if(isset($_POST["Cash"])) {
        $Order->setPayObj(new Cash());
        $c++;
    } if(isset($_POST["Fawry"])) {
        $Order->setPayObj(new Fawry());
        $c++;
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