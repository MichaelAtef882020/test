<?php
include_once "Order Payments.txt";
include_once "FileMangerClass.php";

$object = new FileManger("Order Payments.txt");
class Order
{
    private $PaymentOBJ;
    private $OrderID;
    public function FinishPayment()
    {
        $this->PaymentOBJ->pay($this->OrderID);
    }
	function setPaymentOBJ($PaymentOBJ): self {
		$this->PaymentOBJ = $PaymentOBJ;
		return $this;
	}
	function getOrderID() {
		return $this->OrderID;
	}
	
	function setOrderID($OrderID): self {
		$this->OrderID = $OrderID;
		return $this;
	}
}

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
$count=0;
$count2=0;
$OrderOBJ=new order();
extract($_POST);
if(isset($Submit))
{
    if(isset($Fawry))
    {
        $count++;
        $count2=1;
        $OrderOBJ->setPayObj(new Fawry);
    }
    if(isset($Visa))
    {
        $count++;
        $count2=2;
        $OrderOBJ->setPayObj(new Visa);
    }
    if(isset($cash))
    {
        $count++;
        $count2=3;
        $OrderOBJ->setPayObj(new Cash);
    }
    if($count>1)
    {
        echo "YOU MUST CHOOSE ONE PAYMENT WAY ONLY";
    }
    else if($count==1&&$count2==1)
    {
        $OrderOBJ->FinishPayment();
    }
    else if($count==1&&$count2==2)
    {
        $OrderOBJ->FinishPayment();
    }
    else if($count==1&&$count2==3)
    {
        $OrderOBJ->FinishPayment();
    }

}
