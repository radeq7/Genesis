<?php
namespace Genesis\library\main\form\element;

class range extends aMinmaxstep{
    protected $header = "\t" . '<input type="range"%s>';
    
    protected function doRender(): string{
        return sprintf($this->header, $this->renderAttributes());
    }
}