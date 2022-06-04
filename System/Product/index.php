<?php
include_once "../Classes.php";
    if(session_id() == '') {
        session_start();
    }
    $Id = $_SESSION["UserId"];
    $UserFile = new FileManger("User.txt");
    $Line = $UserFile->ValueIsThere($Id, 0);
    $User = User::FromStringToObject($Line);
    $Servis = $User->GetServices();
    HTML::Header($User->getType());
    $Form = new Form();
    $Form->setActionFile("#");
    $Form->setTitle("Activity");
    $Form->Attach(new Text("Id", "Activity Id", "number"));
    $Form->Attach(new Text("ProductName", "Activity Name", "text"));
    $Form->Attach(new Text("ProductPrice", "Activity Price", "number"));
    if (in_array("Product-All", $Servis)) {
        $Form->Attach(new Submit("Add", "Add", "submit"));
    }
    $Form->Attach(new Submit("Search", "Search", "submit"));
    $Form->DisplayForm();
    HTML::Footer();
    $Flag = 0;
    if (isset($_POST["Add"])) {
        if ($_POST["ProductName"] == "") exit("Product Name required!!");
        if ($_POST["ProductPrice"] == "") exit("Product Price required!!");
        $New_Product = new Product();
        $New_Product->setName($_POST["ProductName"]);
        $New_Product->setCost($_POST["ProductPrice"]);
        $New_Product->Add();
        unset($_POST["ProductName"]);
        unset($_POST["ProductPrice"]);
    } else if (isset($_POST["Search"])) {
        $Product = new Product();
        $Product->SetId(intval($_POST["Id"]));
        $Product->setName($_POST["ProductName"]);
        $Product->setCost(floatval($_POST["ProductPrice"]));
        $List = $Product->Searsh();
        if(in_array("Product-All", $Servis)) HTML::DisplayTable($List,2,"ProductUpdate.php","ProductDel.php");
        else HTML::DisplayTable($List);
        $Flag = 1;
        unset($_POST["Id"]);
        unset($_POST["ProductName"]);
        unset($_POST["ProductPrice"]);
    } if($Flag == 0)
    {
        $Product = new Product();
        $Product->SetId(0);
        $Product->setName("");
        $Product->setCost(0);
        $List = $Product->Searsh();
        if(in_array("Product-All", $Servis)) HTML::DisplayTable($List,2,"ProductUpdate.php","ProductDel.php");
        else HTML::DisplayTable($List);
    }