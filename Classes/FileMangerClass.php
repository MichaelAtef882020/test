<?php
class FileManger
{
	private $FileName;
	public function __construct($FileName) {
		$this->FileName = $FileName;
	}
	public function Encrypt() {
		$contents = file_get_contents("../Files/" . $this->FileName);
		$Key = 15;
		$Result = "";
		for ($i = 0; $i < strlen($contents); $i++) {
			$c = chr(ord($contents[$i]) + $Key + $i);
			$Result .= $c;
		}
		file_put_contents("../Files/" . $this->FileName, $Result);
	}
	public function Decrypt()
	{
		$contents = file_get_contents("../Files/" . $this->FileName);
		$Key = 15;
		$Result = "";
		for ($i = 0; $i < strlen($contents); $i++) {
			$c = chr(ord($contents[$i]) - $Key - $i);
			$Result .= $c;
		}
		file_put_contents("../Files/" . $this->FileName, $Result);
	}
	
	function GetLastId()
	{
		$this->Decrypt();
		$File = fopen("../Files/" . $this->FileName, 'r');
		$max = 0;
		while ($Line = fgets($File)) {
			$Array = explode('~', $Line);
			$Id = intval($Array[0]);
			if ($Id > $max) {
				$max = $Id;
			}
		}
		$this->Encrypt();
		return $max;
	}
	function ValueIsThere(string $Value, int $Index)
	{
		$this->Decrypt();
		$File = fopen("../Files/" . $this->FileName, 'r');
		while ($Line = fgets($File)) {
			$Array = explode('~', $Line);
			if($Array[1]!="Deleted")
			{
				if ($Array[$Index] == $Value) {
					$this->Encrypt();
					return $Line;
				}
			}
		}
		$this->Encrypt();
		return null;
	}
	function GetAllContent()
	{
		$this->Decrypt();
		$File = fopen("../Files/" . $this->FileName, 'r');
		$List = [];
		while ($Line = fgets($File)) {
			$Array = explode("~",$Line);
			if($Array[1]!="Deleted")
			{
				array_push($List, $Line);
			}
		}
		$this->Encrypt();
		return $List;
	}
	function FileAdd(string $Line)
	{
		$this->Decrypt();
		$File = fopen("../Files/" . $this->FileName, 'a');
		fwrite($File, $Line);
		$this->Encrypt();
	}
	function FileWrite(string $Line)
	{
		$this->Decrypt();
		$File = fopen("../Files/" . $this->FileName, 'w');
		fwrite($File, $Line);
		$this->Encrypt();
	}
	function FileUpdate(string $Old, string $New)
	{
		$this->Decrypt();
		$contents = file_get_contents("../Files/" . $this->FileName);
		$contents = str_replace($Old, $New, $contents);
		file_put_contents("../Files/" . $this->FileName, $contents);
		$this->Encrypt();
	}
	function FileDelete(string $Data)
	{
		$Array = explode("~",$Data);
		$DeletedData = "".$Array[0]."~";
		for ($i=1; $i < count($Array)-1; $i++) { 
			$DeletedData.="Deleted~";
		}
		$DeletedData.="\r\n";
		$this->FileUpdate($Data,$DeletedData);
	}
	/**
	 * 
	 * @return mixed
	 */
	function getFileName() {
		return $this->FileName;
	}
	
	/**
	 * 
	 * @param mixed $FileName 
	 * @return FileManger
	 */
	function setFileName($FileName): self {
		$this->FileName = $FileName;
		return $this;
	}
}