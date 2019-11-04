<?php
namespace Genesis\library\main\standard\validator;

class stringValidate extends aValidator{
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
    
    function setMaxLength( int $maxLength, string $errorMessage ) {
        $this->maxLength = $maxLength;
        $this->errorList['maxLength'] = $errorMessage;
    }
    
    function setMinLength( int $minLength, string $errorMessage){
        $this->minLength = $minLength;
        $this->errorList['minLength'] = $errorMessage;
    }
}