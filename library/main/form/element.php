<?php
abstract class element{
    protected $name;
    protected $id;
    protected $value = NULL;
    protected $disabled = false;
    protected $checked = false;    
    protected $placeholder = '';
    protected $label = '';    
    protected $class;
    protected $style;
    protected $title;
    
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
    
    function setId( string $id ): element{
        $this->id = $id;
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
    
    function setClass( string $class ): element{
        $this->class = $class;
        return $this;
    }
    
    function setStyle( string $style ): element{
        $this->style = $style;
        return $this;
    }
    
    function setTitle( string $title ): element{
        $this->title = $title;
        return $this;
    }
    
    function getName(){
        return $this->name;
    }
    
    protected function renderAttributes(): string{                
        return sprintf('%s%s%s%s%s%s%s%s', $this->renderName(), 
                                           $this->renderValue(), 
                                           $this->renderClass(), 
                                           $this->renderDisabled(), 
                                           $this->renderChecked(), 
                                           $this->renderPlaceholder(),
                                           $this->renderStyle(),
                                           $this->renderTitle());
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
    
    protected function renderClass(): string{
        if ( $this->class )
            return sprintf(' class="%s"', $this->class);
        return '';
    }
    
    protected function renderStyle(): string{
        if ( $this->style )
            return sprintf(' style="%s"', $this->style);
        return '';
    }
    
    protected function renderTitle(): string{
        if ( $this->title )
            return sprintf(' title="%s"', $this->title);
        return '';
    }
}