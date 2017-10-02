<?php
namespace Kros\PropertiesMGR;

require_once 'PropertyNotFoundException.php';

use Kros\PropertiesMGR\PropertyNotFoundException;

/**
 * Represents an object with one property for each key in a key/value pairs file.
 * The file shoud have the following structure:
 * 
 *    ; comentario
 *   
 *    [seccion1]
 *    hola=caracola
 *    adios=caracol
 *    [seccion2]
 *    prop1=valor1
 *    prop2=valor2
 */
class Properties{
	private $fileName;
	private $properties=array();
	private $sections;
	
	/**
	 * Construct method
	 * 
	 * @param string $fileName File name containing the key/value pairs to be loaded or an array of properties.
	 * @param boolean $sections Optional. If True, each property in the object is a secction of the file.
	 *                          Every key/value pair is an array element in the right section property. 
	 * @return Properties Return a Properies object filled with the data in the file $fileName. When using
	 *                    seccions, each property is a Properties object, So the way to get a property value is like this:
	 *                    value = object->section->key.
	 */
	public function __construct($fileName, $sections = FALSE, $props = null){
		$this->fileName = $fileName;
		$this->sections = $sections;
		if ($props!=null && is_array($props)){
			$this->properties=$props;
		}else{
			$this->properties = parse_ini_file($this->fileName, $sections);
		}
	}
	
	/**
	 * Get the file name used to build the object
	 */
	public function getFileName(){
		return $this->fileName;
	}
	
	public function __get($name) {
        if (array_key_exists($name, $this->properties))
			if (is_array($this->properties[$name])){
				return new Properties($this->fileName, $this->sections, $this->properties[$name]);
			}else{
				return $this->properties[$name];
			}
        else 
        	throw  new PropertyNotFoundException("Property '$name' not found");
	}
	
 	public function __isset($name) {
		return array_key_exists($name, $this->properties);
	}	
    	
	/**
	 * Get a property in the object
	 * 
	 * @param string $name Name of the property.
	 */
	public function getProperty($name){
		return $this->$name;
	}
	
	/**
	* Return the array of properties
	*/
	public function asArray(){
		return $this->properties;
	}
}
?>
