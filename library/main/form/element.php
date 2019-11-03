<?php
namespace Genesis\library\main\form;

abstract class element extends html{
    protected $name;
    protected $value = NULL;
    protected $disabled = false;
    protected $checked = false;    
    protected $placeholder = '';
    protected $label = '';        
    
    function __construct( string $name, $value=NULL ){
        $this->name = $name;
        $this->id = $name;
        $this->value = $value;
    }
    abstract protected function doRender(): string;
    
    function setDefault( $default ){}
    
    function render(): string{
        return sprintf('%s%s%s', $this->renderLabel(), "\n", $this->doRender());
    }
    
    function setValue( string $value ): element{
        $this->value = $value;
        return $this;
    }
        
    function disabled(): element{
        $this->disabled = true;
        return $this;
    }
    
    function checked(): element{
        $this->checked = true;
        return $this;
    }
    
    function setPlaceholder( string $placeholder ): element{
        $this->placeholder = $placeholder;
        return $this;
    }
    
    function setLabel( string $label ): element{
        $this->label = $label;
        return $this;
    } 
    
    function getName(){
        return $this->name;
    }
    
    protected function renderAttributes(): string{                
        return sprintf('%s%s%s%s%s%s',
            $this->renderHTML(),
            $this->renderName(), 
            $this->renderValue(),                                           
            $this->renderDisabled(), 
            $this->renderChecked(), 
            $this->renderPlaceholder());
    }
    
    protected function renderLabel(): string{
        if ( $this->label )
            return sprintf('%s<label for="%s">%s</label>', "\r\n\t", $this->id ?? $this->name, $this->label);
        return '';
    }
    
    protected function renderPlaceholder(): string{
        if ( $this->placeholder )
            return sprintf(' placeholder="%s"', $this->placeholder);
        return '';
    }
    
    protected function renderName(): string{
        if ( $this->name )
            return sprintf(' name="%s"', $this->name);
        return '';
    }
    
    protected function renderValue(): string{
        if ( $this->value )
            return sprintf(' value="%s"', $this->value);
        return '';
    }
    
    protected function renderChecked(): string{
        if ( $this->checked )
            return ' checked';
        return '';
    }
    
    protected function renderDisabled(): string{
        if ( $this->disabled )
            return ' disabled';
        return '';
    }
}