<?php
namespace Genesis\library\main\form\validator;

class intValidate extends aValidate{
    protected $min;
    protected $max;
    
    function doValidate( $value ): bool{
        
        if ( !is_numeric( $value )){
            $this->setDefaultError();
            return false;
        }
        if ( $this->min && $value < $this->min ){
            $this->setError('min');
            return false;
        }
        if ( $this->max && $value > $this->max ){
            $this->setError('max');
            return false;
        }
        return true;
    }
    
    function setMin( int $min, string $errorMessage ): intValidate{
        $this->min = $min;
        $this->errorList['min'] = $errorMessage;
        return $this;
    }
    
    function setMax ( int $max, string $errorMessage ): intValidate{
        $this->max = $max;
        $this->errorList['max'] = $errorMessage;
        return $this;
    }
}
