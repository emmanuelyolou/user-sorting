<?php 
require_once('User.php');
class User{
    public $nom;
    public $prenom;

    public function __construct($nom = NULL, $prenom = NULL){
        $this->nom = $nom;
        $this->prenom = $prenom;
    }
    
    public function orderBy(array $userList, String $order = 'asc', array $propertyList = []){
        if(sizeof($userList) == 0){
            return;
        }
        $className = get_class($userList[0]);
        $classPropertyList = array_keys(get_class_vars($className));
        
        for ($i=0; $i < sizeof($propertyList); $i++) {
            //First, we check if the properties in $propertyList exist in the class
            if( !in_array( $propertyList[$i], $classPropertyList ) ){
                throw new Exception("Property $propertyList[$i] does not exist." );
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
                            Swapper::swap($userList[$i], $userList[$j]);
                            $isInOrder = false;
                        }
                        elseif($order == "asc" && !$arePropsInAscOrder){
                            Swapper::swap($userList[$i], $userList[$j]);
                            $isInOrder = false;
                        }
                        elseif(!in_array($order, ["asc", "desc"]) && !$arePropsInAscOrder){
                            //If the specified order is neither 'asc' nor 'desc', act like it's 'asc' by default.
                            Swapper::swap($userList[$i], $userList[$j]);
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

    static public function display($userList){
        for ($i=0; $i < sizeof($userList); $i++) { 
            echo "{$userList[$i]->nom} <br>";
        }
    }

}