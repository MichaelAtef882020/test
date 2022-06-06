<?php

interface  Extra
{
    public function gettotal();
}
abstract class i implements Extra
{
    protected Extra $Price;
    public function counstrto(Extra $var)
    {
        $this->Price = $var;
    }
    function setprice(Extra $price): self
    {
        $this->price = $price;
        return $this;
    }
}
class maindish extends i
{
    public function gettotal()
    {
        return 30;
    }
}
class cofee extends i
{
    public function gettotal()
    {
        return 30;
    }
}
class cheese extends i
{
    public function gettotal()
    {
        return 10 + $this->Price->gettotal();
    }
}
class Desart extends i
{
    public function gettotal()
    {
        return 10 + $this->Price->gettotal();
    }
}
class cofee extends i
{
    public function gettotal()
    {
        return 10 + $this->price->gettotal();
    }
}
