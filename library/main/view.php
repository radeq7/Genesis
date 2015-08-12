<?php
class view {
	protected $view = '';
	protected $title = '';
	protected $style = array('style.css');
	protected $script = array();
	protected $if_view_layout = false;
	
	function __construct($view_path) {
		$this->view = $view_path;
		$this->init();
	}
	
	function init() {
		$config = config_app::getInstance();
		$this->title = $config->getConfig('app_name');
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
	
	function render_view() {
		if (!$this->if_view_layout) {
			include BASE_PATH . 'application/view/layout.php';
			$this->if_view_layout = true;
		}
	}
	
	function render($view) {
		$this->render_view();
		include BASE_PATH . 'application/view/' . $view;
	}
}