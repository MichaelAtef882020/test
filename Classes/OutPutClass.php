<?php
if (session_id() == '') {
	session_start();
}
abstract class IDisplayInput
{
	protected $Name;
	protected $Type;
	protected $Text;
	protected $Value;
	public function __construct($Name = "NULL", $Text = "NULL", $Type = "NULL", $Value = null)
	{
		if ($Name == "NULL") {
			$this->Name = "NULL";
			$this->Type = "NULL";
			$this->Text = "NULL";
		} else {
			$this->Name = $Name;
			$this->Type = $Type;
			$this->Text = $Text;
			if ($Value == null) unset($Value);
			else $this->Value = $Value;
		}
	}
	public abstract function Display();
	function getName()
	{
		return $this->Name;
	}
	function setName($Name): self
	{
		$this->Name = $Name;
		return $this;
	}
	function getType()
	{
		return $this->Type;
	}
	function setType($Type): self
	{
		$this->Type = $Type;
		return $this;
	}
	function AllIsSet()
	{
		if ($this->Name != "NULL" && $this->Type != "NULL" && $this->Text != "NULL") return 1;
		return 0;
	}
	function getText()
	{
		return $this->Text;
	}
	function setText($Text): self
	{
		$this->Text = $Text;
		return $this;
	}
	function getValue()
	{
		return $this->Value;
	}
	function setValue($Value): self
	{
		$this->Value = $Value;
		return $this;
	}
}
class Submit extends IDisplayInput
{
	public function __construct($Name = "NULL", $Text = "NULL", $Type = "NULL", $Value = null)
	{
		$this->Type = "submit";
		if ($Name == "NULL") {
			$this->Name = "NULL";
			$this->Type = "NULL";
			$this->Text = "NULL";
		} else {
			$this->Name = $Name;
			$this->Type = $Type;
			$this->Text = $Text;
			if ($Value == null) unset($Value);
			else $this->Value = $Value;
		}
	}
	function Display()
	{
		if (isset($this->Name) && isset($this->Text)) { ?>
			<div class="mt-5">
				<button type="submit" name=<?php echo $this->Name ?>>
					<?php echo $this->Text ?>
				</button>
			</div>
		<?php	}
	}
}
class Select extends IDisplayInput
{
	function Display()
	{ ?>
		<div>
			<label>
				<?php echo $this->Name ?>
			</label>
			<select name=<?php echo $this->Name ?>>
				<?php
				for ($i = 0; $i < count($this->Value); $i++) {
					$Array = explode("~", $this->Text[$i]);
					if (count($Array) == 1) {
				?>
						<option value=<?php echo $this->Value[$i] ?>><?php echo $this->Text[$i] ?></option>
					<?php
					} else {
					?>
						<option value=<?php echo $this->Value[$i] ?> selected><?php echo $Array[0] ?></option>
				<?php
					}
				}
				?>
			</select>
		</div>
	<?php }
}
class CheckBox extends IDisplayInput
{
	public function Display()
	{ ?>
		<label class="Check"><?php echo $this->Text ?>
			<input type="checkbox" name="<?php echo $this->Name ?>" value="<?php echo $this->Value ?>">
			<span class="checkmark"></span></label>
	<?php }
}
class Text extends IDisplayInput
{
	public function Display()
	{ ?>
		<div>
			<label>
				<?php echo $this->Text ?>
				<input type=<?php echo $this->Type ?> name=<?php echo $this->Name ?> value=<?php if (isset($this->Value)) echo $this->Value ?>>
			</label>
		</div>
	<?php }
}
// Form aggregate array Inputs
class Form
{
	private $Title;
	private $ActionFile;
	private $Inputs;
	public function __construct()
	{
		$this->Title = "NULL";
		$this->ActionFile = "NULL";
		$this->Inputs = array();
	}
	public function AllIsSet()
	{
		if ($this->Title == "NULL") return 0;
		if ($this->ActionFile == "NULL") return 0;
		if (count($this->Inputs) == 0) return 0;
		return 1;
	}
	public function Attach(IDisplayInput $var)
	{
		array_push($this->Inputs, $var);
	}
	public function DisplayForm()
	{
		if ($this->AllIsSet() == 0) return 0;
	?>
		<section class="contact_section layout_padding">
			<div class="container">
				<h2 class="">
					<?php echo $this->Title ?>
				</h2>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-6 ">
						<form action=<?php echo $this->ActionFile ?> method="POST">
							<div class="contact_form-container">
								<div>
									<style>
										/* The container */
										.Check {
											display: block;
											position: relative;
											padding-left: 35px;
											margin-bottom: 12px;
											cursor: pointer;
											font-size: 22px;
											-webkit-user-select: none;
											-moz-user-select: none;
											-ms-user-select: none;
											user-select: none;
										}

										/* Hide the browser's default checkbox */
										.Check input {
											position: absolute;
											opacity: 0;
											cursor: pointer;
											height: 0;
											width: 0;
										}

										/* Create a custom checkbox */
										.checkmark {
											position: absolute;
											top: 0;
											left: 0;
											height: 25px;
											width: 25px;
											background-color: #eee;
										}

										/* On mouse-over, add a grey background color */
										.Check:hover input~.checkmark {
											background-color: #ccc;
										}

										/* When the checkbox is checked, add a blue background */
										.Check input:checked~.checkmark {
											background-color: #2196F3;
										}

										/* Create the checkmark/indicator (hidden when not checked) */
										.checkmark:after {
											content: "";
											position: absolute;
											display: none;
										}

										/* Show the checkmark when checked */
										.Check input:checked~.checkmark:after {
											display: block;
										}

										/* Style the checkmark/indicator */
										.Check .checkmark:after {
											left: 9px;
											top: 5px;
											width: 5px;
											height: 10px;
											border: solid white;
											border-width: 0 3px 3px 0;
											-webkit-transform: rotate(45deg);
											-ms-transform: rotate(45deg);
											transform: rotate(45deg);
										}
									</style>
									<?php
									$flag = 0;
									for ($i = 0; $i < count($this->Inputs); $i++) {
										if ($this->Inputs[$i]->getType() == "submit" && $flag == 0) {
											echo "<div class='row'>";
											$flag = 1;
										}
										$this->Inputs[$i]->Display();
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
		for ($i = 0; $i < count($this->Inputs); $i++) {
			if ($this->Inputs[$i]->getType() == "submit") {
				if (isset($_POST[$this->Inputs[$i]->getName()])) {
					return $this->Inputs[$i]->getName();
				}
			}
		}
		return false;
	}
	function getTitle()
	{
		return $this->Title;
	}
	function setTitle($Title): self
	{
		$this->Title = $Title;
		return $this;
	}
	function getActionFile()
	{
		return $this->ActionFile;
	}
	function setActionFile($ActionFile): self
	{
		$this->ActionFile = $ActionFile;
		return $this;
	}
}

// Sealed class
class HTML
{
	private function __construct()
	{
	}
	static public function Header($Type)
	{
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
			<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

			<!-- bootstrap core css -->
			<link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />

			<!-- fonts style -->
			<link href="https://fonts.googleapis.com/css?family=Dosis:400,500|Poppins:400,600,700&display=swap" rel="stylesheet">
			<!-- Custom styles for this template -->
			<link href="../css/style.css" rel="stylesheet" />
			<!-- responsive style -->
			<link href="../css/responsive.css" rel="stylesheet" />
			<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
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
							<a class="navbar-brand" href="../index.php">
								<span>
									Orphanage Management System
								</span>
							</a>

							<div class="navbar-collapse" id="">
								<div class="d-none d-lg-flex ml-auto flex-column flex-lg-row align-items-center">
									<ul class="navbar-nav">
										<?php if (isset($_SESSION["UserId"])) { ?>
											<li class="nav-item">
												<a class="nav-link" href="../Login/Logout.php">
													<img src="../images/login.png" alt="" />
													<span>Logout</span></a>
											</li>
										<?php } else { ?>
											<li class="nav-item">
												<a class="nav-link" href="../Login/Login.php">
													<img src="../images/login.png" alt="" />
													<span>Login</span></a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="../Login/SignUp.php">
													<img src="../images/signup.png" alt="" />
													<span>Sign Up</span>
												</a>
											</li>
										<?php } ?>
									</ul>
									<form class="form-inline my-2 mb-3 mb-lg-0  mr-5">
									</form>
								</div>
								<?php if (isset($_SESSION["UserId"])) { ?>
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
											<a href="../index.php">HOME</a>
											<?php if (!str_contains($Servis[0], "Product-Non")) { ?>
												<a href="../Product/index.php">Activities</a>
											<?php } ?>
											<?php if (!str_contains($Servis[1], "Order-Non")) { ?>
												<a href="../Order/index.php">Daily Activities</a>
											<?php } ?>
											<?php if (!str_contains($Servis[2], "User-Non")) { ?>
												<a href="../User/index.php">User</a>
											<?php } ?>
											<?php if ($Type == "1") { ?>
												<a href="../Type/index.php">Type of Users</a>
											<?php } ?>
											<a href="../User/Profile.php">Profile</a>
										</div>
									<?php } ?>
									</div>
							</div>
						</nav>
					</div>
				</header>
				<!-- end header section -->
			</div>
		<?php
	}
	static public function Footer()
	{

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
	static public function DisplayTable(array $List, int $Type = 0, string $UpdateLink = "null", string $DeleteLink = "null")
	{
		echo "<center>";
		$Table = "box-shadow: 0 0 20px rgba(0,0,0,0.15); border-collapse: collapse; border-radius: 10px 10px 0 0; overflow: hidden; margin: 25px 0; font-size: 0.9em; font-family: sans-serif; min-width: 400px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);";
		$TableHead = "background-color: #a0e711; color: #ffffff; text-align: left; padding: 12px 15px;";
		echo "<table style='$Table'>";
		for ($i = 0; $i < count($List); $i++) {
			if ($i == 0) echo "<tr style='$TableHead'>";
			else if ($i == count($List) - 1) echo "<tr style='border-bottom: 2px solid #a0e711'>";
			else echo "<tr style='border-bottom: 1px solid #dddddd'>";
			for ($j = 0; $j < ($i > 0 ? count($List[$i]) - 1 : count($List[$i])); $j++) {
				echo "<th style='padding: 12px 15px; '>" . $List[$i][$j] . "</th>";
			}
			$Id1 = $List[$i][0];
			$Id2 = $List[$i][1];
			if ($Type == 3) {
				if ($i != 0) {
					echo "<th style='padding: 12px 15px;'><a href='PrintInvoice.php?OrderId=$Id1'>Print</a></th>";
					echo "<th style='padding: 12px 15px;'><a href='../OrderDetails/index.php?OrderId=$Id1'>Order Details</a></th>";
				} else {
					echo "<th style='padding: 12px 15px;' >Print</th>";
					echo "<th style='padding: 12px 15px;' >Order Details</th>";
				}
			}
			if ($Type != 0)
				if ($i != 0)
					if ($Type == 4) {
						if ($UpdateLink != "null") echo "<th style='padding: 12px 15px;' ><a href='$UpdateLink?Id1=$Id1&Id2=$Id2'>Update</a></th>";
						if ($DeleteLink != "null") echo "<th style='padding: 12px 15px;' ><a href='$DeleteLink?Id1=$Id1&Id2=$Id2'>Delete</a></th>";
					} else {
						if ($UpdateLink != "null") echo "<th style='padding: 12px 15px;' ><a href='$UpdateLink?Id1=$Id1'>Update</a></th>";
						if ($DeleteLink != "null") echo "<th style='padding: 12px 15px;' ><a href='$DeleteLink?Id1=$Id1'>Delete</a></th>";
					}
				else {
					if ($UpdateLink != "null") echo "<th style='padding: 12px 15px;' >Update</th>";
					if ($DeleteLink != "null")  echo "<th style='padding: 12px 15px;' >Delete</th>";
				}
			echo "</tr>";
		}
		echo "</table>";
		echo "</center>";
	}
}

?>