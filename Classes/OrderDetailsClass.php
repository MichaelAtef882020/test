<?php
include_once "FileMangerClass.php";
include_once "PersonClass.php";
include_once "ProductClass.php";
include_once "OrderClass.php";

/*
    Product m4 hatb2a array hya oe number oe prices

    5od balk mn Order Id 



    Lazm t3ml static function 

    GetOrderDetail($Id1,$Id2)
    $Id1 da hoa order Id;
    $Id2 da hoa Product Id;
    return Object feh OrderDetail mo3yn mn 2lfile!!!

    Lazm t3ml function 2smha

    DeleteAll()
    hat4yl kol 2lorder details bnfs 2lId
    
*/
class Order_Details extends Person implements File {
    static public function GetOrderDetail($OId,$PId)
    { 
        $FileManger=new FileManger("Order Details.txt");
        $list=$FileManger->GetAllContent();
        for($i=0;$i<count($list);$i++)
        {
            $order_details=Order_Details::FromStringToObject($list[$i]);
            if($order_details->getOrderId()==$OId&&$order_details->getProduct_Id()==$PId)
            {
                return $order_details;
            }
        }
    }

    private ?int  $Product_Id;
    private ?int $Numbers;
    private ?float $Prices;
    private ?int $OrderId;
    private Data $FileManger;
    
    /**
     * @param int $input1 ProductId
     * @param int $input2 Number Of Product
     * @return mixed
     */

    function UpdateTotalForOrder($Price)
    {
        $Order = new order();
        $Order->SetInfoFromId($this->OrderId);
        $Order->setTotal($Order->getTotal() + $Price);
        $Order->UpdateTotal();
    }
    function Add($input1 = null, $input2 = null, $input3 = null, $input4 = null)
    {
        if($this->OrderId>0&&$this->Product_Id>0&&$this->Numbers>0)
        {
            $Product = new Product();
            $Product = $Product->Get_Info_Of_Product($this->Product_Id);
            $this->Prices = ($Product->getCost() * $this->Numbers);
            $this->UpdateTotalForOrder($this->Prices);
            $this->FileManger->Add($this->ToString());
            return 1;
        }
        else
        {
            return 0;

        }
    }


    public function ToString()
    {
        $String = "";
        $String .= $this->OrderId . '~' . $this->Product_Id . '~' . $this->Numbers . '~' . $this->Prices . "~\r\n";
        return $String;
    }
    /**
     *
     * @param mixed $input1
     * @param mixed $input2
     * @param mixed $input3
     * @param mixed $input4
     *
     * @return mixed
     */
    function Update($input1 = null, $input2 = null, $input3 = null, $input4 = null)
    {
        if($this->OrderId==0||$this->Product_Id==0)
        {
            return 0;
        }
        else
        {
            $order_Details=Order_Details::GetOrderDetail($this->OrderId,$this->Product_Id);
            if($this->Numbers==0)
            {
               return 0;
            }
            $product=Product::Get_Info_Of_Product($this->Product_Id);
            $this->Prices=($this->Numbers*$product->getCost());
            $this->FileManger->Update($order_Details->ToString(),$this->ToString());
            $diference=$this->Prices-$order_Details->getPrices();
            $this->UpdateTotalForOrder($diference);
        }
    }

    /**
     *
     * @param mixed $input1
     * @param mixed $input2
     * @param mixed $input3
     * @param mixed $input4
     *
     * @return mixed
     */
    static function FromStringToObject($Line)
    {
        $array=explode("~",$Line);
        $Order_Details= new Order_Details();
        $Order_Details->setOrderId(intval($array[0]));
        $Order_Details->setProduct_Id(intval($array[1]));
        $Order_Details->setNumbers(intval($array[2]));
        $Order_Details->setPrices(intval($array[3]));
        return $Order_Details;
    }
    function Searsh($input1 = null, $input2 = null, $input3 = null, $input4 = null)
    {
        $List=$this->FileManger->GetAllContent();
        for ($i=0; $i < count($List); $i++) {   
            $OrderDetails = Order_Details::FromStringToObject($List[$i]);
            if($this->OrderId != 0)
            {
                if($this->OrderId!=$OrderDetails->getOrderId())
                {
                    array_splice($List,$i,1);
                    $i--;
                }
            }
            if($this->Product_Id != 0)
            {
                if($this->Product_Id!=$OrderDetails->getProduct_Id())
                {
                    array_splice($List,$i,1);
                    $i--;
                }
            }
            if($this->Prices!=0)
            {
                if($this->Prices!=$OrderDetails->getPrices())
                {
                    array_splice($List,$i,1);
                    $i--;
                }
            }
            if($this->Numbers!=0)
            {
                if($this->Numbers!=$OrderDetails->getNumbers())
                {
                    array_splice($List,$i,1);
                    $i--;
                }
            }
        }
        $DisplayedList = [];
        $x = ["Order Id","Product Name","Number","Cost"];
        array_push($DisplayedList,$x);
        include_once "ProductClass.php";
        for ($i=0; $i < count($List); $i++) { 
            $OrderDetails = Order_Details::FromStringToObject($List[$i]);
            $Product = Product::Get_Info_Of_Product($OrderDetails->getProduct_Id());
            $Array = [$OrderDetails->getOrderId(),$Product->getName(),$OrderDetails->getNumbers(),$OrderDetails->getPrices(),""];
            array_push($DisplayedList,$Array);
        }
        return $DisplayedList;
    }

    /**
     *
     * @param mixed $input1
     * @param mixed $input2
     * @param mixed $input3
     * @param mixed $input4
     * @return mixed
     */

     // 8lt m7tag t3dyl
    function Delete($input1 = null, $input2 = null, $input3 = null, $input4 = null)
    {
        if ($this->OrderId == 0 || $this->Product_Id == 0) {
            return 0;
        }
        $OrderDetails = Order_Details::GetOrderDetail($this->OrderId,$this->Product_Id);
        $this->FileManger->Delete($OrderDetails->ToString());
        $Diff = $OrderDetails->getPrices()*-1;
        $this->UpdateTotalForOrder($Diff);
    }
    public function DeleteAll() 
    {
        if($this->OrderId == 0) return 0;
        while($Line = $this->FileManger->ValueIsThere($this->OrderId,0))
        {
            if($Line == null) break;
            $this->FileManger->Delete($Line);
        }
    }
    /**
     * 
     * @return ?int
     */
    function getOrderId(): ?int
    {
        return $this->OrderId;
    }

    /**
     * 
     * @param ?int $OrderId 
     * @return Order_Details
     */
    function setOrderId(?int $OrderId): int
    {
        if ($OrderId > 0) {
            $this->OrderId = $OrderId;
            return 1;
        }
        return 0;
    }
    /**
     * 
     * @return ?int
     */
    function getProduct_Id(): ?int
    {
        return $this->Product_Id;
    }

    /**
     * 
     * @param ?int $Product_Id 
     * @return Order_Details
     */
    function setProduct_Id(?int $Product_Id): int
    {
        if ($Product_Id > 0) {
            $this->Product_Id = $Product_Id;
            return 1;
        }
        return 0;
    }
    /**
     * 
     * @return ?int
     */
    function getNumbers(): ?int
    {
        return $this->Numbers;
    }

    /**
     * 
     * @param ?int $Numbers 
     * @return Order_Details
     */
    function setNumbers(?int $Numbers): int
    {
        if ($Numbers > 0) {
            $this->Numbers = $Numbers;
            return 1;
        }
        return 0;
    }
    /**
     * 
     * @return ?float
     */
    function getPrices(): ?float
    {
        return $this->Prices;
    }

    /**
     * 
     * @param ?float $Prices 
     * @return Order_Details
     */
    function setPrices(?float $Prices): int
    {
        if($Prices>0)
        {
          $this->Prices = $Prices;
          return 1;
        }
        return 0;
    }
	/**
	 */
	function __construct() {
        $this->OrderId = 0;
        $this->Product_Id = 0;
        $this->Numbers = 0;
        $this->Prices = 0;
        $this->FileManger = new FileManger("Order Details.txt");
	}
}
// order_id~product_id[0]~number[0]~price[0]~\r\n   -> 2esmaha to string
// lazem kolohom yeb2o mesh f null b function 2esmaha All is set 
