<?php
interface IDecorator
{
    public function Total();
}
abstract class Extra implements IDecorator
{
    protected $Ref;
    public function __construct(IDecorator $Ref)
    {
        $this->Ref = $Ref;
    }
}
class Cheese extends Extra
{
    public function Total()
    {
        return 100 + $this->Ref->Total();
    }
}
class Milk extends Extra
{
    public function Total()
    {
        return  50 + $this->Ref->Total();
    }
}
class Desert extends Extra
{
    public function Total()
    {
        return 5 + $this->Ref->Total();
    }
}
class order extends Person implements IDecorator {
    private ?float $total = 0;
    private ?int $ClientId = 0;
    private ?string $date = "";
    private $File;
    protected $Observer =array(); 
    public function __construct() {
        $this->File = new FileManger("Order.txt");
    }
    public function Total()
    {
        return $this->total;
    }
}
function AddObserver($FileName)
{
    $objFileManager= new FileManger("DecoratorData.txt");
    $line= ($FileName+"\r\n");
    $objFileManager->Add($line);
}