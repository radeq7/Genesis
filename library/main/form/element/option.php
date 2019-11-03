<?php
namespace Genesis\library\main\form\element;
use Genesis\library\main\form\html;

class option extends html{
    protected $value;
    protected $label;
    protected $selected = false;
    
    function __construct( string $value, string $label, bool $selected = false ){
        $this->value = $value;
        $this->label = $label;
        $this->selected = $selected;
    }
    
    function render(): string{
        return sprintf('%s<option value="%s" label="%s"%s>%s</option>%s', "\t\t", $this->value, $this->label, $this->renderSelected (), $this->label, PHP_EOL);
    }
    
    function getValue(): string{
        return $this->value;
    }
    
    function selected(){
        $this->selected = true;
    }
    
    function unSelect(){
        $this->selected = false;
    }
    
    protected function renderSelected(): string{
        if ( $this->selected )
            return ' selected';
        return '';
    }
}
//