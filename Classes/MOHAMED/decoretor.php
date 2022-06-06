<?php

use JetBrains\PhpStorm\Internal\ReturnTypeContract;

    include_once "../FileMangerClass.php";


interface price
{

    public function Cost();

}

class order implements price
{
    private $total;
    public function Cost()
    {
       return $this->total;
    }
}

abstract class deco implements price
{

  protected price $price;    
  protected FileManger $Manger;
  
  public  function __construct($price)
  {
      $Manger = new FileManger("Order Extras.txt");
      $this->price=$price;
  }
}

class add1 extends deco
{ 
    protected order $porder;   
   
    public  function Cost()
    {
       return 5+$this->price->Cost();
    }
    
}
class add2 extends deco
{ 
    protected order $porder;   
   
    public  function Cost()
    {
       return 10+$this->price->Cost();
    }
}
class add3 extends deco
{ 
    protected order $porder;   
   
    public  function Cost()
    {
       return 15+$this->price->Cost();
    }
}
?>