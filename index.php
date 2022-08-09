<?php
require_once('Swapper.php');

class User{
    public $nom;
    public $prenom;

    public function __construct($nom = NULL, $prenom = NULL){
        $this->nom = $nom;
        $this->prenom = $prenom;
    }
    
    public function orderBy(array $userList, $order, $property){
        if($property != "nom" && $property != "prenom"){
            return;
        }
        if($order == 'desc'){
            return User::sortDesc($userList, $property);
        }
        else{
            return User::_sortAsc($userList, $property);
        }
    }

    static private function _sortAsc($userList, $property){
        for ($i=0; $i < sizeof($userList) - 1; $i++) { 
            for ($j = $i + 1; $j < sizeof($userList); $j++ ) { 
                if( strcasecmp($userList[$i]->$property, $userList[$j]->$property) > 0 ){
                    Swapper::swap($userList[$i], $userList[$j]);
                }
            }
        }
        return $userList;
    }


    static private function sortDesc($userList, $property){
        for ($i=0; $i < sizeof($userList) - 1; $i++) { 
            for ($j = $i + 1; $j < sizeof($userList); $j++ ) { 
                if( strcasecmp($userList[$i]->$property, $userList[$j]->$property) < 0 ){
                    Swapper::swap($userList[$i], $userList[$j]);
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
$b = new User("Coulibaly", "Jean pierre");
$c = new User("Zunon", "Marc");
$d = new User("Yao" ,"Aaron");
$e = new User("Sosthene", "francky");
$userList = [$a, $b, $c, $d, $e];
$x = new User();


$sortedUserList = $x->orderBy($userList, 'desc', "nom");

dd($sortedUserList);

?>