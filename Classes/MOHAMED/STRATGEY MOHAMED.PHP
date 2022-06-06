<?php

include_once "../FileMangerClass.php";

abstract class PayWay
{
   protected Data $manger;
  public  function __construct()
  {
      $this->manger->Add("Order Pyments.txt");
  }
public abstract function df3($OrderID);
}
class eitslat_cash extends PayWay
{
   public function df3($OrderID)
   {
       $this->manger->Add("paying with ".$OrderID."\r\n");
   }
}
class Voda_Phone_cash extends PayWay
{
   public function df3($OrderID)
   {
       $this->manger->Add("paying with".$OrderID."\r\n");
   }
}
class VIsa extends PayWay
{
   public function df3($OrderID)
   {
       $this->manger->Add("paying with".$OrderID."\r\n");
   }
}
?>


