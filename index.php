<?php

class User{
    public $nom;
    public $prenom;

    public function __construct($nom = NULL, $prenom = NULL){
        $this->nom = $nom;
        $this->prenom = $prenom;
    }
    
    public function orderBy($userList, $order, $property){
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
                    $temp = clone $userList[$i];
                    $userList[$i] =  clone $userList[$j];
                    $userList[$j] = clone $temp;
                }
            }
        }
        return $userList;
    }


    static private function sortDesc($userList, $property){
        for ($i=0; $i < sizeof($userList) - 1; $i++) { 
            for ($j = $i + 1; $j < sizeof($userList); $j++ ) { 
                if( strcasecmp($userList[$i]->$property, $userList[$j]->$property) < 0 ){
                    $temp = clone $userList[$i];
                    $userList[$i] =  clone $userList[$j];
                    $userList[$j] = clone $temp;
                }
            }
        }
        return $userList;
    }

    // static public function exchangeUser($user1, $user2){
    //     $temp = clone $user1;
    //     $user1 = clone $user2;
    //     $temp = clone $user2;
    // }
    // static public function display($userList){
    //     for ($i=0; $i < sizeof($userList); $i++) { 
    //         echo "{$userList[$i]->nom} <br>";
    //     }
    // }

}
function dd($data){
    highlight_string("<?php\n " . var_export($data, true) . "?>");
    echo '<script>document.getElementsByTagName("code")[0].getElementsByTagName("span")[1].remove() ;document.getElementsByTagName("code")[0].getElementsByTagName("span")[document.getElementsByTagName("code")[0].getElementsByTagName("span").length - 1].remove() ; </script>';
    die();
  }

$a = new User("Koffi", "ada");
$b = new User("Coulibaly", "Jean pierre");
$c = new User("Zunon", "Marc");
$d = new User("Yao" ,"Aaron");
$e = new User("Sosthene", "francky");
$userList = [$a, $b, $c, $d, $e];
$x = new User();
$sortedUserList = $x->orderBy($userList, 'asc', "prenom");

dd($sortedUserList);

?>