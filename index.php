<?php
// --- DATABASEKOBLING ---
$host = getenv('b-studentsql-1.usn.no:3306'); 
$username = getenv('olbor4025'); 
$password = getenv('cfddolbor4025'); 
$database = getenv('olbor4025'); 

 $db=mysqli_connect($host,$username,$password,$database) or die ("ikke kontakt med database-server");
    /* tilkobling til database-serveren utført */

// --- LAGRE KLASSE ---
if (isset($_POST['lagre_klasse'])) {
    $kode = $_POST['klassekode'];
    $navn = $_POST['klassenavn'];
    $stud = $_POST['studiumkode'];
    $conn->query("INSERT INTO klasse VALUES ('$kode','$navn','$stud')");
    $msg = "Klasse lagret!";
}

// --- SLETT KLASSE ---
if (isset($_POST['slett_klasse'])) {
    $kode = $_POST['klassekode'];
    $conn->query("DELETE FROM klasse WHERE klassekode='$kode'");
    $msg = "Klasse slettet!";
}

// --- LAGRE STUDENT ---
if (isset($_POST['lagre_student'])) {
    $bruker = $_POST['brukernavn'];
    $fornavn = $_POST['fornavn'];
    $etternavn = $_POST['etternavn'];
    $kode = $_POST['klassekode'];
    $conn->query("INSERT INTO student VALUES ('$bruker','$fornavn','$etternavn','$kode')");
    $msg = "Student lagret!";
}

// --- SLETT STUDENT ---
if (isset($_POST['slett_student'])) {
    $bruker = $_POST['brukernavn'];
    $conn->query("DELETE FROM student WHERE brukernavn='$bruker'");
    $msg = "Student slettet!";
}

// --- HENT ALLE DATA ---
$klasser = $conn->query("SELECT * FROM klasse");
$studenter = $conn->query("SELECT * FROM student");
?>
<!DOCTYPE html>
<html lang="no">
<meta charset="UTF-8">
<title>Oblig 2</title>
<body>

<h1>PRG120V – Obligatorisk Oppgave 2</h1>
<p style='color:green;'><?php echo $msg; ?></p>

<h2>Registrer klasse</h2>
<form method="post">
    Klassekode: <input name="klassekode"><br>
    Klassenavn: <input name="klassenavn"><br>
    Studiumkode: <input name="studiumkode"><br>
    <button name="lagre_klasse">Lagre klasse</button>
</form>

<h2>Slett klasse</h2>
<form method="post">
<select name="klassekode">
<?php foreach ($klasser as $k) echo "<option>{$k['klassekode']}</option>"; ?>
</select>
<button name="slett_klasse">Slett klasse</button>
</form>

<h2>Registrer student</h2>
<form method="post">
Brukernavn: <input name="brukernavn"><br>
Fornavn: <input name="fornavn"><br>
Etternavn: <input name="etternavn"><br>
Klassekode:
<select name="klassekode">
<?php foreach ($klasser as $k) echo "<option>{$k['klassekode']}</option>"; ?>
</select><br>
<button name="lagre_student">Lagre student</button>
</form>

<h2>Slett student</h2>
<form method="post">
<select name="brukernavn">
<?php foreach ($studenter as $s) echo "<option>{$s['brukernavn']}</option>"; ?>
</select>
<button name="slett_student">Slett student</button>
</form>

<h2>Alle klasser</h2>
<table border="1">
<tr><th>Kode</th><th>Navn</th><th>Studiumkode</th></tr>
<?php foreach ($klasser as $k) echo "<tr><td>{$k['klassekode']}</td><td>{$k['klassenavn']}</td><td>{$k['studiumkode']}</td></tr>"; ?>
</table>

<h2>Alle studenter</h2>
<table border="1">
<tr><th>Brukernavn</th><th>Navn</th><th>Klasse</th></tr>
<?php foreach ($studenter as $s) echo "<tr><td>{$s['brukernavn']}</td><td>{$s['fornavn']} {$s['etternavn']}</td><td>{$s['klassekode']}</td></tr>"; ?>
</table>

</body>
</html>
