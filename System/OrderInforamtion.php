<?php
    
    include_once "../Classes/OutPutClass.php";
    include_once "../Classes/OrderClass.php";
    include_once "../Classes/UserClass.php";
    include_once "../Classes/OrderDetailsClass.php";
    if(!isset($_GET["OrderId"])) echo(" <script> location.replace('index.php'); </script>");
    $Id = $_SESSION["UserId"];
    $UserFile = new FileManger("User.txt");
    $Id = $_SESSION["UserId"];
    $UserFile = new FileManger("User.txt");
    $Line = $UserFile->ValueIsThere($Id, 0);
    $User = User::FromStringToObject($Line);
    HTML::Header($User->getType());
    $OrderId = $_GET["OrderId"];
    $File = new FileManger("Order.txt");
    $Order = order::FromStringToObject($File->ValueIsThere($OrderId,0));
    $Inputs = [];
    array_push($Inputs,new Input("Addon1","Addon1","checkbox"));
    array_push($Inputs,new Input("Addon2","Addon2","checkbox"));
    array_push($Inputs,new Input("Addon3","Addon3","checkbox"));
    array_push($Inputs,new Input("Submit","Place Order","submit"));
    
    $File = new FileManger("User.txt");
    $User = User::FromStringToObject($File->ValueIsThere($Order->getClientId(),0));
    $OrderDetails = new Order_Details();
    $OrderDetails->setOrderId($Order->getId());
    $ListOrderDetails = $OrderDetails->Searsh();
    
    $Form = new Form();
    $Form->setActionFile(("#"));
    $Form->setInputs($Inputs);
    $Form->setTitle("Finish Order");
    $Form->DisplayForm();
    echo "<center>";
    echo "Order Id: $OrderId<br>";
    echo "<p>CLint Name: ".$User->getName()."</p>";
    echo "<p>Date: ".$Order->getDate()."</p>";
    echo "</center>";
    HTML::DisplayTable($ListOrderDetails);
    $temp=0;
    $add1=null;
    if(isset($_POST["Addon1"]))
    {
        $temp=1;
        $add1=new addon1($Order);
    }
    if(isset($_POST["Addon2"]))
    {
        if($temp==1)
        {
            $add1=new addon2($add1);

        }
        else
        {
            $add1=new addon2($Order);
            $temp=1;
        }
    }
    if(isset($_POST["Addon3"]))
    {
        if($temp==1)
        {
            $add1=new addon3($add1);
        }
        else
        {
            $add1=new addon3($Order);
        }
    }
    $add1->AddOn();
    echo "<center>";
    echo "<p>Total: ".$Order->getTotal()+$order->AddOn()."</p><br>";
    echo "</center>";
    echo "<a href='Order.php'> Return To Orders</a>";
    HTML::Footer();

?>