<?php
    
    include_once "OrderInterface.php";
    include_once "Order.php";
    include_once "SubStracOrderInfo.php";

class addon2 extends order_Info_ 
{
    public  function AddOn()
    {
        return $this->order->AddOn()+200;
    }
}
?>