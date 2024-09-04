<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('db_konekcija.php');

    $broj_polise = $_POST['broj_polise'];
    $vrsta_osiguranja = $_POST['vrsta_osiguranja'];
    $datum_osiguranja = $_POST['datum_osiguranja'];
    $period_osiguranja = $_POST['period_osiguranja'];
    $premija = $_POST['premija'];
    $osiguravajuca_kuca = $_POST['osiguravajuca_kuca'];

    $sql = "UPDATE Osiguranje SET vrsta_osiguranja='$vrsta_osiguranja', datum_osiguranja='$datum_osiguranja', period_osiguranja='$period_osiguranja', premija='$premija', osiguravajuca_kuca='$osiguravajuca_kuca' WHERE broj_polise='$broj_polise'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?page=osiguranje");
        exit();
    } else {
        echo "Greška prilikom ažuriranja podataka: " . $conn->error;
    }

    $conn->close();
}

if(isset($_GET['broj_polise']) && is_numeric($_GET['broj_polise'])) {
    $broj_polise = $_GET['broj_polise'];

    require_once('db_konekcija.php');

    $sql_select = "SELECT * FROM Osiguranje WHERE broj_polise = $broj_polise";
    $result_select = $conn->query($sql_select);

    if ($result_select->num_rows == 1) {
        $row = $result_select->fetch_assoc();
        $vrsta_osiguranja = $row['vrsta_osiguranja'];
        $datum_osiguranja = $row['datum_osiguranja'];
        $period_osiguranja = $row['period_osiguranja'];
        $premija = $row['premija'];
        $osiguravajuca_kuca = $row['osiguravajuca_kuca'];
    } else {
        echo "Nema podataka o osiguranju.";
    }
    $conn->close();
} else {
    echo "Broj polise nije pravilno postavljen.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Izmjena podataka osiguranja</title>
</head>
<body>
    <div class="container">
        <h1>Izmjena podataka osiguranja</h1>
        <form action="update_osiguranje.php" method="post">
            <label for="broj_polise">Broj polise:</label><br>
            <input type="text" id="broj_polise" name="broj_polise" value="<?php echo $broj_polise; ?>" readonly><br>
            <label for="vrsta_osiguranja">Vrsta osiguranja:</label><br>
            <input type="text" id="vrsta_osiguranja" name="vrsta_osiguranja" value="<?php echo $vrsta_osiguranja; ?>" required><br>
            <label for="datum_osiguranja">Datum osiguranja:</label><br>
            <input type="date" id="datum_osiguranja" name="datum_osiguranja" value="<?php echo $datum_osiguranja; ?>" required><br>
            <label for="period_osiguranja">Period osiguranja:</label><br>
            <input type="text" id="period_osiguranja" name="period_osiguranja" value="<?php echo $period_osiguranja; ?>" required> godina/e<br>
            <label for="premija">Premija:</label><br>
            <input type="text" id="premija" name="premija" value="<?php echo $premija; ?>" required> KM<br>
            <label for="osiguravajuca_kuca">Osiguravajuća kuća:</label><br>
            <input type="text" id="osiguravajuca_kuca" name="osiguravajuca_kuca" value="<?php echo $osiguravajuca_kuca; ?>" required><br><br>
            <input type="submit" value="Ažuriraj osiguranje" class="btn">
            <a href="index.php?page=osiguranje" class="btn">Odustani</a>
        </form>
    </div>
</body>
</html>