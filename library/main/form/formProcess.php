<?php
namespace Genesis\library\main\form;
use Genesis\library\main\form\validator\formValidator;

class formProcess{
    protected $form;
    protected $validator;
    
    function __construct( form $form, formValidator $validator ){
        $this->form = $form;
        $this->validator = $validator;
    }
    
    function proceed( array $post ): bool{
        if ( $post ){
            return $this->validate( $post );
        }
        else {
            return FALSE;
        }
    }
    
    function renderForm(): string{
        return $this->form->render();
    }
    
    protected function validate( array $post ): bool{
        if ( $this->validator->validate( $post )){
            return TRUE;
        }
        else{        
            $this->form->setDefaultData( $post );
            $this->form->setErrors( $this->validator->getErrors() );
            return FALSE;
        }
    }
}
