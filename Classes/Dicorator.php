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
function AddExtra($Name,$Price) {
    $File=new FileManger("Extras Type.txt");
    $File->Add($Name."~".$Price."\r\n");
}