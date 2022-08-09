<?php
require_once('Swapper.php');

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

    static private function sortDesc($userList, $propertyList){
        for ($i=0; $i < sizeof($userList) - 1; $i++) { 
            for ($j = $i + 1; $j < sizeof($userList); $j++ ) { 
                $isComparisonFinished = false;
                $k = 0;
                while(!$isComparisonFinished && $k < sizeof($propertyList)){
                    $property = $propertyList[$k];

                    if( strcasecmp($userList[$i]->$property, $userList[$j]->$property) < 0 ){
                        Swapper::swap($userList[$i], $userList[$j]);
                        $isComparisonFinished = true;
                    }
                    elseif( strcasecmp($userList[$i]->$property, $userList[$j]->$property) == 0){
                        $k++;
                    }
                    else{
                        $isComparisonFinished = true;
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
function dd($data){
    highlight_string("<?php\n " . var_export($data, true) . "?>");
    echo '<script>document.getElementsByTagName("code")[0].getElementsByTagName("span")[1].remove() ;document.getElementsByTagName("code")[0].getElementsByTagName("span")[document.getElementsByTagName("code")[0].getElementsByTagName("span").length - 1].remove() ; </script>';
    // die();
  }

$a = new User("Koffi", "ada");
$f = new User("Coulibaly", "Jasmine");
$b = new User("Bolloré", "ada");
$g = new User("Traoré", "ada");
$c = new User("Zunon", "Marc");
$e = new User("Zunon", "Didier");
$d = new User("Yao" ,"Aaron");
$h = new User("Coulibaly", "Cécile");

$userList = [$a, $b, $c, $d, $e, $f, $g, $h];
$x = new User();


$sortedUserList = $x->orderBy($userList, [ "nom", "prenom"], 'asc');

dd($sortedUserList);
// var_dump($sortedUserList);

?>