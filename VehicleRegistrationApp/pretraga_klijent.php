<?php
require_once('db_konekcija.php');

$search_query = "";
if(isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

$sql = "SELECT k.*, v.brend, v.model, r.tablice, r.datum_isteka_registracije, r.datum_registracije
        FROM Klijent k
        INNER JOIN Vozilo v ON k.id_klijenta = v.id_klijenta
        INNER JOIN Registracija r ON v.id_vozila = r.id_vozila
        WHERE k.ime LIKE '%$search_query%' OR k.prezime LIKE '%$search_query%'
        ORDER BY k.ime, k.prezime";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $sql . "<br>" . $conn->error;
} else {
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Ime</th><th>Prezime</th><th>Brend</th><th>Model</th><th>Tablice</th><th>Vozilo registrovano</th><th>Datum isteka registracije</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["ime"]."</td>";
            echo "<td>".$row["prezime"]."</td>";
            echo "<td>".$row["brend"]."</td>";
            echo "<td>".$row["model"]."</td>";
            echo "<td>".$row["tablice"]."</td>";
            echo "<td>".($row["datum_isteka_registracije"] < date('Y-m-d') ? 'NE' : 'DA')."</td>";
            echo "<td>".$row["datum_isteka_registracije"]."</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nema rezultata pretrage.</p>";
    }
}

$conn->close();
?>