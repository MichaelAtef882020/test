<?php
include_once "PaymentInterface.php";
class Cash extends IPay {
    public function Pay($OrderId) {
        $this->FileManger->Add("Paying CASH for order ".$OrderId."\r\n");
    }
}