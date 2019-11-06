<?php
namespace Genesis\library\main\form\validator;

class boolValidate extends aValidate{
    function doValidate( $value ): bool{
        
        if ( !is_bool( $value )){
            $this->setDefaultError();
            return false;
        }
        return true;
    }
}