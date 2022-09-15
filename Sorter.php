<?php

/**
 * Sorter 
 * Permits sorting a list of objetcs by their properties
 */
class Sorter {
    /**
     * filter
     *Takes an array of objects, a string, an order direction ( 'asc' | 'desc') 
     *a string to match and an array of properties. It returns an array of objects
     *sorted in the specified order, by the specified properties and which properties 
     *match the given string
     *  @param array $listToProcess
     * @param string $searchedString
     * @param string $orderDirection
     * @param array $propertyListToOrder
     * @return array
     */
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
        $order = strtolower($order);

        // We only keep objects that possess all the listed properties
        $returnedUserList = [];
        for ($i=0; $i < sizeof($userList); $i++) { 
            if(sizeof( array_diff( $propertyList, array_keys(get_object_vars($userList[$i])))) == 0) {
                $returnedUserList[] = $userList[$i];
            }
        }

        for ($i=0; $i < sizeof($returnedUserList) - 1; $i++) { 

            //$IsInOrder permits to optimize the bubble sort algorithm
            // $isInOrder = true;

            for ($j = $i + 1; $j < sizeof($returnedUserList); $j++ ) { 
                $isComparisonFinished = false;
                $k = 0;
                //We check if the properties are in descending order and store the result in a bool variable
                while(!$isComparisonFinished && $k < sizeof($propertyList)){
                    $property = $propertyList[$k];

                    if($this->isDate($returnedUserList[$i]->$property)){
                        $arePropsInAscOrder = $this->formatDate($returnedUserList[$i]->$property) < $this->formatDate($returnedUserList[$j]->$property);
                    }
                    elseif($this->isDateTime($returnedUserList[$i]->$property)){
                        $arePropsInAscOrder = $this->dateTimeToDate($returnedUserList[$i]->$property) < $this->dateTimeToDate($returnedUserList[$j]->$property);
                    }
                    else{
                        $arePropsInAscOrder = strcasecmp($returnedUserList[$i]->$property, $returnedUserList[$j]->$property) < 0;
                    }
                    $arePropsEqual = strcasecmp($returnedUserList[$i]->$property, $returnedUserList[$j]->$property) == 0;

                    if($arePropsEqual) {
                        $k++;
                    }
                    else{
                        $isComparisonFinished = true;
                        if($order == "desc" && $arePropsInAscOrder) {
                            $this->swap($returnedUserList[$i], $returnedUserList[$j]);
                            // $isInOrder = false;
                        }
                        elseif($order == "asc" && !$arePropsInAscOrder){
                            $this->swap($returnedUserList[$i], $returnedUserList[$j]);
                            // $isInOrder = false;
                        }
                    }
                }
            }
            // if($isInOrder){
            //     echo "<br>i = $i et j = $j <br>";
            //     echo sizeof($returnedUserList);
            //     break;
            // }
        }
        return $returnedUserList;
    }


    //STRING PROCESSING METHODS
    
    public function propertyListToString($object, array $propertyList = [], String $sep = " "){
        try {
            $classPropertyList = array_keys(get_object_vars($object));
            
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

    /**
     * isDate
     * Checks if a given string is a valid date and respects the specified format
     * @param string $date
     * @param string $format
     * @return bool
     */       
    function isDate($date, $format = 'd-m-Y')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }   

    function isDateTime($dateTime, $format = 'd-m-Y H:i:s')
    {
        $d = DateTime::createFromFormat($format, $dateTime);
        return $d && $d->format($format) == $dateTime;
    }
           
    function formatDate($date, $format = 'd-m-Y')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d->format('Y-m-d');
    }
    function dateTimeToDate($date, $format = 'd-m-Y H:i:s'){
        $d = DateTime::createFromFormat($format, $date);
        return $d->format('Y-m-d H:i:s');
    }
}