<?php
include_once "../FileMangerClass.php";
abstract class IPay {
    protected Data $FileManger;
    public function __construct() {
        $this->FileManger = new FileManger("Order Payments.txt");
    }
    public abstract function Pay($OrderId);
}
class Fawry extends IPay {
    public function Pay($OrderId)
    {
        $this->FileManger->Add("Paying FAWRY for order " . $OrderId . "\r\n");
    }
}
class Cash extends IPay {
    public function Pay($OrderId)
    {
        $this->FileManger->Add("Paying CASH for order " . $OrderId . "\r\n");
    }
}
class Visa extends IPay {
    public function Pay($OrderId)
    {
        $this->FileManger->Add("Paying VISA for order " . $OrderId . "\r\n");
    }
}
class PayPal extends IPay {
    public function Pay($OrderId)
    {
        $this->FileManger->Add("Paying PAYPAL for order " . $OrderId . "\r\n");
    }
}
function AddPayment(string $Name) {
    $File = new FileManger("Payments Type.txt");
    $File->Add($Name."\r\n");
}