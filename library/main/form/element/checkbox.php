<?php
namespace Genesis\library\main\form\element;
use Genesis\library\main\form\element;

class checkbox extends element{
    protected $header = '%s<input type="checkbox"%s/>';
    
    protected function doRender(): string
    {
        return sprintf( $this->header, "\t", $this->renderAttributes() );
    }
    
    function setDefault( $default ){
        if ( $default == ( $this->value ?? 'on' ))
            $this->checked();
    }
}