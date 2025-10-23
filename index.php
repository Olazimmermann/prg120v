Db-tilkobling: 
<?php  /* db-tilkobling */
/*
/*  Programmet foretar tilkobling til database-server og valg av database
*/
$host = getenv('DB_HOST');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$database = getenv('DB_DATABASE');

 $db=mysqli_connect($host,$username,$password,$database) or die ("ikke kontakt med database-server");
    /* tilkobling til database-serveren utført */
 ?>

<?php     /*Klasse*/

$klassekode=$_POST["klassekode"];
$klassenavn=$_POST["klassenavn"];
$studiumkode=$_POST["studiumkode"];
print("Klassekode: $klassekode <br />");
print("Klassenavn: $klassenavn <br />");
print("Studiumkode: $studiumkode <br />");

?>
