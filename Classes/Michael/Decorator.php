<?php

interface Decorator
{
    function CalculateTotal();
}
abstract class ExtraDecorator implements Decorator
{

    protected Decorator $Ref;
    public function __construct($NextRef)
    {
        $this->Ref = $NextRef;
    }
    function getRef(): Decorator
    {
        return $this->Ref;
    }
    function setRef(Decorator $Ref): self
    {
        $this->Ref = $Ref;
        return $this;
    }
}
class Cheese extends ExtraDecorator
{
    public function CalculateTotal()
    {
        return 100 + $this->Ref->CalculateTotal();
    }
}
class Milk extends ExtraDecorator
{
    public function CalculateTotal()
    {
        return 50 + $this->Ref->CalculateTotal();
    }
}
class Desert extends ExtraDecorator
{
    public function CalculateTotal()
    {
        return 300 + $this->Ref->CalculateTotal();
    }
}
class Order implements Decorator{
    private $Ref;
    private $Total;
    function CalculateTotal(){
        return $this->Total;
    }
	/**
	 * @param mixed $Ref 
	 * @return Order
	 */
	function setRef($Ref): self {
		$this->Ref = $Ref;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getTotal() {
		return $this->Total;
	}
	
	/**
	 * @param mixed $Total 
	 * @return Order
	 */
	function setTotal($Total): self {
		$this->Total = $Total;
		return $this;
	}
}
function AddInDecorator($DecoratorName)
{
    $FileManagerOBJ = new FileManger("DecoratorData.txt");
    $line = ($DecoratorName + "\n\r");
    $FileManagerOBJ->Add($line);
}