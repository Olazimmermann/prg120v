<h3>Registrer klasse</h3>

<form method="post" action="" id="registrerKlasseSkjema" name="registrerKlasseSkjema">
    Klassekode: <input type="text" id="klassekode" name="klassekode" required><br>
    Klassenavn: <input type="text" id="klassenavn" name="klassenavn" required><br>
    Studiumkode: <input type="text" id="studiumkode" name="studiumkode" required><br>
    <input type="submit" id="registrerKlasseKnapp" name="registrerKlasseKnapp" value="Registrer klasse">
</form>

<button type="button" onclick="window.location.href='obl-oppgave.html'">Tilbake</button><br>


<?php
include ("db-tilkobling");

if (isset($_POST["registrerKlasseKnapp"])) {
    $klassekode = strtoupper($_POST["klassekode"]);
    $klassenavn = $_POST["klassenavn"];
    $studiumkode = strtoupper($_POST["studiumkode"]);


    if (!$klassekode || !$klassenavn || !$studiumkode) {
        print ("Alle felt må fylles ut");
    }
    else {

        $sqlSetning = "SELECT * FROM klasse WHERE klassekode='$klassekode';";
        $sqlResultat = mysqli_query($db, $sqlSetning) or die ("Ikke mulig å hente data fra databasen");
        $antallRader = mysqli_num_rows($sqlResultat);

        if ($antallRader != 0) {
            print ("Klassekode: \"$klassekode\" er allerede registrert med klassenavn: \"$klassenavn\" og studiekode: \"$studiumkode\" i databasen.");
        }
        else {
            $sqlSetning = "INSERT INTO klasse (klassekode, klassenavn, studiumkode) VALUES ('$klassekode', '$klassenavn', '$studiumkode');";
            mysqli_query($db, $sqlSetning) or die ("Ikke mulig å registrere data i databasen");

            print ("Følgende er lagt til i databasen:<br>Klassekode: $klassekode<br>Klassenavn: $klassenavn<br>Studiumkode: $studiumkode<br>");
        }


    }
}
?> 
