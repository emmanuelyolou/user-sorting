<?php
require_once('Swapper.php');
require_once('User.php');
require_once('StringHelper.php');


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

$stringPropertiesUserList = [];
$userPropertyList = [];
for ($i=0; $i < sizeof($userList); $i++) { 
  $stringPropertiesUserList[] = StringHelper::propertyListToString($userList[$i]); 
}

echo "<br><br>";
// dd($userList);

$recherche = "coulibaly j c";
echo "<br><br> recherche: \"$recherche\" <br><br>";
dd(StringHelper::filterObjectList("$recherche", $sortedUserList));
echo "<br><br>";
// echo preg_match("#\sabc$#", " fabcefg efg g abhc gabc ");

$a = [1,2,3,4,5,6,7];
// dd($a);
unset($a[0]);
unset($a[6]);
// dd($a);
?>
