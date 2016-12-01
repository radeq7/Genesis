<?php
namespace Genesis\library\main\standard;

class time{
	protected $date;
	function __construct($time = null){
		if ($time == null)
			$this->date = new \DateTime();
		elseif(is_string($time)) 
			$this->date = new \DateTime($time);
		elseif(is_a($time, '\DateTime'))
			$this->date = $time;
		else 
			throw new \Exception(sprintf('Nieprawidłowy parametr typu: (%s) w tworzeniu obiektu time!', gettype($time)));
	}
	function __toString(){
		return $this->date->format('Y-m-d H:i:s');
	}
	function getSecond(){
		return $this->date->format('s');
	}
	function getMinute(){
		return $this->date->format('i');
	}
	function getHour(){
		return $this->date->format('H');
	}
	function getDay(){
		return $this->date->format('d');
	}
	function getMonth(){
		return $this->date->format('m');
	}
	function getYear(){
		return $this->date->format('Y');
	}
	function getDayOfWeek(){
		return $this->date->format('N');
	}
	function getDayOfYear(){
		return 1 + $this->date->format('z');
	}
	function getWeekOfYear(){
		return $this->date->format('W');
	}
	function modifySecond($second){
		$mod = sprintf('%+d seconds', $second);
		$this->date->modify($mod);
	}
	function modifyMinute($minutes){
		$mod = sprintf('%+d minutes', $minutes);
		$this->date->modify($mod);
	}
	function modifyHour($hours){
		$mod = sprintf('%+d hours', $hours);
		$this->date->modify($mod);
	}
	function modifyDay($days){
		$mod = sprintf('%+d days', $days);
		$this->date->modify($mod);
	}
	function modifyMonth($months){
		$mod = sprintf('%+d months', $months);
		$this->date->modify($mod);
	}
	function modifyYear($years){
		$mod = sprintf('%+d years', $years);
		$this->date->modify($mod);
	}
	function getNameDayOfWeek(){
		switch($this->getDayOfWeek()){
			case 1:
				return 'Poniedziałek'; 
			case 2:
				return 'Wtorek';
			case 3:
				return 'Środa';
			case 4:
				return 'Czwartek';
			case 5:
				return 'Piątek';
			case 6:
				return 'Sobota';
			case 7:
				return 'Niedziela';
			default:
				return FALSE;
		}
	}
	function getNameMonth(){
		switch($this->getMonth()){
			case 1:
				return 'Styczeń';
			case 2:
				return 'Luty';
			case 3:
				return 'Marzec';
			case 4:
				return 'Kwiecień';
			case 5:
				return 'Maj';
			case 6:
				return 'Czerwiec';
			case 7:
				return 'Lipiec';
			case 8:
				return 'Sierpień';
			case 9:
				return 'Wrzesień';
			case 10:
				return 'Październik';
			case 11:
				return 'Listopad';
			case 12:
				return 'Grudzień';
			default:
				return FALSE;
		}
	}
}