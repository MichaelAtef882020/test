<?php
include_once "PaymentInterface.php";
class Fawry extends IPay {
    public function Pay($OrderId) {
        $this->FileManger->Add("Paying FAWRY for order " . $OrderId . "\r\n");
    }
}
