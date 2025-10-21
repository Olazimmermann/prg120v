<?php
echo "<h1>Hei, verden!</h1>";
?>

<?php
// Dette er en veldig enkel PHP-side med en knapp

// Sjekk om brukeren har trykket på knappen
if (isset($_POST["trykk"])) {
    $melding = "Du trykket på knappen 👍";
} else {
    $melding = "";
}
?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Min første knapp</title>
</head>
<body>
    <h1>Hei, Ola!</h1>
    <p>Dette er min første PHP-side 🚀</p>

    <!-- Skjema med en knapp -->
    <form method="post">
        <button type="submit" name="trykk">Trykk meg</button>
    </form>

    <!-- Vis melding hvis knappen ble trykket -->
    <p><?php echo $melding; ?></p>
</body>
</html>


<?php
// Viser feilmeldinger (nyttig under testing)
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Database-informasjon (Dokploy bruker miljøvariabler)
$tjener = getenv("DB_HOST") ?: "localhost";
$database = getenv("DB_NAME") ?: "skole";
$bruker = getenv("DB_USER") ?: "root";
$passord = getenv("DB_PASS") ?: "";

// Prøv å koble til databasen
try {
    $kobling = new PDO("mysql:host=$tjener;dbname=$database;charset=utf8", $bruker, $passord);
    $kobling->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<h1>✅ Koblet til databasen!</h1>";
} catch (PDOException $e) {
    die("<p>❌ Feil ved tilkobling: " . $e->getMessage() . "</p>");
}

// CREATE TABLE-setning fra oppgaven
$sql = "
CREATE TABLE IF NOT EXISTS klasse (
  klassekode CHAR(5) NOT NULL,
  klassenavn VARCHAR(50) NOT NULL,
  studiumkode VARCHAR(50) NOT NULL,
  PRIMARY KEY (klassekode)
);
";

try {
    $kobling->exec($sql);
    echo "<p>✅ Tabell <b>klasse</b> er klar!</p>";
} catch (PDOException $e) {
    echo "<p>❌ Feil ved oppretting av tabell: " . $e->getMessage() . "</p>";
}
?>

