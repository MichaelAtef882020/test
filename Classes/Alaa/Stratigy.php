<?php
include_once "Order Payments";
include_once "File Manager";
interface Ipay {
    public function Pay($OrderId);
}
class Fawry implements Ipay
{
    private FileManger $ObjFileManager;
    public function Pay($OrderId)
    {
        $this->ObjFileManager->Add("Pay Cash for $OrderId");
    }
}
class Cash implements Ipay
{

    private FileManger $ObjFileManager;
    public function Pay($OrderId)
    {
        $this->ObjFileManager->Add("Pay Cash for $OrderId");
    }
}
class Visa implements Ipay
{
    private FileManger $ObjFileManager;
    public function Pay($OrderId)
    {
        $this->ObjFileManager->Add("Pay Visa for $OrderId");
    }
}
function AddStratigie($FileName)
{
    $objFileManager= new FileManger("Payments Type");
    $line= ($FileName+"\r\n");
    $objFileManager->Add($line);
}