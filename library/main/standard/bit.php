<?php
class bit{
	const BIT1 = 1;
	const BIT2 = 2;
	const BIT3 = 4;
	const BIT4 = 8;
	const BIT5 = 16;
	const BIT6 = 32;
	const BIT7 = 64;
	const BIT8 = 128;
	private $int;
	
	function __contruct($int = 0){
		$this->int = $int;
	}
	
	function getInt(){
		return $this->int;
	}
	
	function setInt($int){
		$this->int = $int;
	}
	
	function setBit($nrBit){
		$this->int |= $this->getBitValue($nrBit);
	}
	
	function getBit($nrBit){
		return $this->int & $this->getBitValue($nrBit);
	}
	
	function removeBit($nrBit){
		$this->int &= ~$this->getBitValue($nrBit);
	}
	
	function switchBit($nrBit){
		$this->int ^= $this->getBitValue($nrBit);
	}
	
	private function getBitValue($nrBit){
		switch ($nrBit){
			case 1:
				return bit::BIT1;
			case 2:
				return bit::BIT2;
			case 3:
				return bit::BIT3;
			case 4:
				return bit::BIT4;
			case 5:
				return bit::BIT5;
			case 6:
				return bit::BIT6;
			case 7:
				return bit::BIT7;
			case 8:
				return bit::BIT8;
			default:
				throw new Exception();
		}
	}
}