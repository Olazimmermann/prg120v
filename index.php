<?php
/* ========= ENKEL CRUD I ÉN FIL =========
   Miljøvariabler (sett i Dokploy): DB_HOST, DB_NAME, DB_USER, DB_PASS
   Funksjoner: registrer/vis/slett for klasse og student + engangsknapp for å opprette tabeller
======================================== */

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
  http_response_code(500);
  die("DB-feil: " . h($e->getMessage()));
}

function klasser(PDO $pdo){ return $pdo->query("SELECT * FROM klasse ORDER BY klassekode")->fetchAll(); }
function studenter(PDO $pdo){
  return $pdo->query("SELECT s.brukernavn,s.fornavn,s.etternavn,s.klassekode,k.klassenavn
                      FROM student s JOIN klasse k ON k.klassekode=s.klassekode
                      ORDER BY s.brukernavn")->fetchAll();
}

$msg = null; $err = null;
$view = $_GET['view'] ?? 'home';

/* ---------- Engangsknapp: Opprett tabeller ---------- */
if (isset($_GET['install'])) {
  try {
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
    $msg = "Tabeller er opprettet (hvis de ikke fantes).";
  } catch (Throwable $e) {
    $err = $e->getMessage();
  }
}

/* ---------- POST-håndtering ---------- */
if ($_SERVER['REQUEST_METHOD']==='POST') {
  try {
    if (isset($_POST['ny_klasse'])) {
      $stmt = $pdo->prepare("INSERT INTO klasse (klassekode,klassenavn,studiumkode) VALUES (?,?,?)");
      $stmt->execute([trim($_POST['klassekode']), trim($_POST['klassenavn']), trim($_POST['studiumkode'])]);
      $msg = "Klasse registrert.";
      $view = 'vis_klasser';
    }
    if (isset($_POST['slett_klasse'])) {
      $kode = $_POST['klassekode'] ?? '';
      if ($kode==='') throw new Exception('Velg en klasse.');
      $c = $pdo->prepare("SELECT COUNT(*) FROM student WHERE klassekode=?");
      $c->execute([$kode]);
      if ($c->fetchColumn()>0) throw new Exception("Kan ikke slette: studenter er tilknyttet.");
      $del = $pdo->prepare("DELETE FROM klasse WHERE klassekode=?");
      $del->execute([$kode]);
      $msg = "Klasse slettet.";
      $view = 'vis_klasser';
    }
    if (isset($_POST['ny_student'])) {
      $stmt = $pdo->prepare("INSERT INTO student (brukernavn,fornavn,etternavn,klassekode) VALUES (?,?,?,?)");
      $stmt->execute([trim($_POST['brukernavn']), trim($_POST['fornavn']), trim($_POST['etternavn']), trim($_POST['klassekode'])]);
      $msg = "Student registrert.";
      $view = 'vis_studenter';
    }
    if (isset($_POST['slett_student'])) {
      $bn = $_POST['brukernavn'] ?? '';
      if ($bn==='') throw new Exception('Velg en student.');
      $del = $pdo->prepare("DELETE FROM student WHERE brukernavn=?");
      $del->execute([$bn]);
      $msg = "Student slettet.";
      $view = 'vis_studenter';
    }
  } catch (Throwable $e) { $err = $e->getMessage(); }
}

/* ---------- Data til skjema ---------- */
$klasser = [];
$studenter = [];
try { $klasser = klasser($pdo); $studenter = studenter($pdo); } catch(Throwable $e){ /* ignorer hvis tabeller ikke finnes enda */ }
?>
<!doctype html>
<html lang="no">
<head>
<meta charset="utf-8">
<title>Vedlikehold: klasse & student (enkelt)</title>
<style>
body{font-family:Arial,Helvetica,sans-serif;margin:20px;background:#f7f7fb}
nav a{margin-right:10px}
table{border-collapse:collapse;width:100%;margin-top:10px}
th,td{border:1px solid #ddd;padding:6px;text-align:left}
.m{background:#e9fbea;border:1px solid #b6e7bf;padding:8px;margin:8px 0}
.e{background:#ffecec;border:1px solid #f5b5b5;padding:8px;margin:8px 0}
input,select{padding:6px}
button{padding:6px 10px;margin-top:6px}
</style>
</head>
<body>
<h1>Vedlikehold (CRUD) – Klasse & Student</h1>

<nav>
  <a href="?view=home">Hjem</a>
  <a href="?view=ny_klasse">Registrer klasse</a>
  <a href="?view=vis_klasser">Vis klasser</a>
  <a href="?view=slett_klasse">Slett klasse</a>
  <a href="?view=ny_student">Registrer student</a>
  <a href="?view=vis_studenter">Vis studenter</a>
  <a href="?view=slett_student">Slett student</a>
  <a href="?install=1" onclick="return confirm('Opprett tabeller? Kjøres normalt bare én gang.');">Opprett tabeller (engangsknapp)</a>
</nav>

<?php if($msg): ?><div class="m"><?=h($msg)?></div><?php endif; ?>
<?php if($err): ?><div class="e"><?=h($err)?></div><?php endif; ?>

<?php if ($view==='home'): ?>
  <p>Velg en funksjon over. Bruk “Opprett tabeller” én gang dersom tabellene ikke finnes.</p>
<?php endif; ?>

<?php if ($view==='ny_klasse'): ?>
  <h2>Registrer klasse</h2>
  <form method="post">
    <label>Klassekode (5): <input name="klassekode" maxlength="5" required></label><br>
    <label>Klassenavn: <input name="klassenavn" maxlength="50" required></label><br>
    <label>Studiumkode: <input name="studiumkode" maxlength="50" required></label><br>
    <button name="ny_klasse">Lagre</button>
  </form>
<?php endif; ?>

<?php if ($view==='vis_klasser'): ?>
  <h2>Alle klasser</h2>
  <table>
    <tr><th>Klassekode</th><th>Klassenavn</th><th>Studiumkode</th></tr>
    <?php foreach($klasser as $k): ?>
      <tr><td><?=h($k['klassekode'])?></td><td><?=h($k['klassenavn'])?></td><td><?=h($k['studiumkode'])?></td></tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>

<?php if ($view==='slett_klasse'): ?>
  <h2>Slett klasse</h2>
  <form method="post" onsubmit="return confirm('Slette valgt klasse?');">
    <select name="klassekode" required>
      <option value="">-- velg klasse --</option>
      <?php foreach($klasser as $k): ?>
        <option value="<?=h($k['klassekode'])?>"><?=h($k['klassekode'].' — '.$k['klassenavn'])?></option>
      <?php endforeach; ?>
    </select>
    <button name="slett_klasse">Slett</button>
  </form>
  <small>Merk: Kan ikke slettes hvis studenter er tilknyttet.</small>
<?php endif; ?>

<?php if ($view==='ny_student'): ?>
  <h2>Registrer student</h2>
  <form method="post">
    <label>Brukernavn (2–7): <input name="brukernavn" maxlength="7" required></label><br>
    <label>Fornavn: <input name="fornavn" maxlength="50" required></label><br>
    <label>Etternavn: <input name="etternavn" maxlength="50" required></label><br>
    <label>Klasse:
      <select name="klassekode" required>
        <option value="">-- velg --</option>
        <?php foreach($klasser as $k): ?>
          <option value="<?=h($k['klassekode'])?>"><?=h($k['klassekode'].' — '.$k['klassenavn'])?></option>
        <?php endforeach; ?>
      </select>
    </label><br>
    <button name="ny_student">Lagre</button>
  </form>
<?php endif; ?>

<?php if ($view==='vis_studenter'): ?>
  <h2>Alle studenter</h2>
  <table>
    <tr><th>Brukernavn</th><th>Navn</th><th>Klassekode</th><th>Klassenavn</th></tr>
    <?php foreach($studenter as $s): ?>
      <tr>
        <td><?=h($s['brukernavn'])?></td>
        <td><?=h($s['fornavn'].' '.$s['etternavn'])?></td>
        <td><?=h($s['klassekode'])?></td>
        <td><?=h($s['klassenavn'])?></td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>

<?php if ($view==='slett_student'): ?>
  <h2>Slett student</h2>
  <form method="post" onsubmit="return confirm('Slette valgt student?');">
    <select name="brukernavn" required>
      <option value="">-- velg student --</option>
      <?php foreach($studenter as $s): ?>
        <option value="<?=h($s['brukernavn'])?>"><?=h($s['brukernavn'].' — '.$s['fornavn'].' '.$s['etternavn'])?></option>
      <?php endforeach; ?>
    </select>
    <button name="slett_student">Slett</button>
  </form>
<?php endif; ?>
</body>
</html>