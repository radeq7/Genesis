<?php
namespace Genesis\library\main\form\validator;

class stringValidate extends aValidate{
    protected $maxLength;
    protected $minLength;
    
    function doValidate( $value ): bool{
        
        if ( !is_string( $value )){
            $this->setDefaultError();
            return false;
        }
        if ( $this->minLength && strlen($value) < $this->minLength ){
            $this->setError('minLength');
            return false;
        }
        if ( $this->maxLength && strlen($value) > $this->maxLength ){
            $this->setError('maxLength');
            return false;
        }
        return true;
    }
    
    function setMaxLength( int $maxLength, string $errorMessage ): stringValidate {
        $this->maxLength = $maxLength;
        $this->errorList['maxLength'] = $errorMessage;
        return $this;
    }
    
    function setMinLength( int $minLength, string $errorMessage): stringValidate{
        $this->minLength = $minLength;
        $this->errorList['minLength'] = $errorMessage;
        return $this;
    }
}