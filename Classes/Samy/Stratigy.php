<?php
abstract class paymaent
{
    private order $Order;
    public function __construct()
    {
        $this->FileManger = new FileManger("Order Payments.txt");
    }
    public abstract function pay($OrderId);
}
class order
{
    private paymaent $ref;
    function setref(paymaent $ref)
    {
        $this->ref = $ref;
        return $this;
    }
    public function performpayment()
    {

        if ($this->ref != null) {
            $this->ref->pay(OrderId);
        }
    }
}
class cash extends paymaent
{
    public function pay($OrderId)
    {
        $this->FileManger->Add("Paying CASH for order " . $OrderId . "\r\n");
    }
}
class fawry extends paymaent
{
    public function pay($OrderId)
    {
        $this->FileManger->Add("Paying CASH for order " . $OrderId . "\r\n");
    }
}
class Visa extends paymaent
{
    public function pay($OrderId)
    {
        $this->FileManger->Add("Paying CASH for order " . $OrderId . "\r\n");
    }
}
class paypal extends paymaent
{
    public function pay($OrderId)
    {
        $this->FileManger->Add("Paying CASH for order " . $OrderId . "\r\n");
    }
}