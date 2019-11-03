<?php
namespace Genesis\library\main\form;

abstract class html{
    protected $id;
    protected $class;
    protected $style;
    protected $title;
    protected $hidden = false;
    
    function setId( string $id ): html{
        $this->id = $id;
        return $this;
    }
    
    function setClass( string $class): html{
        $this->class = $class;
        return $this;
    }
    
    function setStyle( string $style ): html{
        $this->style = $style;
        return $this;
    }
    
    function setTitle( string $title): html{
        $this->title = $title;
        return $this;
    }
    
    function hidden(): html{
        $this->hidden = true;
        return $this;
    }
    
    function renderHTML(): string{
        return sprintf('%s%s%s%s%s', $this->renderId(), $this->renderClass(), $this->renderStyle(), $this->renderTitle(), $this->renderHidden());
    }
    
    protected function renderId(): string{
        if ( $this->id ){
            return sprintf(' id="%s"', $this->id);
        }
        return '';
    }
    
    protected function renderHidden(): string{
        if ( $this->hidden ){
            return sprintf(' hidden');
        }
        return '';
    }
    
    protected function renderClass(): string{
        if ( $this->class ){
            return sprintf(' class="%s"', $this->class);
        }
        return '';
    }
    
    protected function renderStyle(): string{
        if ( $this->style ){
            return sprintf(' style="%s"', $this->style);
        }
        return '';
    }
    
    protected function renderTitle(): string{
        if ( $this->title ){
            return sprintf(' title="%s"', $this->title);
        }
        return '';
    }
}