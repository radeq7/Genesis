<?php
namespace Genesis\library\main\form\element;
use Genesis\library\main\form\element;

class submit extends element{
    protected $header = "\t" . '<button type="submit"%s>%s</button>' . "\n";
    
    protected function doRender(): string{
        return sprintf($this->header, $this->renderAttributes(), $this->value ?? $this->name);
    }
}