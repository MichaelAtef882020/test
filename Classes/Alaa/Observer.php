<?php
include_once "OrderClass.php";
include_once "FileManagerClass.php";
include_once "OrderClass.php";
class Order {
    protected $Observer = array();
    public function Attach($OrderObj)
    {
        array_push($this->Observer, $OrderObj);
    }
    public function notifyAll()
    {
        foreach ($this->Observer as $obj) {
            $obj->notify();
        }
    }
}
abstract class Observer{
private order $OrderObj;
protected FileManger $objFileManager;
public function __constract($OrderObj)
{
$this->OrderObj=$OrderObj;
$this->OrderObj->Attach($this);

}
abstract function notify();
/**
* @param order $OrderObj
* @return Observer
*/
function setOrderObj(order $OrderObj): self {
$this->OrderObj = $OrderObj;
return $this;
}
/**
* @param FileManger $objFileManager
* @return Observer
*/
function setObjFileManager(FileManger $objFileManager): self {
$this->objFileManager = $objFileManager;
return $this;
}
}
class SMS extends Observer{
public function notify()
{
$IdOrder= $this->OrderObj->getId();
$this->objFileManager->Add("By SMS for order $IdOrder" );
}
}
class Whatsapp extends Observer{
public function notify()
{
$IdOrder= $this->OrderObj->getId();
$this->objFileManager->Add("By WhatsApp for order $IdOrder" );
}
}
class EMail extends Observer{
public function notify()
{
$IdOrder= $this->OrderObj->getId();
$this->objFileManager->Add("By Email for order $IdOrder" );
}
}