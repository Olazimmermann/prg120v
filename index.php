<?php
// Enkel kode for å vise innholdet i tabellen "klasse"

// Koblingsinformasjon
$tjener = getenv("DB_HOST") ?: "localhost";
$bruker = getenv("DB_USER") ?: "root";
$passord = getenv("DB_PASS") ?: "";
$database = getenv("DB_NAME") ?: "skole";

// Koble til databasen
$kobling = new mysqli($tjener, $bruker, $passord, $database);
