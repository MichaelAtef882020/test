<?php
interface Data {
	public function Add(string $Line);
	public function Update(string $Old, string $New);
	public function Delete(string $Data);
	public function GetLastId();
	public function GetAllContent();
	public function ValueIsThere(string $Value, int $Index);
}
class FileManger implements Data {
	private $FileName;
	public function __construct($FileName) {
		$this->FileName = $FileName;
	}
	private function Encrypt() {
		$contents = file_get_contents("../Files/" . $this->FileName);
		$Key = 15;
		$Result = "";
		for ($i = 0; $i < strlen($contents); $i++) {
			$c = chr(ord($contents[$i]) + $Key + $i);
			$Result .= $c;
		}
		file_put_contents("../Files/" . $this->FileName, $Result);
	}
	private function Decrypt() {
		$contents = file_get_contents("../Files/" . $this->FileName);
		$Key = 15;
		$Result = "";
		for ($i = 0; $i < strlen($contents); $i++) {
			$c = chr(ord($contents[$i]) - $Key - $i);
			$Result .= $c;
		}
		file_put_contents("../Files/" . $this->FileName, $Result);
	}
	function GetLastId() {
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
	function ValueIsThere(string $Value, int $Index) {
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
	function GetAllContent() {
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
	function Add(string $Line) {
		$this->Decrypt();
		$File = fopen("../Files/" . $this->FileName, 'a');
		fwrite($File, $Line);
		$this->Encrypt();
	}
	function Update(string $Old, string $New) {
		$this->Decrypt();
		$contents = file_get_contents("../Files/" . $this->FileName);
		$contents = str_replace($Old, $New, $contents);
		file_put_contents("../Files/" . $this->FileName, $contents);
		$this->Encrypt();
	}
	function Delete(string $Data) {
		$Array = explode("~",$Data);
		$DeletedData = "".$Array[0]."~";
		for ($i=1; $i < count($Array)-1; $i++) { 
			$DeletedData.="Deleted~";
		}
		$DeletedData.="\r\n";
		$this->Update($Data,$DeletedData);
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
class DataBase implements Data {
	
	/**
	 *
	 * @param string $Line
	 *
	 * @return mixed
	 */
	function Add(string $Line) {
	}
	
	/**
	 *
	 * @param string $Old
	 * @param string $New
	 *
	 * @return mixed
	 */
	function Update(string $Old, string $New) {
	}
	
	/**
	 *
	 * @param string $Data
	 *
	 * @return mixed
	 */
	function Delete(string $Data) {
	}
	
	/**
	 *
	 * @return mixed
	 */
	function GetLastId() {
	}
	
	/**
	 *
	 * @return mixed
	 */
	function GetAllContent() {
	}
	
	/**
	 *
	 * @param string $Value
	 * @param int $Index
	 *
	 * @return mixed
	 */
	function ValueIsThere(string $Value, int $Index) {
	}
}
class Cloud implements Data {
	
	/**
	 *
	 * @param string $Line
	 *
	 * @return mixed
	 */
	function Add(string $Line) {
	}
	
	/**
	 *
	 * @param string $Old
	 * @param string $New
	 *
	 * @return mixed
	 */
	function Update(string $Old, string $New) {
	}
	
	/**
	 *
	 * @param string $Data
	 *
	 * @return mixed
	 */
	function Delete(string $Data) {
	}
	
	/**
	 *
	 * @return mixed
	 */
	function GetLastId() {
	}
	
	/**
	 *
	 * @return mixed
	 */
	function GetAllContent() {
	}
	
	/**
	 *
	 * @param string $Value
	 * @param int $Index
	 *
	 * @return mixed
	 */
	function ValueIsThere(string $Value, int $Index) {
	}
}