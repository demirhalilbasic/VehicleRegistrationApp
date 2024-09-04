<?php
require_once('db_konekcija.php');

$sql = "SELECT * FROM Klijent";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $sql . "<br>" . $conn->error;
} else {
    if ($result->num_rows > 0) {
        echo "<h2>Popis klijenata</h2>";
        echo "<div class='search-container'>";
        echo "<input type='text' id='searchBar' class='searchBar' placeholder='Pretraži po imenu ili ID-u'>";
        echo "<a href='add_klijent.php' class='btn btn-add'>Dodaj novog klijenta</a>";
        echo "</div>";
        echo "<table id='klijentiTable'>";
        echo "<tr><th>ID</th><th>Ime</th><th>Prezime</th><th>Adresa</th><th>Email</th><th>Telefon</th><th>Akcije</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["id_klijenta"]."</td>";
            echo "<td>".$row["ime"]."</td>";
            echo "<td>".$row["prezime"]."</td>";
            echo "<td>".$row["adresa"]."</td>";
            echo "<td>".$row["email"]."</td>";
            echo "<td>".$row["telefon"]."</td>";
            echo "<td class='btn-container'><a href='update_klijent.php?id=".$row["id_klijenta"]."' class='btn'>Uredi</a><a href='delete_klijent.php?id=".$row["id_klijenta"]."' class='btn'>Obriši</a></td>";
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
    var input = this.value.trim();
    var rows = document.getElementById('klijentiTable').getElementsByTagName('tr');
    var isNumeric = /^\d+$/.test(input);
    for (var i = 1; i < rows.length; i++) {
        var id = rows[i].getElementsByTagName('td')[0].textContent.trim();
        var name = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
        if (isNumeric) {
            if (id.includes(input)) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        } else {
            if (name.includes(input.toLowerCase())) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
});
</script>
