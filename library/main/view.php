<?php
class view {
	protected $view = '';
	protected $title = '';
	protected $style = array('style.css');
	protected $script = array();
	
	function __construct($view_path) {
		$this->view = $view_path;
		$this->init();
	}
	
	function init() {
		$config = config_app::getInstance();
		$this->title = $config->getConfig('app_name');
	}
	
	function render_view() {
		include BASE_PATH . 'application/view/layout.php';
	}
	
	function set_title($title) {
		$this->title = $title;
	}
	
	function add_style($style) {
		$this->style[] = $style; 
	}
	
	function add_script($script) {
		$this->script[] = $script;
	}
	
	function get_content() {
		return $this->view;
	}
}