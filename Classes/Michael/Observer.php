<?php
class Order
{
    protected  $ObserverArray = array();
    public function Attach($ObserverOBJ)
    {
        array_push($this->ObserverArray, $ObserverOBJ);
    }
    public function NotifyAll()
    {
        for ($i = 0; $i < count($this->GetObserverArray()); $i++) {
            $this->GetObserverArray()->Notify();
        }
    }
    function getObserverArray()
    {
        return $this->ObserverArray;
    }
    function setObserverArray($ObserverArray): self
    {
        $this->ObserverArray = $ObserverArray;
        return $this;
    }
}
abstract class Observer
{
    protected order $OrderOBJ;
    protected FileManger $FileManagerOBJ;
    public function __construct($OrderOBJ)
    {
        $this->setOrderOBJ($OrderOBJ);
        $this->OrderOBJ->Attach($this);
        $this->FileManagerOBJ = new FileManger("Notification.txt");
    }

    abstract function Notify();

    function setOrderOBJ(order $OrderOBJ): self
    {
        $this->OrderOBJ = $OrderOBJ;
        return $this;
    }
    function setFileManagerOBJ(FileManger $FileManagerOBJ): self
    {
        $this->FileManagerOBJ = $FileManagerOBJ;
        return $this;
    }
}
class SMS extends Observer
{
    public function Notify()
    {

        $this->FileManagerOBJ->Add("This Notification was sended by SMS");
    }
}
class Whatsapp extends Observer
{
    public function Notify()
    {
        $this->FileManagerOBJ->Add("This Notification was sended by Watsapp");
    }
}
class EMail extends Observer
{
    public function Notify()
    {
        $this->FileManagerOBJ->Add("This Notification was sended by Email");
    }
}
function AddInObserver($ObserverName)
{
    $FileManagerOBJ = new FileManger("Notification.txt");
    $line = ($ObserverName + "\n\r");
    $FileManagerOBJ->Add($line);
}
