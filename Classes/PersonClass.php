<?php

class Person {
	protected ?int $Id = 0;
	protected ?string $Name = "";
	function getId(): int
	{
		return $this->Id;
	}
	function setId(?int $Id): int
	{
		if ($Id < 0) return 0;
		$this->Id = $Id;
		return 1;
	}
	function getName(): string
	{
		return $this->Name;
	}
	function setName(?string $Name): int
	{
		if (str_contains($Name, '~')) return 0;
		$this->Name = $Name;
		return 1;
	}
}
interface File {
	public function Add($input1 = null, $input2 = null, $input3 = null, $input4 = null);
	public function Update($input1 = null, $input2 = null, $input3 = null, $input4 = null);
	public function Searsh($input1 = null, $input2 = null, $input3 = null, $input4 = null);
	public function Delete($input1 = null, $input2 = null, $input3 = null, $input4 = null);
	public function ToString();
	static public function FromStringToObject(String $Line);
}
