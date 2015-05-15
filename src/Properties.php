<?php
namespace Kros\PropertiesMGR;

require_once 'PropertyNotFoundException.php';

use Kros\PropertiesMGR\PropertyNotFoundException;

class Properties{
	private $fileName;
	private $properties=array();
	
	public function __construct($fileName, $sections = FALSE){
		$this->fileName = $fileName;
		$this->properties = parse_ini_file($this->fileName, $sections);
	}
	public function getFileName(){
		return $this->fileName;
	} 
	public function __get($name) {
        if (array_key_exists($name, $this->properties))
            return $this->properties[$name];
        else 
        	throw  new PropertyNotFoundException("Property '$name' not found");
	}
    public function __isset($name) {
        return array_key_exists($name, $this->properties);
    }		
	public function getProperty($name){
		return $this->$name;
	}
}
?>