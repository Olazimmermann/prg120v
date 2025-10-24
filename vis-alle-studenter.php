<?php /* vis-alle-emner */
/*
/* Programmet skriver ut alle registrerte emner
*/

 include("db-tilkobling.php"); 
 $sqlSetning="SELECT * FROM student ORDER BY brukernavn;";
 $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

 $antallRader=mysqli_num_rows($sqlResultat); 
 print ("<h3>Registrerte studenter </h3>");
 print ("<table border=1>");
 print ("<tr><th align=left>Brukernavn</th> <th align=left>Fornavn</th><th align=left>Etternavn</th> <th align=left>Klassekode</th>
</tr>");
 for ($r=1;$r<=$antallRader;$r++) {
    $rad=mysqli_fetch_array($sqlResultat); 
    $brukernavn=$rad["brukernavn"];
    $fornavn=$rad["fornavn"];
    $etternavn=$rad["etternavn"]; 
    $klassekode=$rad["klassekode"];
    print ("<tr> <td> $brukernavn </td> <td> $fornavn </td> <td> $etternavn </td> <td> $klassekode </td> </tr>");
 }
    print ("</table>");

?> 
