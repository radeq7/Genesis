<?php
namespace Genesis\library\main\form\validator;

class formValidator{
    protected $validateList = array();
    protected $errorList = array();
    
    function addValidate( aValidate $validate ){
        $this->validateList[] = $validate;
    }
    
    function validate( array $post ): bool{
        $isValid = true;
        foreach ($this->validateList as $validate){
            if ( !$this->validateOne( $validate, $post ) )
                $isValid = false;
        }
        return $isValid;
    }
    
    function getErrors(): array{
        return $this->errorList;
    }
    
    protected function validateOne( aValidate $validate, array $post ): bool{  
        
        if ( isset( $post[$validate->getName()] ) && $validate->isValidate( $post[$validate->getName()] ) ){
            return true;
        }
        else{
            $this->setError( $validate->getName(), $validate->getError() );
            return false;
        }
        
    }
    
    protected function setError( $name, $errorMessage){
        $this->errorList[$name] = $errorMessage;
    }
}