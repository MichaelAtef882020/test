
<?php
include_once "Classes.php";
if(isset($_SESSION["UserId"]))
{
    $Id = $_SESSION["UserId"];
    $UserFile = new FileManger("User.txt");
    $Line = $UserFile->ValueIsThere($Id, 0);
    $User = User::FromStringToObject($Line);
    $Servis = $User->GetServices();
    HTML::Header($User->getType());
}
else
{
    HTML::Header("null");
}
$Form = new Form();
$Form->setActionFile("#");
$Form->setTitle("Sign Up");
$Form->Attach(new Text("UserName","Username","text"));
$Form->Attach(new Text("Password","Password","password"));
$Form->Attach(new Text("ConPass","Confirm password","password"));
$UserTypeFile = new FileManger("User Type.txt");
$List = $UserTypeFile->GetAllContent();
$Text = [];
$Value = [];
$Input = new Select();
$Input->setName("Type");
$Input->setType("select");
array_push($Text,"Null");
array_push($Value,"Null");
for ($i = 0; $i < count($List); $i++) {
    $Array = explode('~', $List[$i]);
    $Type = $Array[1];
    $TypeId = $Array[0];
    array_push($Text,$Type);
    array_push($Value,$TypeId);
}
$Input->setText($Text);
$Input->setValue($Value);
$Form->Attach($Input);
$Form->Attach(new Text("Date","Date of Birth","date"));
$Form->Attach(new Submit("submit","Sign Up","submit"));

$Form->DisplayForm();
HTML::Footer();
if (isset($_POST["submit"])) {
    if ($_POST["UserName"] == "") die("Name is Unset");
    $UserName = $_POST["UserName"];
    if ($_POST["Password"] == "") die("Password is Unset");
    $Password = $_POST["Password"];
    if ($_POST["Type"] == "") die("Type is Unset");
    $Type = $_POST["Type"];
    $Date = $_POST["Date"];
    $ConPass = $_POST["ConPass"];
    if ($ConPass == $Password) {
        $DateOfBirth = $Date;
        $UserFile = new FileManger("User.txt");
        $newUser = new User($UserFile->GetLastId() + 1, $Type, $UserName, $Password, $DateOfBirth);
        $newUser->Add();
        if(isset($_SESSION["UserId"]))
        {
            echo(" <script> location.replace('User.php'); </script>");
        }
        else
        {
            if(session_id() == '') {
                session_start();
            }
            $_SESSION["UserId"] = $newUser->getId();
            echo(" <script> location.replace('index.php'); </script>");
            exit();
        }
        
    } else {
        echo "Must be the same Password!!";
    }
}
