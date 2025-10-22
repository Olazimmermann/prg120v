<?php
// Enkel kode for å vise innholdet i tabellen "klasse"

// Koblingsinformasjon
$tjener = getenv("DB_HOST") ?: "localhost";
$bruker = getenv("DB_USER") ?: "root";
$passord = getenv("DB_PASS") ?: "";
$database = getenv("DB_NAME") ?: "skole";

// Koble til databasen
$kobling = new mysqli($tjener, $bruker, $passord, $database);

// Sjekk om tilkoblingen fungerer
if ($kobling->connect_error) {
    die("<p>❌ Feil ved tilkobling: " . $kobling->connect_error . "</p>");
}

echo "<h1>✅ Koblet til databasen!</h1>";

// Hent alt fra tabellen "klasse"
$sql = "SELECT * FROM klasse";
$resultat = $kobling->query($sql);

// Sjekk om tabellen har innhold
if ($resultat->num_rows > 0) {
    echo "<h2>📋 Innhold i tabellen 'klasse':</h2>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Klassekode</th><th>Klassenavn</th><th>Studiumkode</th></tr>";

    // Vis radene
    while ($rad = $resultat->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$rad['klassekode']}</td>";
        echo "<td>{$rad['klassenavn']}</td>";
        echo "<td>{$rad['studiumkode']}</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>⚠️ Tabellen 'klasse' er tom.</p>";
}

$kobling->close();
?>
