<?php
require_once('Swapper.php');
require_once('User.php');


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


$sortedUserList = $x->orderBy($userList, [ "prenom", "nom"], 'asc');

dd($sortedUserList);
// var_dump($sortedUserList);
// dd(get_class_vars("User"));

$stringPropertiesUserList = [];
for ($i=0; $i < sizeof($userList); $i++) { 
    return $userList[$i]->$propertyListToString();
}
?>
