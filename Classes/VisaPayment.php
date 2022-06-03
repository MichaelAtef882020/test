<?php
include_once "PaymentInterface.php";
class Visa extends IPay {
    public function Pay($OrderId) {
        $this->FileManger->Add("Paying VISA for order " . $OrderId . "\r\n");
    }
}
