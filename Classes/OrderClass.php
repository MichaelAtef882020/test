<?php
include_once "FileMangerClass.php";
include_once "PersonClass.php";
include_once "OrderDetailsClass.php";
class order extends Person implements File {
	private ?float $total = 0;
	private ?int $ClientId = 0;
	private ?string $date = "";
	private $File;
	public function __construct() {
		$this->File = new FileManger("Order.txt");
	}
	public function AllIsSet() {
		if($this->Id==null) return 0;
		if($this->ClientId==0) return 0;
		if($this->date=="") return 0;
		return 1;
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
    public function ToString() {
		$String = $this->Id."~".$this->ClientId."~".$this->date."~".$this->total."~\r\n";
		return $String;
	}
	function Add($input1 = null, $input2 = null, $input3 = null, $input4 = null) {

        $LastId= $this->File->GetLastId();
        $this->setId($LastId+1);
		if($this->AllIsSet())
        {
            $IsOrderExist=$this->File->ValueIsThere($this->Id,0);
            if($IsOrderExist==null)
            {
				$this->total=0;
                $this->File->FileAdd($this->ToString());
            }
            else{
                echo"the order is exist";
                return 0;
            }
            return 1;
        }
        else{
            return 0;
        }
	}
    static function FromStringToObject($string)
	{
       $Array_Of_String=explode("~",$string);
	   $Order=new order();
	   $Order->setId(intval($Array_Of_String[0]));
	   $Order->setClientId(intval($Array_Of_String[1]));
	   $Order->setDate($Array_Of_String[2]);
	   $Order->setTotal($Array_Of_String[3]);
	   return $Order;
	}
	public function SetInfoFromId($Id)
	{
		$Order = order::FromStringToObject($this->File->ValueIsThere($Id,0));
		$this->setId($Order->getId());
		$this->setClientId($Order->getClientId());
		$this->setDate($Order->getDate());
		$this->setTotal($Order->getTotal());
		$this->setName($Order->getName());
	}
	function Update($input1 = null, $input2 = null, $input3 = null, $input4 = null) {
		if($this->Id == 0) return 0;
		$OldOrder = order::FromStringToObject($this->File->ValueIsThere($this->Id,0));
		if($this->ClientId == 0) $this->ClientId = $OldOrder->getClientId();
		if($this->date == "") $this->date = $OldOrder->getDate();
		if($this->total == 0) $this->total = $OldOrder->getTotal();
		$this->File->FileUpdate($OldOrder->ToString(),$this->ToString());
	}
	public function UpdateTotal()
	{
		if($this->Id == 0) return 0;
		$OldOrder = order::FromStringToObject($this->File->ValueIsThere($this->Id,0));
		$this->ClientId = $OldOrder->getClientId();
		$this->date = $OldOrder->getDate();
		$this->File->FileUpdate($OldOrder->ToString(),$this->ToString());
	}
	function Searsh($input1 = null, $input2 = null, $input3 = null, $input4 = null) {
		$List = $this->File->GetAllContent();
		for ($i=0; $i < count($List); $i++) { 
			$Order = order::FromStringToObject($List[$i]);
			if($this->Id != 0)
			{
				if($this->Id!=$Order->getId())
				{
					array_splice($List,$i,1);
                    $i--;
				}
			}
			if($this->date != "")
			{
				if($this->date!=$Order->getDate())
				{
					array_splice($List,$i,1);
                    $i--;
				}
			}
			if($this->ClientId!=0)
			{
				if($this->ClientId!=$Order->getClientId())
				{
					array_splice($List,$i,1);
                    $i--;
				}
			}
			if($this->total!=0)
			{
				if($this->total!=$Order->getTotal())
				{
					array_splice($List,$i,1);
                    $i--;
				}
			}
		}
		$DisplayedList = [];
		$x = ["Order Id","Clint Id","Date","Total"];
		array_push($DisplayedList,$x);
		for ($i=0; $i < count($List); $i++) { 
			$Order = order::FromStringToObject($List[$i]);
			$Array = [$Order->getId(),$Order->getClientId(),$Order->getDate(),$Order->getTotal(),""];
			array_push($DisplayedList,$Array);
		}
		return $DisplayedList;
	}
	function Delete($input1 = null, $input2 = null, $input3 = null, $input4 = null) {
		if($this->Id == 0) return 0;
		$this->File->FileDelete($this->File->ValueIsThere($this->Id,0));
		$OrderDetails = new Order_Details();
		$OrderDetails->setId($this->Id);
		$OrderDetails->DeleteAll();
		return 1;
	}
	
	function getDate(): string {
		return $this->date;
	}
	
	function setDate(string $date): int  {
		if($date <= 0) return 0;
		$this->date = $date;
		return 1;
	}

	function getClientId(): int {
		return $this->ClientId;
	}
	

	function setClientId(int $ClientId): int  {
		if($ClientId <= 0) return 0;
		$this->ClientId = $ClientId;
		return 1;
	}

	function getTotal(): ?float {
		return $this->total;
	}
	
	function setTotal(?float $total): self {
		$this->total = $total;
		return $this;
	}
}