<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_app_registracija_vozila";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Neuspješno povezivanje s bazom podataka: " . $conn->connect_error);
}
?>
