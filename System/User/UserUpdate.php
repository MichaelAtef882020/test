<?php
include_once "../Classes.php";
$UserId = $_SESSION["UserId"];
$UserFile = new FileManger("User.txt");
$Line = $UserFile->ValueIsThere( $UserId, 0);
$UserNow = User::FromStringToObject($Line);
HTML::Header($UserNow->getType());
$User = User::FromStringToObject($UserFile->ValueIsThere($_GET["Id1"],0));
$Input = new Select();
$Texts = [];
$Values = [];
$UserTypeFile = new FileManger("User Type.txt");
$List = $UserTypeFile->GetAllContent();
for ($i = 0; $i < count($List); $i++) {
    $Array = explode('~', $List[$i]);
    $Type = $Array[1];
    $TypeId = $Array[0];
    if($User->getType() == $TypeId) {
        $Type = $Type."~";
    }
    array_push($Texts,$Type);
    array_push($Values,$TypeId);
}
$Input->setText($Texts);
$Input->setName("Type");
$Input->setValue($Values);
$Input->setType("select");
$Form = new Form();
$Form->setActionFile("#");
$Form->setTitle("Update User " . $User->getId() . "<br> Name: " . $User->getName());
$Inputs = [];
$Form->Attach($Input);
$Form->Attach(new Submit("Update","Set New Values","submit"));
$Form->DisplayForm();
HTML::Footer();
if($Form->InfoIsTaken())
{
    $UpdatedUser = new User();
    $UpdatedUser->setId($User->getId());
    $UpdatedUser->setType($_POST["Type"]);
    $UpdatedUser->Update();
    echo(" <script> location.replace('index.php'); </script>");
}