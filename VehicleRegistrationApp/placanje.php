<?php
require_once('db_konekcija.php');

$sql = "SELECT * FROM Placanje";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $sql . "<br>" . $conn->error;
} else {
    if ($result->num_rows > 0) {
        echo "<h2>Popis plaćanja</h2>";
        echo "<div class='search-container'>";
        echo "<input type='text' id='searchBar' class='searchBar' placeholder='Pretraži po ID-u plaćanja'>";
        echo "<a href='add_placanje.php' class='btn'>Dodaj novo plaćanje</a>";
        echo "</div>";
        echo "<table id='placanjaTable'>";
        echo "<tr><th>ID plaćanja</th><th>Broj registracije</th><th>Iznos (KM)</th><th>Datum</th><th>Način plaćanja</th><th>Akcije</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["id_placanja"]."</td>";
            echo "<td>".$row["broj_registracije"]."</td>";
            echo "<td>".$row["iznos"]."</td>";
            echo "<td>".$row["datum"]."</td>";
            echo "<td>".$row["nacin_placanja"]."</td>";
            echo "<td class='btn-container'><a href='update_placanje.php?id_placanja=".$row["id_placanja"]."' class='btn'>Uredi</a><a href='delete_placanje.php?id_placanja=".$row["id_placanja"]."' class='btn'>Obriši</a></td>";
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
document.getElementById('searchBar').addEventListener('input', function() {
    var input = this.value.trim().toLowerCase();
    var rows = document.getElementById('placanjaTable').getElementsByTagName('tr');
    for (var i = 1; i < rows.length; i++) {
        var id = rows[i].getElementsByTagName('td')[0].textContent.trim();
        if (id.includes(input)) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
});
</script>