<?php     /*Klasse*/

$klassekode=$_POST["klassekode"];
$klassenavn=$_POST["klassenavn"];
$studiumkode=$_POST["studiumkode"];
if (isset($_POST["fortsett"])) {
    echo "Klassekode: " . $klassekode . "<br />";
    echo "Klassenavn: " . $klassenavn . "<br />";
    echo "Studiumkode: " . $studiumkode . "<br />";
}


?>
