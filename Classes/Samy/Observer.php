<?php
abstract class  notify
{
    private $mess;

    public function __construct($mess)
    {
        $this->mess = $mess;
        $this->mess->set_array($this);
    }
    public abstract function message($Nof);
}
class ay
{
    public  $array = [];
    public function set_array(notify $ref)
    {
        array_push($this->array, $ref);
        return $this;
    }
    public function notify()
    {
        // foreach ($this->array as $var) {
        //  $var->message();


        //} 
        for ($i = 0; $i < count($this->array); $i++); {
            $this->array[$i]->message();
        }
    }
}
class email extends notify
{
    public function message($Nof)
    {
        $this->fileManger->Add("It notifay at e-mail" . $Nof . "\r\n");
    }
}
class phone extends notify
{
    public function message($Nof)
    {
        $this->filemanager->Add("notify on phone" . $Nof . "\r\n");
    }
}
class SMS extends notify
{
    public function message($Nof)
    {
        $this->filemanager->Add("notify by SMS" . $Nof . "\r\n");
    }
}