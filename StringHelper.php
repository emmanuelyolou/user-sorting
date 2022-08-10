<?php
class StringHelper{
  static public function stringStartsWith(String $needle, String $haystack){
    return substr($haystack, 0, strlen($needle));
  }  

  static public function propertyListToString($object, array $propertyList = [], String $sep = " "){
    try {
        $className = get_class($object);
        $classPropertyList = array_keys(get_class_vars($className));
        
        for ($i=0; $i < sizeof($propertyList); $i++) {
            //First, we check if the properties in $propertyList exist in the class
            if( !in_array( $propertyList[$i], $classPropertyList ) ){
                throw new Exception("Property $propertyList[$i] does not exist." );
            }
        }
        
        //By default, if no property is mentionned, we consider all the properties
        if(sizeof($propertyList) == 0){
            $propertyList = $classPropertyList;
        }
        
        $toString = '';
        for ($i = 0; $i < sizeof($propertyList); $i++){
            $property = $propertyList[$i];
            $toString = "{$toString}{$sep}{$object->$property}";
        }
        return $toString;
    } catch (\Throwable $th) {
        return $th;
    }
}

}
?>