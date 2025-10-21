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
