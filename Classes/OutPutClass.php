<?php  
if(session_id() == ''){
    session_start();
}
class Input 
{
    private $Name;
    private $Type;
    private $Text;
	private $Value;
    public function __construct($Name = "NULL",$Text = "NULL",$Type = "NULL",$Value = null) {
        if($Name == "NULL")
		{
			$this->Name = "NULL";
			$this->Type = "NULL";
			$this->Text = "NULL";
		}
		else
		{
			$this->Name = $Name;
			$this->Type = $Type;
			$this->Text = $Text;
			if($Value == null) unset($Value);
			else $this->Value = $Value;
		}
	}
	/**
	 * 
	 * @return mixed
	 */
	function getName() {
		return $this->Name;
	}
	
	/**
	 * 
	 * @param mixed $Name 
	 * @return Input
	 */
	function setName($Name): self {
		$this->Name = $Name;
		return $this;
	}
	/**
	 * 
	 * @return mixed
	 */
	function getType() {
		return $this->Type;
	}
	
	/**
	 * 
	 * @param mixed $Type 
	 * @return Input
	 */
	function setType($Type): self {
		$this->Type = $Type;
		return $this;
	}

    function AllIsSet()
    {
        if($this->Name!="NULL" && $this->Type != "NULL" && $this->Text != "NULL")
        {
            return 1;
        }
        return 0;
    }
    function DisplayInput()
    {
        if($this->AllIsSet() == 0) return 0;
        ?>
			<?php if($this->Type == "submit") {?>
				<div class="mt-5">
                  <button type="submit" name = <?php echo $this->Name?>>
                    <?php echo $this->Text?>
                  </button>
				</div>
            <?php } else if($this->Type == "select") {?>
				<div>
				<label>
				<?php echo $this->Name?>
				</label>
				<select name=<?php echo $this->Name ?>>
					<?php 
						for ($i=0; $i < count($this->Value); $i++) { 
							$Array = explode("~",$this->Text[$i]);
							if(count($Array) == 1 ){
							?>
							<option value=<?php echo $this->Value[$i]?>><?php echo $this->Text[$i] ?></option>
							<?php
							}
							else{
							?>
							<option value=<?php echo $this->Value[$i]?> selected><?php echo $Array[0] ?></option>
							<?php
							}
						}
					?>
				</select>
				</div>
			<?php } else {?>
				<div>
                <label>
                    <?php echo $this->Text?>
                    <input type=<?php echo $this->Type?> name = <?php echo $this->Name?> value = <?php if(isset($this->Value)) echo $this->Value?>>
                </label>
				</div>
			<?php }?>
        <?php
    }
	
	/**
	 * 
	 * @return mixed
	 */
	function getText() {
		return $this->Text;
	}
	
	/**
	 * 
	 * @param mixed $Text 
	 * @return Input
	 */
	function setText($Text): self {
		$this->Text = $Text;
		return $this;
	}
	/**
	 * 
	 * @return mixed
	 */
	function getValue() {
		return $this->Value;
	}
	
	/**
	 * 
	 * @param mixed $Value 
	 * @return Input
	 */
	function setValue($Value): self {
		$this->Value = $Value;
		return $this;
	}
}

// Form aggregate array Inputs
class Form 
{
    private $Title;
    private $ActionFile;
    private $Inputs;
    public function __construct() {
        $this->Title = "NULL";
        $this->ActionFile = "NULL";
        $this->Inputs = array();
	}
    public function AllIsSet()
    {
        if($this->Title == "NULL") return 0;
        if($this->ActionFile == "NULL") return 0;
        if(count($this->Inputs) == 0) return 0;
		return 1;
    }
    
    public function DisplayForm()
    {
        if($this->AllIsSet() == 0) return 0;
        ?>
		<section class="contact_section layout_padding">
        <div class="container">
			<h2 class="">
				<?php echo $this->Title?>
			</h2>
        </div>
		<div class="container">
      	<div class="row">
        <div class="col-md-6 ">
        <form action=<?php echo $this->ActionFile?> method="POST">
            <div class="contact_form-container">
              <div>
        <?php
		$flag = 0;
        for ($i=0; $i < count($this->Inputs); $i++) { 
			if($this->Inputs[$i]->getType() == "submit" && $flag == 0)
			{
				echo "<div class='row'>";
				$flag = 1;
			}
            $this->Inputs[$i]->DisplayInput();
        }
        ?>
		</div>
        </div>
        </div>
        </form>
		</div>
		</div>
		</div>
		</section>
        <?php
    }
	public function InfoIsTaken()
	{
		for ($i=0; $i < count($this->Inputs); $i++) { 
			if($this->Inputs[$i]->getType() == "submit")
			{
				if(isset($_POST[$this->Inputs[$i]->getName()]))
				{
					return $this->Inputs[$i]->getName();
				}
			}
		}
		return false;
	}
	/**
	 * 
	 * @return mixed
	 */
	function getTitle() {
		return $this->Title;
	}
	
	/**
	 * 
	 * @param mixed $Title 
	 * @return Form
	 */
	function setTitle($Title): self {
		$this->Title = $Title;
		return $this;
	}
	/**
	 * 
	 * @return mixed
	 */
	function getActionFile() {
		return $this->ActionFile;
	}
	
	/**
	 * 
	 * @param mixed $ActionFile 
	 * @return Form
	 */
	function setActionFile($ActionFile): self {
		$this->ActionFile = $ActionFile;
		return $this;
	}
	/**
	 * 
	 * @return mixed
	 */
	function getInputs() {
		return $this->Inputs;
	}
	
	/**
	 * 
	 * @param mixed $Inputs 
	 * @return Form
	 */
	function setInputs($Inputs): self {
		$this->Inputs = $Inputs;
		return $this;
	}
}

// Sealed class
class HTML {
	private function __construct() {
	}
	static public function Header($Type) {
		include_once "../Classes/TypeClass.php";
		$Servis = Type::FromTypeGetServis($Type);
		?>
		<head>
			<!-- Basic -->
			<meta charset="utf-8" />
			<meta http-equiv="X-UA-Compatible" content="IE=edge" />
			<!-- Mobile Metas -->
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
			<!-- Site Metas -->
			<meta name="keywords" content="" />
			<meta name="description" content="" />
			<meta name="author" content="" />

			<title>Orphanage Management System</title>

			<!-- slider stylesheet -->
			<link rel="stylesheet" type="text/css"
				href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

			<!-- bootstrap core css -->
			<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

			<!-- fonts style -->
			<link href="https://fonts.googleapis.com/css?family=Dosis:400,500|Poppins:400,600,700&display=swap" rel="stylesheet">
			<!-- Custom styles for this template -->
			<link href="css/style.css" rel="stylesheet" />
			<!-- responsive style -->
			<link href="css/responsive.css" rel="stylesheet" />
		</head>
		<body class="sub_page"> 
		<div class="hero_area">
      <!-- header section strats -->
      <header class="header_section">
        <div class="container-fluid">
          <nav class="navbar navbar-expand-lg custom_nav-container">
            <a class="navbar-brand" href="index.php">
              <span>
			  	Orphanage Management System
              </span>
            </a>

            <div class="navbar-collapse" id="">
              <div class="d-none d-lg-flex ml-auto flex-column flex-lg-row align-items-center">
                <ul class="navbar-nav">
				<?php if(isset($_SESSION["UserId"])) {?>
					<li class="nav-item">
                    <a class="nav-link" href="Logout.php">
                      <img src="images/login.png" alt="" />
                      <span>Logout</span></a>
                  </li>
				<?php }else{?>
                  <li class="nav-item">
                    <a class="nav-link" href="Login.php">
                      <img src="images/login.png" alt="" />
                      <span>Login</span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="SignUp.php">
                      <img src="images/signup.png" alt="" />
                      <span>Sign Up</span>
                    </a>
                  </li>
				<?php }?>
                </ul>
                <form class="form-inline my-2 mb-3 mb-lg-0  mr-5">
                </form>
              </div>
			  <?php if(isset($_SESSION["UserId"])) {?>
              <div class="custom_menu-btn">
                <button onclick="openNav()">
                  <span class="s-1">
                  </span>
                  <span class="s-2">
                  </span>
                  <span class="s-3">
                  </span>
                </button>
              </div>
				<div id="myNav" class="overlay">
					<div class="overlay-content">
					<a href="index.php">HOME</a>
					<?php if(!str_contains($Servis[0],"Product-Non")){ ?>
					<a href="Product.php">Activities</a>
					<?php }?>
					<?php if(!str_contains($Servis[1],"Order-Non")){ ?>
					<a href="Order.php">Daily Activities</a>
					<?php }?>
					<?php if(!str_contains($Servis[2],"User-Non")){?>
					<a href="User.php">User</a>
					<?php }?>
					<?php if($Type == "1"){?>
					<a href="Type.php">Type of Users</a>
					<?php }?>
					<a href="Profile.php">Profile</a>
                </div>
			  <?php }?>
              </div>
            </div>
          </nav>
        </div>
      </header>
      <!-- end header section -->
    </div>
		<?php
	}
	static public function Footer() {
		?>
		</section>
		<script>
			function openNav() {
			document.getElementById("myNav").classList.toggle("menu_width")
			document.querySelector(".custom_menu-btn").classList.toggle("menu_btn-style")
			}
		</script>
			</body>
		<?php
	}
	/**
	* 
	* @param $Type 1{User} 2{Product} 3{Order} 4{OrderDetails} 5{Types}
	*/
   static public function DisplayTable(array $List, int $Type = 0,string $UpdateLink = "null",string $DeleteLink = "null")
   {
	   echo "<center>";
	   $Table = "box-shadow: 0 0 20px rgba(0,0,0,0.15); border-collapse: collapse; border-radius: 10px 10px 0 0; overflow: hidden; margin: 25px 0; font-size: 0.9em; font-family: sans-serif; min-width: 400px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);";
	   $TableHead = "background-color: #a0e711; color: #ffffff; text-align: left; padding: 12px 15px;";
	   echo "<table style='$Table'>";
	   for ($i = 0; $i < count($List); $i++) {
		   if($i == 0) echo "<tr style='$TableHead'>";
		   else if($i == count($List) - 1) echo "<tr style='border-bottom: 2px solid #a0e711'>";
		   else echo "<tr style='border-bottom: 1px solid #dddddd'>";
		   for ($j = 0; $j < ($i>0?count($List[$i])-1:count($List[$i])); $j++) {
			   echo "<th style='padding: 12px 15px; '>" . $List[$i][$j] . "</th>";
		   }
		   $Id1 = $List[$i][0];
		   $Id2 = $List[$i][1];
		   if($Type == 3)
		   {
				if($i != 0)
				{

					echo "<th style='padding: 12px 15px;'><a href='PrintInvoice.php?OrderId=$Id1'>Print</a></th>";
					echo "<th style='padding: 12px 15px;'><a href='OrderDetails.php?OrderId=$Id1'>Order Details</a></th>";
				}
				else
				{
					echo "<th style='padding: 12px 15px;' >Print</th>";
					echo "<th style='padding: 12px 15px;' >Order Details</th>";
				}
		   }
		   if($Type!=0)
			   if($i!=0)
				   if($Type == 4)
				   {
					   if($UpdateLink!="null") echo "<th style='padding: 12px 15px;' ><a href='$UpdateLink?Id1=$Id1&Id2=$Id2'>Update</a></th>";
					   if($DeleteLink!="null") echo "<th style='padding: 12px 15px;' ><a href='$DeleteLink?Id1=$Id1&Id2=$Id2'>Delete</a></th>";
				   }
				   else{
					   if($UpdateLink!="null") echo "<th style='padding: 12px 15px;' ><a href='$UpdateLink?Id1=$Id1'>Update</a></th>";
					   if($DeleteLink!="null") echo "<th style='padding: 12px 15px;' ><a href='$DeleteLink?Id1=$Id1'>Delete</a></th>";
				   }
			   else
			   {
				if($UpdateLink!="null") echo "<th style='padding: 12px 15px;' >Update</th>";
				if($DeleteLink!="null")  echo "<th style='padding: 12px 15px;' >Delete</th>";
			   }
		   echo "</tr>";
	   }
	   echo "</table>";
	   echo "</center>";
   }
}

?>