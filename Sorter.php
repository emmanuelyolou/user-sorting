<?php

/**
 * Sorter 
 * Permits sorting a list of objetcs based on their properties
 */
class Sorter {
    
    public function filter(
        array $listToProcess, 
        String $searchedString = '', 
        String $orderDirection = "asc",
        array $propertyListToOrder = []
    ){
        $filteredList = $this->filterObjectList($searchedString, $listToProcess);
        $filteredList = $this->orderBy($filteredList, $orderDirection, $propertyListToOrder);
        return $filteredList;
    }

    //listToFilter must be an array of strings
    public function filterObjectList(String $searchedString, array $objectListToFilter){
        $filteredList = []; 
        for ($i=0; $i < sizeof($objectListToFilter); $i++) { 
            $propertyListToString = $this->propertyListToString($objectListToFilter[$i]);
            //If the string combining the object properties match the searchedString, it's added to the result
            if($this->AllWordsExistIn($searchedString, $propertyListToString)){
                $filteredList[] = $objectListToFilter[$i];
            }
        }
        return $filteredList;
    }

    public function orderBy(array $userList, String $order = 'asc', array $propertyList = []){
        if(sizeof($userList) == 0){
            return;
        }
        $className = get_class($userList[0]);
        $classPropertyList = array_keys(get_class_vars($className));
        
        //By default, if no property is mentionned, we consider all the properties
        if(sizeof($propertyList) == 0){
            $propertyList = $classPropertyList;
        }
        else{
            for ($i=0; $i < sizeof($propertyList); $i++) {
                if( !in_array( $propertyList[$i], $classPropertyList ) ){
                    throw new Exception("Property $propertyList[$i] does not exist." );
                }
            }
        }
        
        for ($i=0; $i < sizeof($userList) - 1; $i++) { 
            //$IsInOrder permits to optimize the bubble sort algorithm
            $isInOrder = true;

            for ($j = $i + 1; $j < sizeof($userList); $j++ ) { 
                $isComparisonFinished = false;
                $k = 0;
                //We check if the properties are in descending order and store the result in a bool variable
                while(!$isComparisonFinished && $k < sizeof($propertyList)){
                    $property = $propertyList[$k];
                    $arePropsInAscOrder = strcasecmp($userList[$i]->$property, $userList[$j]->$property) < 0;
                    $arePropsEqual = strcasecmp($userList[$i]->$property, $userList[$j]->$property) == 0;

                    if($arePropsEqual) {
                        $k++;
                    }
                    else{
                        $isComparisonFinished = true;
                        if($order == "desc" && $arePropsInAscOrder) {
                            $this->swap($userList[$i], $userList[$j]);
                            $isInOrder = false;
                        }
                        elseif($order == "asc" && !$arePropsInAscOrder){
                            $this->swap($userList[$i], $userList[$j]);
                            $isInOrder = false;
                        }
                        elseif(!in_array($order, ["asc", "desc"]) && !$arePropsInAscOrder){
                            //If the specified order is neither 'asc' nor 'desc', act like it's 'asc' by default.
                            $this->swap($userList[$i], $userList[$j]);
                            $isInOrder = false;
                        }
                    }
                }
            }
            if($isInOrder){
                break;
            }
        }
        return $userList;
    }


    //STRING PROCESSING METHODS
    
    public function propertyListToString($object, array $propertyList = [], String $sep = " "){
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
    public function AllWordsExistIn(String $searchedString, String $randomString){
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
    
    public function wordsExistIn(String $searchedString, String $randomString){
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


    //UTILITES METHODS
    
    public function swap(&$object1, &$object2 ){
        $temp = clone $object1;
        $object1 =  clone $object2;
        $object2 = clone $temp;
    }
}