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

    // Searches all the words from $searchString in $randomString
    static public function AllWordsExistIn(String $searchedString, String $randomString){
        $randomStringWordList = explode(" ", $randomString);
        $searchedWordList = explode(" ", $searchedString);

        for ($i=0; $i < sizeof( $searchedWordList ); $i++) {
            //Apart from the last word, all words must match entirely 
            if($i != sizeof($searchedWordList) - 1){
                $searchedWord = $searchedWordList[$i];
                if(!in_array( strtolower($searchedWord), array_map('strtolower', $randomStringWordList))){
                    return false;
                }
                else{
                    unset($randomStringWordList[$i + 1]);
                    $randomString = implode(" ", $randomStringWordList);
                }
            }
            else{
                // We assume the last word may not be complete and therefore, search
                // for a partial match
                $regex = "#\b$searchedWordList[$i]#i";
                if (!preg_match( $regex, $randomString)) {
                    return false;
                }
            }
        }
        return true;
    }
    
    static public function wordsExistIn(String $searchedString, String $randomString){
        /**Checks if the words contained in the searchedString exist in the $randomString,
         *following special criterias */
        $searchedWordList = explode(" ", $searchedString);
        for ($i=0; $i < sizeof( $searchedWordList ); $i++) { 
            //Checking for for all words in $searchString if there are words starting by it in the $randomString
            $regex = "#\b$searchedWordList[$i]#i";
            if (!preg_match( $regex, $randomString)) {
                return false;
            }
        }
        return true;
    }

    //listToFilter must be an array of strings
    static public function filterObjectList(String $searchedString, array $objectListToFilter){
        $filteredList = []; 
        for ($i=0; $i < sizeof($objectListToFilter); $i++) { 
            $propertyListToString = StringHelper::propertyListToString($objectListToFilter[$i]);
            //If the string combining the object properties match the searchedString, it's added to the result
            if(StringHelper::AllWordsExistIn($searchedString, $propertyListToString)){
                $filteredList[] = $objectListToFilter[$i];
            }
        }
        return $filteredList;
    }

    //listToFilter must be an array of strings
    static public function filterStringList(String $searchedString, array $listToFilter){
        $filteredList = []; 
        for ($i=0; $i < sizeof($listToFilter); $i++) { 
            if(StringHelper::AllWordsExistIn($searchedString, $listToFilter[$i])){
                $filteredList[] = $listToFilter[$i];
            }
        }
        return $filteredList;
    }
}
?>