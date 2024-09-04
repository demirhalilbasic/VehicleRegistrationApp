<?php
require_once('db_konekcija.php');

$sql = "SELECT * FROM Registracija";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $sql . "<br>" . $conn->error;
} else {
    if ($result->num_rows > 0) {
        echo "<h2>Popis registracija</h2>";
        echo "<div class='search-container'>";
        echo "<input type='text' id='searchBar' class='searchBar' placeholder='Pretraži po broju registracije ili tablicama'>";
        echo "<a href='add_registracija.php' class='btn btn-add'>Dodaj novu registraciju</a>";
        echo "</div>";
        echo "<table id='registracijaTable'>";
        echo "<tr><th>Broj registracije</th><th>ID vozila</th><th>Tablice</th><th>Datum registracije</th><th>Datum isteka registracije</th><th>Broj polise</th><th>Akcije</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["broj_registracije"]."</td>";
            echo "<td>".$row["id_vozila"]."</td>";
            echo "<td>".$row["tablice"]."</td>";
            echo "<td>".$row["datum_registracije"]."</td>";
            echo "<td>".$row["datum_isteka_registracije"]."</td>";
            echo "<td>".$row["broj_polise"]."</td>";
            echo "<td class='btn-container'>";
            echo "<a href='update_registracija.php?broj_registracije=".$row["broj_registracije"]."' class='btn'>Uredi</a>";
            echo "<a href='delete_registracija.php?broj_registracije=".$row["broj_registracije"]."' class='btn'>Obriši</a>";
            echo "</td>";
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
    var rows = document.getElementById('registracijaTable').getElementsByTagName('tr');
    var isNumeric = /^\d+$/.test(input);

    for (var i = 1; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName('td');
        var found = false;
        for (var j = 0; j < cells.length; j++) {
            var cellText = cells[j].textContent.trim().toLowerCase();
            if (isNumeric && j === 0 && cellText.startsWith(input)) {
                found = true;
                break;
            } else if (!isNumeric && j === 2 && cellText.startsWith(input)) {
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