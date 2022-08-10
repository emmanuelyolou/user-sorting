<?php
require_once('Swapper.php');
require_once('User.php');
require_once('StringHelper.php');
require_once('Sorter.php');


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
$x = new Sorter();


$sortedUserList = $x->orderBy($userList, 'desc', [ "prenom", "nom"]);

$stringPropertiesUserList = [];
$userPropertyList = [];
for ($i=0; $i < sizeof($userList); $i++) { 
  $stringPropertiesUserList[] = StringHelper::propertyListToString($userList[$i]); 
}

echo "<br><br>";
// dd($userList);

// $recherche = "coulibaly j c";
// echo "<br><br> recherche: \"$recherche\" <br><br>";
// dd(StringHelper::filterObjectList("$recherche", $sortedUserList));
// echo "<br><br>";

// dd($userList);
echo "<br><br>";
echo "<br><br>";
// dd($sortedUserList);
// dd($a);
// dd($userList);
$h = new Sorter();
$filteredList = $h->filter($userList, "", 'desc', ['prenom', 'nom']);
dd($filteredList);
?>
