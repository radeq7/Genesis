<?php
namespace Genesis\library\main\form\element;

class number extends aMinmaxstep{
    protected $header = "\t" . '<input type="number"%s>';
    
    protected function doRender(): string{
        return sprintf($this->header, $this->renderAttributes());
    }    
}