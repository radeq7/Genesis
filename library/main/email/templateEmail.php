<?php
namespace Genesis\library\main\email;

class templateEmail extends email{
	protected $templateView = FALSE;
	protected $layoutView = FALSE;
	protected $search = array();
	protected $replace = array();
	/**
	 * Ustaw widok szablonu
	 */
	function setTemplateView($templateView){
		$this->templateView = $templateView;
	}
	/**
	 * Ustaw podstawiane wartości
	 */
	function setReplace($search, $replace){
		$this->search[] = $search;
		$this->replace[] = $replace;
	}
	/**
	 * Ustawia plik layoutu wiadomości
	 */
	function setLayoutView($layoutView){
		$this->layoutView = $layoutView;
	}
	/**
	 * Zwraca wiadomość
	 */
	function getMessage(){
		if ($this->layoutView)
			return $this->generateLayout();
		return $this->generateMessage();
	}
	/**
	 * Generuje treść wiadomości
	 */
	protected function generateMessage(){
		$templateView = file_get_contents($this->templateView);
		if ($templateView === FALSE)
			throw new \Exception('Podany plik szablonu wiadomości email nie istnieje!');
		$message = str_replace($this->search, $this->replace, $templateView);
		return $message;
	}
	/**
	 * Generuje treść wiadomości w layout
	 * W layout znak {$content} zostanie zastąpiony przez wiadomość
	 */
	protected function generateLayout(){
		$templateView = file_get_contents($this->layoutView);
		if ($templateView === FALSE)
			throw new \Exception('Podany plik szablonu wiadomości email nie istnieje!');
		$message = str_replace('{$content}', $this->generateMessage(), $templateView, $count);
		if ($count == 0)
			throw new \Exception('W pliku layout wiadomości, nie ma znaków {$content} do zastąpienia wiadomości!');
		return $message;
	}
}