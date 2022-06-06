<?php

include_once "../FileMangerClass.php";
abstract class noti
{
 protected order $Order;
 protected Data $manger;
 public  function __construct($Order)
 {
     $manger=new FileManger("Notification.txt");
     $this->Order=$Order;
     $this->Order->Attach($this);
 }
 public abstract  function notifiy();
 }
  class WATSAPP extends noti
  {
    protected $arrray =[];
        public function notifiy()
        {
          array_push($Array,$this->Order);
          $this->manger->Add("NOTIFIING BY".$this->Order);
        }
  }
  class gMAIL  extends noti
  {
    protected $arrray =[];
        public function notifiy()
        {
          array_push($Array,$this->Order);
          $this->manger->Add("NOTIFIING BY".$this->Order);
        }
  }
  class facebook extends noti
  {
    protected $arrray =[];
        public function notifiy()
        {
          array_push($Array,$this->Order);
          $this->manger->Add("NOTIFIING BY".$this->Order);
        }
  }
?>