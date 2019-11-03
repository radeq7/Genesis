<?php
namespace Genesis\library\main\form\element;
use Genesis\library\main\form\element;

class text extends element{
    protected $type;
    protected $header = '%s<input%s%s/>';
    protected $size;
    protected $maxlength;
    
    function size( int $size ): text{
        $this->size = $size;
        return $this;
    }
    
    function maxlength( int $maxlength ): text{
        $this->maxlength = $maxlength;
        return $this;
    }
    
    function setDefault( $default ){
        $this->value = $default;
    }
    
    function setTypePassword(){
        $this->type = 'password';
    }
        
    protected function doRender(): string{
        return sprintf($this->header, "\t", $this->renderAttributes(), $this->renderInput());
    }
    
    protected function renderType(): string{
        if ( $this->type )
            return sprintf(' type="%s"', $this->type);
        return '';
    }

    protected function renderInput(): string{
        return sprintf('%s%s%s%s', $this->renderType(), $this->renderSize(), $this->renderMaxlength(), $this->extraRender());
    }
    
    protected function renderSize(): string{
        if ( $this->size )
            return sprintf(' size="%s"', $this->size);
        return '';
    }
    
    protected function renderMaxlength(): string{
        if ( $this->maxlength )
            return sprintf(' maxlength="%s"', $this->maxlength);
        return '';
    }
    
    protected function extraRender(): string{
        return '';
    }
}