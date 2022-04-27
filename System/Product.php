<?php
    include_once "../Classes/OutPutClass.php";
    include_once "../Classes/FileMangerClass.php";
    if(session_id() == '') {
        session_start();
    }
    include_once "../Classes/UserClass.php";
    $Id = $_SESSION["UserId"];
    $UserFile = new FileManger("User.txt");
    $Line = $UserFile->ValueIsThere($Id, 0);
    $User = User::FromStringToObject($Line);
    $Servis = $User->GetServices();
    HTML::Header($User->getType());
    $Inputs = [];
    array_push($Inputs,new Input("Id","Activity Id","number"));
    array_push($Inputs,new Input("ProductName","Activity Name","text"));
    array_push($Inputs,new Input("ProductPrice","Activity Price","number"));
    if (in_array("Product-All", $Servis))
    {
        array_push($Inputs,new Input("Add","Add","submit"));
        array_push($Inputs,new Input("Update","Update","submit"));
        array_push($Inputs,new Input("Delete","Delete","submit"));
    }
    array_push($Inputs,new Input("Search","Search","submit"));
    $Form = new Form();
    $Form->setActionFile("#");
    $Form->setInputs($Inputs);
    $Form->setTitle("Activity");
    $Form->DisplayForm();
    HTML::Footer();
    $Flag = 0;
    include_once "../Classes/ProductClass.php";
    if (isset($_POST["Add"])) {
        if ($_POST["ProductName"] == "") exit("Product Name required!!");
        if ($_POST["ProductPrice"] == "") exit("Product Price required!!");
        $New_Product = new Product();
        $New_Product->setName($_POST["ProductName"]);
        $New_Product->setCost($_POST["ProductPrice"]);
        $New_Product->Add();
        unset($_POST["ProductName"]);
        unset($_POST["ProductPrice"]);
    } else if (isset($_POST["Update"])) {
        if ($_POST["Id"] == "") exit("Product Id required!!");
        $Product = new Product();
        $Product->SetId($_POST["Id"]);
        $Product->setName($_POST["ProductName"]);
        $Product->setCost(floatval($_POST["ProductPrice"]));
        $Product->Update();
        unset($_POST["Id"]);
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
    } else if (isset($_POST["Delete"])) {
        $Product = new Product();
        if($_POST["Id"] == "") exit("Id is required!!");
        $Product->SetId(intval($_POST["Id"]));
        $Product->Delete();
        unset($_POST["Id"]);
        unset($_POST["ProductName"]);
        unset($_POST["ProductPrice"]);
    }
    if($Flag == 0)
    {
        $Product = new Product();
        $Product->SetId(0);
        $Product->setName("");
        $Product->setCost(0);
        $List = $Product->Searsh();
        if(in_array("Product-All", $Servis)) HTML::DisplayTable($List,2,"ProductUpdate.php","ProductDel.php");
        else HTML::DisplayTable($List);
    }
