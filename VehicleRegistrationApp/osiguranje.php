<?php
require_once('db_konekcija.php');

$sql = "SELECT * FROM Osiguranje";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $sql . "<br>" . $conn->error;
} else {
    if ($result->num_rows > 0) {
        echo "<h2>Popis osiguranja</h2>";
        echo "<div class='search-container'>";
        echo "<input type='text' id='searchBarOsiguranje' class='searchBar' placeholder='Pretraži po broju polise ili osiguravajućoj kući'>";
        echo "<a href='add_osiguranje.php' class='btn btn-add'>Dodaj novo osiguranje</a>";
        echo "</div>";
        echo "<table id='osiguranjeTable'>";
        echo "<tr><th>Broj polise</th><th>Vrsta osiguranja</th><th>Datum osiguranja</th><th>Period osiguranja (godina)</th><th>Premija (KM)</th><th>Osiguravajuća kuća</th><th>Akcije</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["broj_polise"]."</td>";
            echo "<td>".$row["vrsta_osiguranja"]."</td>";
            echo "<td>".$row["datum_osiguranja"]."</td>";
            echo "<td>".$row["period_osiguranja"]."</td>";
            echo "<td>".$row["premija"]."</td>";
            echo "<td>".$row["osiguravajuca_kuca"]."</td>";
            echo "<td class='btn-container'><a href='update_osiguranje.php?broj_polise=".$row["broj_polise"]."' class='btn'>Uredi</a><a href='delete_osiguranje.php?broj_polise=".$row["broj_polise"]."' class='btn'>Obriši</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nema rezultata.</p>";
    }
}

$conn->close();
?>

<script>
document.getElementById('searchBarOsiguranje').addEventListener('input', function() {
    var input = this.value.trim().toLowerCase();
    var rows = document.getElementById('osiguranjeTable').getElementsByTagName('tr');
    for (var i = 1; i < rows.length; i++) {
        var cellsPolisa = rows[i].getElementsByTagName('td')[0];
        var cellsKuca = rows[i].getElementsByTagName('td')[5];
        var cellTextPolisa = cellsPolisa.textContent.toLowerCase();
        var cellTextKuca = cellsKuca.textContent.toLowerCase();
        var found = false;
        if (cellTextPolisa.includes(input) || cellTextKuca.includes(input)) {
            found = true;
        }
        if (found) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
});
</script>