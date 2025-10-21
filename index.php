<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

$DB_HOST = getenv('DB_HOST') ?: 'localhost';
$DB_NAME = getenv('DB_NAME') ?: 'skole';
$DB_USER = getenv('DB_USER') ?: 'root';
$DB_PASS = getenv('DB_PASS') ?: '';
$dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4";

try {
  $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);
} catch (Throwable $e) {
  die("DB-feil: " . h($e->getMessage()));
}

try {
  // 1) Lag tabellene hvis de ikke finnes (nøyaktig som i oppgaven)
  $pdo->exec("
    CREATE TABLE IF NOT EXISTS klasse (
      klassekode CHAR(5) NOT NULL,
      klassenavn VARCHAR(50) NOT NULL,
      studiumkode VARCHAR(50) NOT NULL,
      PRIMARY KEY (klassekode)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  ");

  $pdo->exec("
    CREATE TABLE IF NOT EXISTS student (
      brukernavn CHAR(7) NOT NULL,
      fornavn VARCHAR(50) NOT NULL,
      etternavn VARCHAR(50) NOT NULL,
      klassekode CHAR(5) NOT NULL,
      PRIMARY KEY (brukernavn),
      FOREIGN KEY (klassekode) REFERENCES klasse(klassekode)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  ");

  // 2) (Valgfritt) Fyll på noen startdata hvis tomt
  if ((int)$pdo->query("SELECT COUNT(*) FROM klasse")->fetchColumn() === 0) {
    $pdo->exec("
      INSERT INTO klasse (klassekode, klassenavn, studiumkode) VALUES
      ('IT1','IT og ledelse 1. år','ITLED'),
      ('IT2','IT og ledelse 2. år','ITLED'),
      ('IT3','IT og ledelse 3. år','ITLED');
    ");
  }

  if ((int)$pdo->query("SELECT COUNT(*) FROM student")->fetchColumn() === 0) {
    $pdo->exec("
      INSERT INTO student (brukernavn, fornavn, etternavn, klassekode) VALUES
      ('gb','Geir','Bjarvin','IT1'),
      ('mrj','Marius','R. Johannessen','IT1'),
      ('tb','Tove','Bøe','IT2');
    ");
  }

  echo "<p>✅ Tabeller er opprettet (hvis de ikke fantes), og startdata er satt inn.</p>";
  echo '<p><a href="index.php">Tilbake til appen</a></p>';
} catch (Throwable $e) {
  echo "<p>❌ Feil: " . h($e->getMessage()) . "</p>";
}
