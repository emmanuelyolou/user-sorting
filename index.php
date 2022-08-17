<?php
require_once('User.php');
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


// $sortedUserList = $x->orderBy($userList, 'desc', [ "prenom", "nom"]);

$stringPropertiesUserList = [];
$userPropertyList = [];
// echo "<br><br>";
// dd($userList);

// $recherche = "coulibaly j c";
// echo "<br><br> recherche: \"$recherche\" <br><br>";
// dd(StringHelper::filterObjectList("$recherche", $sortedUserList));
// echo "<br><br>";

// // dd($userList);
// echo "<br><br>";
// echo "<br><br>";
// dd($sortedUserList);
// dd($a);
// dd($userList);
$h = new Sorter();
// $filteredList = $h->filter($userList, "", 'desc', ['prenom', 'nom']);
// dd($filteredList);

// var_dump($h->formatDate("10-02-0002"));

// dd(array_diff(
//   ["a", "d"],
//   ['a', "b", "c"]
// ));

$a = array (
  0 => 
  (object) array(
     'id_compte' => 'CPT916E780R',
     'nom_compte' => 'Ve',
     'prenom_compte' => 'Sinde Guy Vianney',
     'email_compte' => '',
     'phone1_compte' => '0709432329',
     'numeroPasseport_compte' => '29038383',
     'password_compte' => 'Xcanada24',
     'dateIn_compte' => '19-06-2022 10:50:19',
     'id_compte__compteAdmin' => NULL,
  ),
  1 => 
  (object) array(
     'id_compte' => 'UG6WRS07C',
     'nom_compte' => 'Aka',
     'prenom_compte' => 'Michele',
     'phone1_compte' => '0709685967',
     'dateIn_compte' => '09-08-2022 17:28:43',
  ),
  2 => 
  (object) array(
     'id_compte' => 'UULIWH0QS',
     'nom_compte' => 'Sinde',
     'prenom_compte' => 'Ve Adolphe',
     'phone1_compte' => '0708090910',
     'dateIn_compte' => '09-08-2022 17:00:24',
  ),
  3 => 
  (object) array(
     'id_compte' => 'UH3UC7MWD',
     'nom_compte' => 'Djella',
     'prenom_compte' => 'Konan Emmanuel',
     'phone1_compte' => '0777113543',
     'dateIn_compte' => '09-08-2022 16:59:52',
  ),
);
// var_dump($a);
// dd($h->filter($a, "", "", ["nomdsghdsgjds"]));
dd($h->orderBy($a, "desc", ["prenom_compte", "nom_compte", "phone1_compte"]));
// dd($h->propertyListToString($a[0]));
// var_dump(get_object_vars($a[0]));
// dd(array_keys(get_object_vars($a[0])));

// $j = 0;
// for ($i=0; $i < 10; $i++) { 
//   echo "<br>i = ". $i;
//   if($i == 9){
//     if($j == 5){
//       break;
//     }
//     $i = 6;
//     $j++;
//     continue;
//   }
// }

?>
