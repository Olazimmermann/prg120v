<?php 

?>
<h3>Registrer student </h3>
<form method="post" action="" id="registrerStudentSkjema" name="registrerStudentSkjema">
    Brukernavn <input type="text" id="brukernavn" name="brukernavn" required /> <br/>
    Fornavn <input type="text" id="fornavn" name="fornavn" required /> <br/>
    Etternavn <input type="text" id="etternavn" name="etternavn" required /> <br/>
    Klassekode <select name="klassekode" id="klassekode">
    <?php print("<option value=''>velg klassekode </option>");
    include("dynamiske-funksjoner.php"); listeboksklassekode(); ?>
    </select> <br/>
        <input type="submit" value="Registrer student" id="registrerStudentKnapp" name="registrerStudentKnapp" />
        <input type="reset" value="Nullstill" id="nullstill" name="nullstill" /> <br />
</form>

<?php
if(isset($_POST ["registrerStudentKnapp"])) {
    $brukernavn=$_POST ["brukernavn"];
    $fornavn=$_POST ["fornavn"];
    $etternavn=$_POST ["etternavn"];
    $klassekode=$_POST ["klassekode"];
    if (!$brukernavn || !$fornavn || !$etternavn || !$klassekode) {
        print ("Alle felt m&aring; fylles ut");
    } else {
        include("db-tilkobling.php"); /* tilkobling til database-serveren utført og valg av database foretatt */
        $sqlSetning="SELECT * FROM student WHERE brukernavn='$brukernavn';";
        $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");
        $antallRader=mysqli_num_rows($sqlResultat);
        if ($antallRader!=0) /* studenten er registrert fra før */ {
            print ("Studenten er registrert fra f&oslashr");
        } else {
            $sqlSetning="INSERT INTO student (brukernavn,fornavn, etternavn, klassekode)
            VALUES('$brukernavn','$fornavn', '$etternavn','$klassekode');";
            mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; registrere data i databasen");
            print ("F&oslash;lgende student er n&aring; registrert: $brukernavn $fornavn $etternavn $klassekode");
        }
    }
}


?> 
