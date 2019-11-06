<?php
namespace Genesis\library\main\form\validator;

abstract class aValidate{
    protected $name;
    protected $error = false;
    protected $errorList = array();
    
    function __construct( string $name, string $errorMessage ){
        $this->name = $name;
        $this->errorList['default'] = $errorMessage;
    }
    
    function isValidate( $value ): bool{
        $this->resetError();
        return $this->doValidate( $value );
    }
    
    function getError(): string{
        return $this->error;
    }
    
    function getName(): string{
        return $this->name;
    }
    
    protected function setDefaultError(){
        $this->setError('default');
    }
    
    protected function setError( $idError ){
        $this->error = sprintf('%s: %s', $this->name, $this->errorList[$idError]);
    }
    
    protected function resetError(){
        $this->error = false;
    }
    
    abstract function doValidate( $value ): bool;
}