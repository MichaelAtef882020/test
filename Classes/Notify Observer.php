<?php
include_once "OrderClass.php";
include_once "FileManagerClass.php";
include_once "OrderClass.php";
abstract class Observer
{
    protected order $OrderObj;
    protected FileManger $objFileManager;
    public function __construct(order $OrderObj) {
        $this->OrderObj = $OrderObj;
        $this->OrderObj->Attach($this);
        $this->objFileManager = new FileManger("Notification.txt");
    }
    abstract function notify();
    function setOrderObj(order $OrderObj): self {
        $this->OrderObj = $OrderObj;
        return $this;
    }
    function setObjFileManager(FileManger $objFileManager): self {
        $this->objFileManager = $objFileManager;
        return $this;
    }
}
class SMS extends Observer
{
    public function notify()
    {
        $IdOrder = $this->OrderObj->getId();
        $this->objFileManager->Add("Notify By SMS for order $IdOrder\r\n");
    }
}
class Whatsapp extends Observer
{
    public function notify()
    {
        $IdOrder = $this->OrderObj->getId();
        $this->objFileManager->Add("Notify By WhatsApp for order $IdOrder\r\n");
    }
}
class EMail extends Observer
{
    public function notify()
    {
        $IdOrder = $this->OrderObj->getId();
        $this->objFileManager->Add("Notify By Email for order $IdOrder\r\n");
    }
}
function AddNotify($Name) {
    $File = new FileManger("Notify Type.txt");
    $File->Add($Name."\r\n");
}