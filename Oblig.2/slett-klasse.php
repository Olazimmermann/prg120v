<script src="funksjoner.js"> </script>
<h3>Slett klasse</h3>
<form method="post" action="" id="slettKlasseSkjema" name="slettKlasseSkjema" onsubmit="return bekreft()">
 Klasse: 
 <select name="klassekode" id="klassekode">
 <?php print("<option value=''>velg klasse </option>");

 include("dynamiske-funksjoner.php"); listeboksKlassekode(); ?>
 </select> <br/>

 <input type="submit" value="Slett klasse" name="slettKlasseKnapp" id="slettKlasseKnapp" />
</form>

<?php

 if (isset($_POST ["slettKlasseKnapp"]))
 {
 $klassekode=$_POST ["klassekode"];

 if (!$klassekode) {
 print ("Fyll ut klasse");
 }
 else
 {
 include("db-tilkobling.php");
 
 $sjekk = "SELECT * FROM student WHERE klassekode='$klassekode';";
 $resultat = mysqli_query($db, $sjekk);
 if (mysqli_num_rows($resultat) > 0) {
    print ("kan ikke slette klassen $klassekode fordi det er registrert studenter i denne klassen</br>");
 } else {
$sqlSetning="DELETE FROM klasse WHERE klassekode='$klassekode';";
mysqli_query($db, $sqlSetning) or die ("ikke mulig &aring; slette data fra databaseb");

if (mysqli_affected_rows($db) == 0) {
    print ("klassen $klassekode er slettet");
} else {
    print ("Ingen klassen $klassekode ble funnet");
}
 
 }
}
}
 
 
 ?>
