<?php
// Viser feilmeldinger (greit for studenter)
error_reporting(E_ALL);
ini_set("display_errors", 1);

// 1️⃣ Koble til databasen
// Disse verdiene legger du inn i Dokploy senere som miljøvariabler
$tjener = getenv("DB_HOST") ?: "localhost";   // Databaseserver
$bruker = getenv("DB_USER") ?: "root";        // Brukernavn
$passord = getenv("DB_PASS") ?: "";           // Passord
$database = getenv("DB_NAME") ?: "skole";     // Databasenavn

try {
  // Lager kobling til databasen
  $kobling = new PDO("mysql:host=$tjener;dbname=$database;charset=utf8", $bruker, $passord);
  $kobling->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "<p>✅ Koblet til databasen!</p>";
} catch (PDOException $e) {
  die("<p>❌ Feil ved tilkobling: " . $e->getMessage() . "</p>");
}

// 2️⃣ Opprett tabell for klasse
try {
  $sql1 = "
    CREATE TABLE IF NOT EXISTS klasse (
      klassekode CHAR(5) NOT NULL,
      klassenavn VARCHAR(50) NOT NULL,
      studiumkode VARCHAR(50) NOT NULL,
      PRIMARY KEY (klassekode)
    );
  ";
  $kobling->exec($sql1);
  echo "<p>✅ Tabell 'klasse' er klar!</p>";
} catch (PDOException $e) {
  echo "<p>❌ Feil ved oppretting av klasse-tabell: " . $e->getMessage() . "</p>";
}

// 3️⃣ Opprett tabell for student
try {
  $sql2 = "
    CREATE TABLE IF NOT EXISTS student (
      brukernavn CHAR(7) NOT NULL,
      fornavn VARCHAR(50) NOT NULL,
      etternavn VARCHAR(50) NOT NULL,
      klassekode CHAR(5) NOT NULL,
      PRIMARY KEY (brukernavn),
      FOREIGN KEY (klassekode) REFERENCES klasse(klassekode)
    );
  ";
  $kobling->exec($sql2);
  echo "<p>✅ Tabell 'student' er klar!</p>";
} catch (PDOException $e) {
  echo "<p>❌ Feil ved oppretting av student-tabell: " . $e->getMessage() . "</p>";
}

// 4️⃣ Ferdig!
echo "<p>🎉 Ferdig! Databasen er klar til bruk.</p>";
?>
