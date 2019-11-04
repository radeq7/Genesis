<?php
namespace Genesis\library\main\standard\validator;

class intValidate extends aValidator{
    protected $min;
    protected $max;
    
    function doValidate( $value ): bool{
        
        if ( !is_int( $value )){
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
    
    function setMin( int $min, string $errorMessage ){
        $this->min = $min;
        $this->errorList['min'] = $errorMessage;
    }
    
    function setMax ( int $max, string $errorMessage ){
        $this->max = $max;
        $this->errorList['max'] = $errorMessage;
    }
}
