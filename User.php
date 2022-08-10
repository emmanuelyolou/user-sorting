<?php 
require_once('User.php');
class User{
    public $nom;
    public $prenom;

    public function __construct($nom = NULL, $prenom = NULL){
        $this->nom = $nom;
        $this->prenom = $prenom;
    }
    
    public function orderBy(array $userList, array $propertyList, String $order){
        $allowedProperties = [ "nom", "prenom"];
        for ($i=0; $i < sizeof($propertyList); $i++) { 
            if(!in_array($propertyList[$i], $allowedProperties)){
                //TODO: handle error
                return;
            }
        }
        
        for ($i=0; $i < sizeof($userList) - 1; $i++) { 
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
                        }
                        elseif($order == "asc" && !$arePropsInAscOrder){
                            Swapper::swap($userList[$i], $userList[$j]);
                        }
                        elseif(!in_array($order, ["asc", "desc"]) && !$arePropsInAscOrder){
                            //If the specified order is neither 'asc' nor 'desc', act like it's 'asc' by default.
                            Swapper::swap($userList[$i], $userList[$j]);
                        }
                    }
                }
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