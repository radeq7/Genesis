<?php

class library_main_view {
	protected $title = '';
	protected $subtitle = '';
	protected $style = array('style.css');
	protected $script = array();
	protected $auto_render_switch = true;
	protected $view_name = '';
	protected $layout_name = 'default_layout.php';
	protected $layout_render_switch = true;
	protected $if_layout_render = false;
	
	function __construct($view_name) {
		$this->view_name = $view_name;
		$this->title = library_main_appConfig::getConfig('title');
	}
	
	function title($title){
		$this->title = $title;
	}
	
	function subtitle($subtitle){
		$this->title .= $subtitle;
	}
	
	function add_style($style) {
		$this->style[] = $style; 
	}
	
	function add_script($script) {
		$this->script[] = $script;
	}
	
	function auto_render_switch($auto_render_switch){
		$this->auto_render_switch = $auto_render_switch;
	}
		
	function render_additional_view($view) {
		$this->render_layout();
		include BASE_PATH . 'application/view/' . $view;
	}
	
	function auto_render_view() {
		if ($this->auto_render_switch) 
			$this->render_view();
	}
	
	function render_view() {
		if ($this->layout_render_switch and ($this->if_layout_render == false))
			$this->render_layout();
		else
			include BASE_PATH . 'view/' . $this->view_name;
	}
	
	function layout_render_switch($switch) {
		$this->layout_render_switch = $switch;
	}
	
	function change_layout($layout_name) {
		$this->layout_name = $layout_name;
	}
	
	protected function render_layout() {
		if (!$this->if_layout_render) {
			$this->if_layout_render = true;
			include BASE_PATH . 'view/' . $this->layout_name;
		}
	}
	 
}