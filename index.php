<?php
// Enkel test – koble til database og lage en tabell

// KONFIGURASJON (bytt ut hvis du tester lokalt)
$tjener = getenv("DB_HOST") ?: "localhost";
$bruker = getenv("DB_USER") ?: "root";
$passord = getenv("DB_PASS") ?: "";
$database = getenv("DB_NAME") ?: "skole";

try {
    // Koble til databasen
    $kobling = new mysqli($tjener, $bruker, $passord, $database);

    if ($kobling->connect_error) {
        die("❌ Feil ved tilkobling: " . $kobling->connect_error);
    } else {
        echo "<p>✅ Koblet til databasen!</p>";
    }

    // Lag tabellen hvis den ikke finnes
    $sql = "CREATE TABLE IF NOT EXISTS klasse (
        klassekode CHAR(5) NOT NULL,
        klassenavn VARCHAR(50) NOT NULL,
        studiumkode VARCHAR(50) NOT NULL,
        PRIMARY KEY (klassekode)
    )";

    if ($kobling->query($sql)) {
        echo "<p>✅ Tabell 'klasse' er klar!</p>";
    } else {
        echo "<p>❌ Feil ved oppretting av tabell: " . $kobling->error . "</p>";
    }

    // Legg inn én rad
    $sql = "INSERT IGNORE INTO klasse VALUES ('IT1', 'IT og ledelse 1. år', 'ITLED')";
    $kobling->query($sql);

    // Hent alle klasser
    $sql = "SELECT * FROM klasse";
    $resultat = $kobling->query($sql);

    echo "<h3>📋 Innhold i tabellen:</h3>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Klassekode</th><th>Klassenavn</th><th>Studiumkode</th></tr>";
    while ($rad = $resultat->fetch_assoc()) {
        echo "<tr><td>{$rad['klassekode']}</td><td>{$rad['klassenavn']}</td><td>{$rad['studiumkode']}</td></tr>";
    }
    echo "</table>";

} catch (Exception $e) {
    echo "<p>❌ Feil: " . $e->getMessage() . "</p>";
}
?>
