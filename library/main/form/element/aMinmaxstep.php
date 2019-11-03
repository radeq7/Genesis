<?php
namespace Genesis\library\main\form\element;
use Genesis\library\main\form\element;

abstract class aMinmaxstep extends element{
    protected $min;
    protected $max;
    protected $step;
    
    function setMin( int $min ): aMinmaxstep{
        $this->min = $min;
        return $this;
    }
    
    function setMax( int $max ): aMinmaxstep{
        $this->max = $max;
        return $this;
    }
    
    function setStep( int $step): aMinmaxstep{
        $this->step = $step;
        return $this;
    }
    
    protected function renderAttributes(): string{
        return sprintf('%s%s%s%s', parent::renderAttributes(), $this->renderMin(), $this->renderMax(), $this->renderStep());
    }
    
    protected function renderMin(): string{
        if ( $this->min )
            return sprintf(' min="%s"', $this->min);
        return '';
    }
    
    protected function renderMax(): string{
        if ( $this->max )
            return sprintf(' max="%s"', $this->max);
        return '';
    }
    
    protected function renderStep(): string{
        if ( $this->step )
            return sprintf(' step="%s"', $this->step);
        return '';
    }
}