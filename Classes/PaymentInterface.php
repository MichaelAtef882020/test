<?php
include_once "../FileMangerClass.php";
abstract class IPay{
    protected Data $FileManger;
    public function __construct() {
        $this->FileManger = new FileManger("Order Payments.txt");
    }
    public abstract function Pay($OrderId);
}