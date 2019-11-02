<?php
class button extends element{
    protected $header = "\t" . '<button type="button"%s>%s</button>';
    
    protected function doRender(): string{
        return sprintf($this->header, $this->renderAttributes(), $this->value ?? $this->name);
    }
}