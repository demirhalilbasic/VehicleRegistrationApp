<?php
require_once('db_konekcija.php');

$search_query = "";
if(isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

$sql = "SELECT v.VIN, v.brend, v.model, v.godina_proizvodnje, v.boja, v.tip_karoserije,
        CONCAT(k.ime, ' ', k.prezime) AS vlasnik,
        o.vrsta_osiguranja,
        DATE_ADD(o.datum_osiguranja, INTERVAL o.period_osiguranja YEAR) AS osigurano_do
        FROM Vozilo v
        INNER JOIN Klijent k ON v.id_klijenta = k.id_klijenta
        LEFT JOIN Registracija r ON v.id_vozila = r.id_vozila
        LEFT JOIN Osiguranje o ON r.broj_polise = o.broj_polise
        WHERE v.VIN LIKE '%$search_query%' OR v.brend LIKE '%$search_query%' OR v.model LIKE '%$search_query%'
        ORDER BY v.VIN";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $sql . "<br>" . $conn->error;
} else {
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>VIN</th><th>Brend</th><th>Model</th><th>Godina proizvodnje</th><th>Boja</th><th>Tip karoserije</th><th>Vlasnik</th><th>Vrsta osiguranja</th><th>Osigurano do</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["VIN"]."</td>";
            echo "<td>".$row["brend"]."</td>";
            echo "<td>".$row["model"]."</td>";
            echo "<td>".$row["godina_proizvodnje"]."</td>";
            echo "<td>".$row["boja"]."</td>";
            echo "<td>".$row["tip_karoserije"]."</td>";
            echo "<td>".$row["vlasnik"]."</td>";
            echo "<td>".$row["vrsta_osiguranja"]."</td>";
            echo "<td>".$row["osigurano_do"]."</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nema rezultata pretrage.</p>";
    }
}

$conn->close();
?>