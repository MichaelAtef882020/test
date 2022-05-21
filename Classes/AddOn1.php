<?php
    
    include_once "OrderInterface.php";
    include_once "OrderClass.php";
    include_once "SubStracOrderInfo.php";

class addon1 extends order_Info_ 
{
    public  function AddOn()
    {
     return $this->order->AddOn()+100;
    }
}
?>