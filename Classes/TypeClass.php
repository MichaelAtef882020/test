<?php
include_once "PersonClass.php";
include_once "FileMangerClass.php";
class Type extends Person implements File {
    private $Product;
    private $Order;
    private $User;
    private $FileType;
    private Data $FileMenu;
    public function __construct($Id = null,$Name = null,$Product=null,$Order=null,$User=null) {
        if($Id!=null) $this->setId($Id);
        else $this->Id = 0;
        if($Name!=null) $this->setName($Name);
        else $this->Name = "";
        if($Product!=null) $this->setProduct($Product);
        else $this->Product = "Product-Non";
        if($Order!=null) $this->setOrder($Order);
        else $this->Order = "Order-Non";
        if($User!=null) $this->setUser($User);
        else $this->User = "User-Non";
        $this->FileType = new FileManger("User Type.txt");
        $this->FileMenu = new FileManger("User Type Menu.txt");
    }
	/**
	 * 
	 * @return mixed
	 */
	function getProduct() {
		return $this->Product;
	}
	static function FromTypeGetServis(string $IdType) {
        $Servis = [];
        $File = new FileManger("User Type Menu.txt");
        $List = $File->GetAllContent();
        for ($i = 0; $i < count($List); $i++) {
            $array = explode('~', $List[$i]);
            if ($array[0] == $IdType) {
                for ($j = 1; $j < count($array); $j++) {
                    array_push($Servis, $array[$j]);
                }
            }
        }
        return $Servis;
    }
	/**
	 * 
	 * @param mixed $Product 
	 * @return Type
	 */
	function setProduct($Product): self {
		$this->Product = "Product-".$Product;
		return $this;
	}
	/**
	 * 
	 * @return mixed
	 */
	function getOrder() {
		return $this->Order;
	}
	
	/**
	 * 
	 * @param mixed $Order 
	 * @return Type
	 */
	function setOrder($Order): self {
		$this->Order = "Order-".$Order;
		return $this;
	}
	/**
	 * 
	 * @return mixed
	 */
	function getUser() {
		return $this->User;
	}
	
	/**
	 * 
	 * @param mixed $User 
	 * @return Type
	 */
	function setUser($User): self {
		$this->User = "User-".$User;
		return $this;
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
	function Add($input1 = null, $input2 = null, $input3 = null, $input4 = null) {
        $IsExist = $this->FileType->ValueIsThere($this->Name,1);
        if($IsExist) die("User Type Name already exists!!");
        if($this->Product == "Product-Non"&&$this->Order == "Order-Non"&&$this->User == "User-Non")
            die("You must choose his features");
        $this->Id =  $this->FileType->GetLastId() + 1;
        $this->FileType->Add($this->Id.'~'.$this->Name."~\r\n");
        $this->FileMenu->Add($this->ToString());
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
	function Update($input1 = null, $input2 = null, $input3 = null, $input4 = null) {
        if($this->Id == "0") return;
        $OldType = Type::FromStringToObject($this->FileMenu->ValueIsThere($this->Id,0));
        $OldType->setName(explode("~",$this->FileType->ValueIsThere($this->Id,0))[1]);
        if($this->Name=="") $this->Name = $OldType->getName();
        $this->FileMenu->Update($this->FileMenu->ValueIsThere($this->Id,0),$this->ToString());
        $this->FileType->Update($this->FileType->ValueIsThere($this->Id,0),$this->Id."~".$this->Name."~\r\n");
    }
	
    static function GetTypeName($Id) {
        $FileManger = new FileManger("User Type.txt");
        return explode("~",$FileManger->ValueIsThere($Id,0))[1];
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
    public function DisplayedString() {
        $String = $this->getId()."~".$this->getName()."~".$this->getProduct()."~".$this->getOrder()."~".$this->getUser()."~";
        return $String;
    }
	function Searsh($input1 = null, $input2 = null, $input3 = null, $input4 = null) {
        $List = $this->FileMenu->GetAllContent();

        for ($i=0; $i < count($List); $i++) { 
            $Type = Type::FromStringToObject($List[$i]);
            $Type->setName(Type::GetTypeName($Type->getId()));
            if($this->Id != 0)
            {
                if($this->Id!=$Type->getId())
                {
                    array_splice($List,$i,1);
                    $i--;
                }
            }
            if($this->Name != "")
            {
                if($this->Name!=$Type->getName())
                {
                    array_splice($List,$i,1);
                    $i--;
                }
            }
            if($this->Product != "Product-Non")
            {
                if($this->Product!=$Type->getProduct())
                {
                    array_splice($List,$i,1);
                    $i--;
                }
            }
            if($this->Order != "Order-Non")
            {
                if($this->Order!=$Type->getOrder())
                {
                    array_splice($List,$i,1);
                    $i--;
                }
            }
            if($this->User != "User-Non")
            {
                if($this->User!=$Type->getUser())
                {
                    array_splice($List,$i,1);
                    $i--;
                }
            }
        }

        $Temp = ["Type Id","Name","Product Mode","Order Mode","User Mode"];
        $Display = [];
        array_push($Display,$Temp);
        for ($i=0; $i < count($List); $i++) {
            $Type = Type::FromStringToObject($List[$i]);
            $Type->setName(Type::GetTypeName($Type->getId()));
            $Array = [$Type->getId(),$Type->getName(),$Type->getProduct(),$Type->getOrder(),$Type->getUser(),""];
            array_push($Display,$Array);
        }

        return $Display;
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
	function Delete($input1 = null, $input2 = null, $input3 = null, $input4 = null) {
        if($this->Id == "0") return;
        if($this->Id == "1" || $this->Id == "3") {
            echo("Admin and CLint Cannot be updated");
            exit();
        }
        if($IsExist = $this->FileType->ValueIsThere($this->Id, 0)) {
            $Array = explode('~',$IsExist);
            $Id =$Array[0];
            $this->FileType->Delete($IsExist);
            $IsExist = $this->FileMenu->ValueIsThere($Id, 0);
            $this->FileMenu->Delete($IsExist);
            $UserFile = new FileManger("User.txt");
            while($IsExist = $UserFile->ValueIsThere($Id,1)) {
                $UserFile->Delete($IsExist);
            }
        }
	}
	/**
	 *
	 * @return mixed
	 */
	function ToString() {
        $String = $this->Id."~".$this->Product."~".$this->Order."~".$this->User."~\r\n";
        return $String;
	}
    
    static public function FromStringToObject(String $Line) {
        $Array = explode('~',$Line);
        $Product = explode('-',$Array[1])[1];
        $Order = explode('-',$Array[2])[1];
        $User = explode('-',$Array[3])[1];
        $Type = new Type($Array[0],null,$Product,$Order,$User);
        return $Type;
    }
}