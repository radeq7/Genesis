<?php
class form{
    protected $method = 'post';
    protected $action;
    protected $defaultValue = array();
    protected $autocomplete = NULL;
    protected $target = NULL;
    protected $openTag = '<form method="%s" action="%s"%s%s>';
    protected $closeTag = '</form>';
    protected $elementList = array();
    
    function __construct( string $action, array $defaultValue = array() ){
        $this->action = $action;
        $this->defaultValue = $defaultValue;
    }
    
    function addElement( element $element ){
        $this->elementList[] = $element;
        $this->setDefault( $element );
    }
    
    function addButton( string $name, $value= NULL ): button{
        $element = new button( $name, $value );
        $this->addElement($element);
        return $element;
    }
    
    function addCheckbox( string $name, $value= NULL ): checkbox{
        $element = new checkbox( $name, $value );
        $this->addElement($element);
        return $element;
    }
    
    function addRadio( string $name, $value= NULL ): radio{
        $element = new radio( $name, $value );
        $this->addElement($element);
        return $element;
    }
    
    function addSelect( string $name, $value= NULL ): select{
        $element = new select( $name, $value );
        $this->addElement($element);
        return $element;
    }
    
    function addSubmit( string $name, $value= NULL ): submit{
        $element = new submit( $name, $value );
        $this->addElement($element);
        return $element;
    }
    
    function addText( string $name, $value = NULL ): text{
        $element = new text( $name, $value );
        $this->addElement($element);
        return $element;
    }
    
    function addPassword( string $name, $value = NULL ): text{
        $element = new text( $name, $value );
        $element->setTypePassword();
        $this->addElement($element);
        return $element;
    }
    
    function addTextarea( string $name, $value = NULL ): textarea{
        $element = new textarea( $name, $value );
        $this->addElement($element);
        return $element;
    }
    
    function autocompleteOff(): void{
        $this->autocomplete = false;
    }
    
    function autocompleteOn(): void{
        $this->autocomplete = true;
    }
    
    function setMethodGet(): void{
        $this->method = 'get';
    }
    
    function setMethodPost(): void{
        $this->method = 'post';
    }
    
    function setTarget( string $target ): void{
        $this->target = $target;
    }
    
    function __toString(){
        return $this->render();
    }
    
    function render(){
        $render = '';
        $render .= $this->renderHeader();
        $render .= $this->renderBody();
        $render .= $this->renderFooter();
        return $render;
    }
    
    function getElementList(): array{
        return $this->elementList;
    }
    
    protected function renderHeader(): string{
        return sprintf($this->openTag, $this->method, $this->action, $this->renderAutocomplete(), $this->renderTarget());
    }
    
    protected function renderBody(): string{
        $body = '';
        foreach ( $this->elementList as $element ){
            $body .= $element->render();
        }
        return $body;
    }
    
    protected function renderFooter(): string{
        return $this->closeTag;
    }
    
    protected function renderAutocomplete(): string{
        if ( $this->autocomplete === NULL )
            return '';
        elseif ($this->autocomplete === true )
            return ' autocomplete="on"';
        else
            return ' autocomplete="off"';
    }
    
    protected function renderTarget(): string{
        if ( $this->target )
            return $this->target;
        return '';
    }
    
    protected function setDefault( element $element ){
        if ( isset( $this->defaultValue[$element->getName()] ) && $this->defaultValue[$element->getName()]){
            $element->setDefault( $this->defaultValue[$element->getName()] );
        }
        
    }
}