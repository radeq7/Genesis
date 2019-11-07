<?php
namespace Genesis\library\main\standard;

class log{
    protected $filename;
    protected $file;
    
    function __construct($filename){
        if (!file_exists($filename))
            throw new \Exception('<br>Plik: ' . __FILE__ . '<br>Linia: ' . __LINE__ . '<br>' ."Podana nazwa pliku nie istnieje: {$filename}");
            $this->filename = $filename;
    }
    function logMessage($message){
        $file = $this->getFile();
        fwrite($file, $message . PHP_EOL);
    }
    function formatMessage($message){
        $date = date("Y-m-d H:i:s");
        $ip = $_SERVER['REMOTE_ADDR'];
        return sprintf('<br>%s<br>IP: %s%s<br>', $date, $ip, $message);
        
    }
    function getFile(){
        if ($this->file)
            return $this->file;
            return fopen($this->filename, 'a');
    }
    function __destruct(){
        if ($this->file)
            fclose($this->file);
    }
}