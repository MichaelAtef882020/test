<?php
    
include_once "OrderInterface.php";
abstract class order_Info_ 
{
    public orderInforation $order;
	function __construct($order)
     {
         $this->order=$order;
     }     
}
?>