<?php
namespace Genesis\library\main\form\element;

class textarea extends text{
    protected $rows;
    protected $cols;
    protected $wrap;
    protected $header = '%s<textarea%s%s>';
    protected $footer = '%s</textarea>';
    
    function setRows( int $rows ): textarea{
        $this->rows = $rows;
        return $this;
    }
    
    function setCols( int $cols ): textarea{
        $this->cols = $cols;
        return $this;
    }
    
    function wrapHard(): textarea{
        $this->wrap = ' wrap="hard"';
        return $this;
    }
    
    function wrapSoft(): textarea{
        $this->wrap = ' wrap="soft"';
        return $this;
    }
    
    protected function doRender(): string{
        $string = parent::doRender();
        return sprintf('%s%s', $string, sprintf($this->footer, $this->value));
    }
    
    protected function renderCols(): string{
        if ( $this->cols )
            return sprintf(' cols="%s"', $this->cols);
        return '';
    }
    
    protected function renderRows(): string{
        if ( $this->rows )
            return sprintf(' rows="%s"', $this->rows);
        return '';
    }
    
    protected function renderWrap(): string{
        if ( $this->wrap )
            return $this->wrap;
        return '';
    }
    
    protected function extraRender(): string{
        return sprintf('%s%s%s', $this->renderRows(), $this->renderCols(), $this->renderWrap());
    }
}