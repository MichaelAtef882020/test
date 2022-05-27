<?php

include_once "IDisplay.php";
class OrderDetailsDisplay implements IDisplay
{
    public function Display($type)
    {
        $Servis=Type::FromTypeGetServis($type);
        HTML::Header($type);
        $Input = new Input();
        $Input->setName("ProductId");
        $Texts = [];
        $Values = [];
        array_push($Texts,"Non");
        array_push($Values,"Non");
        $ProductFile = new FileManger("Product.txt");
        $List = $ProductFile->GetAllContent();
        for ($i = 0; $i < count($List); $i++) {
            $Line = explode('~', $List[$i]);
            $Id = $Line[0];
            array_push($Texts,$Line[2]);
            array_push($Values,$Id);
        }
        $Input->setName("ProductId");
        $Input->setText($Texts);
        $Input->setValue($Values);
        $Input->setType("select");
        $Inputs = [];
        array_push($Inputs,$Input);
        array_push($Inputs,new Input("NumberOfProduct","Number Of Product","number"));
        if(in_array("Order-Add", $Servis) ||in_array("Order-All", $Servis) )
        {
            array_push($Inputs,new Input("AddItem","Add Item","submit"));
            array_push($Inputs,new Input("Searsh","Search For An item","submit"));
        }
        if(in_array("Order-Search", $Servis))
        {
            array_push($Inputs,new Input("Searsh","Search For An item","submit"));
        }
        $Form = new Form();
        $Form->setActionFile("#");
        $Form->setInputs($Inputs);
        $Header = "<a href='Order.php'>Daily Activity</a>";
        $Form->setTitle("Daily Activity Details for ".$Header." ".$_GET["OrderId"]);
        $Form->DisplayForm();
        HTML::Footer();


    }
}



?>