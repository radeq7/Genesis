<?php
class select extends element{
    protected $header = "\t" . '<select%s>' . "\n";
    protected $footer = "\t</select>";
    protected $name;
    protected $options = array();
    protected $default;
     
    function addOption( string $value, string $label, bool $selected = false ): element{
        $this->options[] = new option( $value, $label, $selected );
        $this->checkDefault();
        return $this;
    }
    
    function setDefault( $default ){
        $this->default = $default;
    }
    
    protected function doRender(): string{
        $render = '';
        $render .= $this->renderHeader();
        $render .= $this->renderOptions();
        $render .= $this->footer;
        return $render;
    }
    
    protected function checkDefault(){
        $selected = false;
        foreach ( $this->options as $option ){
            if ( $option->getValue() == $this->default )
                $selected = $option;
        }
        if ( $selected ){
            foreach ( $this->options as $option ){
                $option->unSelect();
            }
            $selected->selected();
        }
    }
    
    protected function renderHeader(): string{
        return sprintf($this->header, $this->renderAttributes());
    }
    
    protected function renderOptions(): string{
        $render = '';
        foreach ( $this->options as $option ){
            $render .= $option->render();
        }
        return $render;
    }    
}