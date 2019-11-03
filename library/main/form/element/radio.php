<?php
namespace Genesis\library\main\form\element;
use Genesis\library\main\form\element;

class radio extends element{
    protected $header = '%s<input type="radio"%s/>';
    
    protected function doRender(): string
    {
        return sprintf( $this->header, "\t", $this->renderAttributes() );
    } 
    
    function setDefault( $default ){
        if ( $default == $this->value )
            $this->checked();
    }
}