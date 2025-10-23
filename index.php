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

    $sql = "SELECT * FROM `klasse`;";

    $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");
    /* SQL-setning sendt til database-serveren */

    if (mysqli_num_rows($sqlResultat) > 0) {
        while ($rad = mysqli_fetch_assoc($sqlResultat)) {
            echo "ID: " . $rad["id"] . " - Navn: " . $rad["navn"] . "<br>";
        }
    } else {
        echo "Ingen resultater funnet.";
    }

    mysqli_close($db);
?>