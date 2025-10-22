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
 ?>

<?php
// ---- PHP-delen ----
// Denne delen kjører på serveren og håndterer lagring til databasen

// Koble til databasen (Dokploy bruker miljøvariabler)
$host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'skole';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Feil ved tilkobling: " . $e->getMessage());
}

// Hvis skjemaet er sendt inn
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $klassekode = $_POST['klassekode'] ?? '';
    $klassenavn = $_POST['klassenavn'] ?? '';
    $studiumkode = $_POST['studiumkode'] ?? '';

    // Sjekk at feltene ikke er tomme
    if ($klassekode && $klassenavn && $studiumkode) {
        $stmt = $pdo->prepare("INSERT INTO klasse (klassekode, klassenavn, studiumkode) VALUES (?, ?, ?)");
        $stmt->execute([$klassekode, $klassenavn, $studiumkode]);
        $melding = "✅ Klassen '$klassekode' ble lagret!";
    } else {
        $melding = "⚠️ Du må fylle ut alle feltene.";
    }
}
?>

<!-- ---- HTML-delen ---- -->
<!DOCTYPE html>
<html lang="no">
<head>
  <meta charset="UTF-8">
  <title>Registrer klasse</title>
</head>
<body>
  <h1>Registrer en ny klasse</h1>

  <!-- Skjemaet brukeren ser -->
  <form method="post">
    <label>Klassekode:</label><br>
    <input type="text" name="klassekode" maxlength="5" required><br><br>

    <label>Klassenavn:</label><br>
    <input type="text" name="klassenavn" maxlength="50" required><br><br>

    <label>Studiumkode:</label><br>
    <input type="text" name="studiumkode" maxlength="50" required><br><br>

    <button type="submit">Lagre</button>
  </form>

  <!-- Meldingen fra PHP vises her -->
  <p style="margin-top:20px; color:green;">
    <?php echo $melding ?? ''; ?>
  </p>
</body>
</html>
