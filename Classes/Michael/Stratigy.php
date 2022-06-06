<?php
include_once "Order Payments.txt";
include_once "FileMangerClass.php";

$object = new FileManger("Order Payments.txt");

interface Payment
{
    public function pay($OID);
}
class FawryPay implements Payment
{
    public function pay($OID)
    {
        $line = ($this->object->GetLastId() + 1) . '~' . $OID . '~' . "This Transaction is payed by Fawry" . '~' . "\r\n";
        $this->object->Add($line);
    }
}

class CashPay implements Payment
{
    public function pay($OID)
    {
        $line = ($this->object->GetLastId() + 1) . '~' . $OID . '~' . "This Transaction is payed by cash" . '~' . "\r\n";
        $this->object->Add($line);
    }
}

class VisaPay implements Payment
{
    public function pay($OID)
    {
        if ($OID >= 1) {
            $line = ($this->object->GetLastId() + 1) . '~' . $OID . '~' . "This Transaction is payed by Visa" . '~' . "\r\n";
            $this->object->Add($line);
        }
    }
}

function AddInStrategy($ObserverName)
{
    $FileManagerOBJ = new FileManger("Payments Type.txt");
    $line = ($ObserverName + "\n\r");
    $FileManagerOBJ->Add($line);
}
