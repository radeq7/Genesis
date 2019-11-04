<?php
namespace Genesis\library\main\standard\validator;

class boolValidate extends aValidator{
    function doValidate( $value ): bool{
        
        if ( !is_bool( $value )){
            $this->setDefaultError();
            return false;
        }
        return true;
    }
}