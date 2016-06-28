<?php
namespace Genesis\library\main;

class view {
	protected $title = '';
	protected $subtitle = '';
	protected $style = array('style.css');
	protected $script = array();
	protected $auto_render_switch = true;
	protected $views = array();
	protected $layout_name = 'default_layout.php';
	protected $layout_render_switch = true;
	protected $if_layout_render = false;
	
	function __construct($view_name) {
		$this->add_view($view_name);
		$this->title = appConfig::getConfig('title');
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
		
	function add_view($view) {
		$this->views[] = $view;
	}
	
	function add_view_before($view) {
		array_unshift($this->views, $view);
	}
	
	function clear_view(){
		$this->views = array();
	}
	
	function auto_render_view() {
		if ($this->auto_render_switch) 
			$this->render_view();
	}
	
	function render_view() {
		if ($this->layout_render_switch and ($this->if_layout_render == false))
			$this->render_layout();
		else
			$this->render_views(); 
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
			include BASE_PATH . '/view/' . $this->layout_name;
		}
	}
	
	function render_views() {
		foreach ($this->views as $view) {
			include BASE_PATH . '/view/' . $view;
		}
	}
	 
}