<?php
require_once('db_konekcija.php');

$sql = "SELECT * FROM Vozilo";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $sql . "<br>" . $conn->error;
} else {
    if ($result->num_rows > 0) {
        echo "<h2>Popis vozila</h2>";
        echo "<div class='search-container'>";
        echo "<input type='text' id='searchBarVozilo' class='searchBar' placeholder='Pretraži po brendu, modelu ili VIN-u'>";
        echo "<a href='add_vozilo.php' class='btn btn-add'>Dodaj novo vozilo</a>";
        echo "</div>";
        echo "<table id='vozilaTable'>";
        echo "<tr><th>ID</th><th>Brend</th><th>Model</th><th>VIN</th><th>Boja</th><th>Tip karoserije</th><th>Godina proizvodnje</th><th>Zapremina motora</th><th>Snaga motora</th><th>Vrsta motora</th><th>Broj sjedišta</th><th>Nosivost</th><th>Akcije</th></tr>";
        echo "<tr><th></th><th></th><th></th><th>(broj šasije)</th><th></th><th></th><th></th><th>(L)</th><th>(kW)</th><th></th><th></th><th>(kg)</th><th></th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["id_vozila"]."</td>";
            echo "<td>".$row["brend"]."</td>";
            echo "<td>".$row["model"]."</td>";
            echo "<td>".$row["VIN"]."</td>";
            echo "<td>".$row["boja"]."</td>";
            echo "<td>".$row["tip_karoserije"]."</td>";
            echo "<td>".$row["godina_proizvodnje"]."</td>";
            echo "<td>".$row["zapremina_motora"]."</td>";
            echo "<td>".$row["snaga_motora"]."</td>";
            echo "<td>".$row["vrsta_motora"]."</td>";
            echo "<td>".$row["broj_sjedista"]."</td>";
            echo "<td>".$row["nosivost"]."</td>";
            echo "<td class='btn-container'><a href='update_vozilo.php?id_vozila=".$row["id_vozila"]."' class='btn'>Uredi</a><a href='delete_vozilo.php?id_vozila=".$row["id_vozila"]."' class='btn'>Obriši</a></td>";
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
document.getElementById('searchBarVozilo').addEventListener('input', function() {
    var input = this.value.trim().toLowerCase();
    var table = document.getElementById('vozilaTable');
    var rows = table.getElementsByTagName('tr');

    rows[0].style.display = '';
    rows[1].style.display = '';

    for (var i = 2; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName('td');
        var found = false;
        for (var j = 1; j < cells.length; j++) {
            var cellText = cells[j].textContent.toLowerCase();
            if (cellText.includes(input)) {
                found = true;
                break;
            }
        }
        if (found) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
});
</script>