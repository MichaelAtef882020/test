<?php

include_once "FileMangerCLass.php";
include_once "PersonClass.php";
include_once "TypeClass.php";
class Product extends Person implements File 
{
	private ?float $Cost;
	private Data $FileManger;
	function getCost(): float
	{
		return $this->Cost;
	}
	function setCost(?float $Cost): int
	{
		if ($Cost < 0) return 0;
		$this->Cost = $Cost;
		return 1;
	}
	function __construct(int $Id = null, float $Cost = null, string $Name = null)
	{
		if ($Id != null) {
			$this->setId($Id);
			$this->setName($Name);
			$this->setCost($Cost);
		}
		$this->FileManger = new FileManger("Product.txt");
	}
	public function ToString()
	{
		$String = $this->Id . "~" . $this->Cost  . "~" . $this->Name . "~\r\n";
		return $String;
	}
	public function AllIsSet()
	{
		if ($this->Id == null) return 0;
		if ($this->Name == null) return 0;
		if ($this->Cost == null) return 0;
		return 1;
	}
	function Add($input1 = null, $input2 = null, $input3 = null, $input4 = null)
	{
		if ($this->Name == null) return 0;
		if ($this->Cost == null) return 0;
		$Last_Id_In_file = $this->FileManger->GetLastId();
		$this->setId($Last_Id_In_file + 1);
		$isexist = $this->FileManger->ValueIsThere($this->Name, 2);
		if ($isexist == null) $this->FileManger->Add($this->ToString());
		else {
			echo "the product is already exist";
			return 0;
		}
		return 1;
	}
	static public function Get_Info_Of_Product($ID_Nom)
	{
		$FileManger=new FileManger("Product.txt");
		$isexist =$FileManger->ValueIsthere($ID_Nom, 0);
		if ($isexist) {
			$product = product::FromStringToObject($isexist);
			return $product;
		}
		return null;
	}
	static function FromStringToObject($Line)
	{
		$Array_Of_String = explode("~", $Line);
		$product = new Product(intval($Array_Of_String[0]), floatval($Array_Of_String[1]), $Array_Of_String[2]);
		return $product;
	}
	function Update($input1 = null, $input2 = null, $input3 = null, $input4 = null)
	{
		$Search_for_Id = $this->Id;
		$isexist = $this->FileManger->ValueIsThere($Search_for_Id, 0);
		$product = Product::FromStringToObject($isexist);
		if ($this->getCost() == 0) {
			$this->Cost = $product->getCost();
		}
		if ($this->getName() == "") {
			$this->Name = $product->getName();
		}
		$this->FileManger->Update($product->ToString(), $this->ToString());
	}
	function Searsh($input1 = null, $input2 = null, $input3 = null, $input4 = null)
	{
		$list = [];
		$Temp = ["Id", "Price", "Name"];
		array_push($list, $Temp);
		$array_of_lines = $this->FileManger->GetAllContent();
		if ($this->getCost() == 0 && $this->getName() == "" && $this->getId() == 0) {
			for ($i = 0; $i < count($array_of_lines); $i++) {
				$convert = explode("~", $array_of_lines[$i]);
				array_push($list, $convert);
			}
		}
		if ($this->getId() != 0) {
			for ($i = 0; $i < count($array_of_lines); $i++) {
				$isexist = $this->FileManger->ValueIsThere($this->Id, 0);
				$array = explode("~", $isexist);
				array_push($list, $array);
			}
		} else if ($this->getName() != "") {
			for ($i = 0; $i < count($array_of_lines); $i++) {
				$array = explode("~", $array_of_lines[$i]);
				if (str_contains($array[2], $this->Name)) {
					array_push($list, $array);
				}
			}
		} else if ($this->getCost() != 0) {
			for ($i = 0; $i < count($array_of_lines); $i++) {
				$array = explode("~", $array_of_lines[$i]);
				if (floatval($array[1]) == $this->Cost) {
					array_push($list, $array);
				}
			}
		}
		return $list;
	}
	function Delete($input1 = null, $input2 = null, $input3 = null, $input4 = null)
	{
		if ($this->getId() != 0) {
			$isexist = $this->FileManger->ValueIsThere($this->getId(), 0);
			$this->FileManger->Delete($isexist);
		}
	}
}