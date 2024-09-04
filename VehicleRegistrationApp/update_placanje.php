<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('db_konekcija.php');

    $id_placanja = $_POST['id_placanja'];
    $iznos = $_POST['iznos'];
    $datum = $_POST['datum'];
    $nacin_placanja = $_POST['nacin_placanja'];

    $sql = "UPDATE Placanje SET iznos='$iznos', datum='$datum', nacin_placanja='$nacin_placanja' WHERE id_placanja='$id_placanja'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?page=placanje");
        exit();
    } else {
        echo "Greška prilikom ažuriranja podataka: " . $conn->error;
    }

    $conn->close();
}

if(isset($_GET['id_placanja']) && is_numeric($_GET['id_placanja'])) {
    $id_placanja = $_GET['id_placanja'];

    require_once('db_konekcija.php');

    $sql_select = "SELECT * FROM Placanje WHERE id_placanja = $id_placanja";
    $result_select = $conn->query($sql_select);

    if ($result_select->num_rows == 1) {
        $row = $result_select->fetch_assoc();
        $iznos = $row['iznos'];
        $datum = $row['datum'];
        $nacin_placanja = $row['nacin_placanja'];
    } else {
        echo "Nema podataka o plaćanju.";
    }
    $conn->close();
} else {
    echo "ID plaćanja nije pravilno postavljen.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Izmjena podataka plaćanja</title>
</head>
<body>
    <div class="container">
        <h1>Izmjena podataka plaćanja</h1>
        <form action="update_placanje.php" method="post">
            <label for="id_placanja">ID plaćanja:</label><br>
            <input type="text" id="id_placanja" name="id_placanja" value="<?php echo isset($id_placanja) ? $id_placanja : ''; ?>" readonly><br>
            <label for="iznos">Iznos:</label><br>
            <input type="text" id="iznos" name="iznos" value="<?php echo isset($iznos) ? $iznos : ''; ?>" required> KM<br>
            <label for="datum">Datum:</label><br>
            <input type="date" id="datum" name="datum" value="<?php echo isset($datum) ? $datum : ''; ?>" required><br>
            <label for="nacin_placanja">Način plaćanja:</label><br>
            <input type="text" id="nacin_placanja" name="nacin_placanja" value="<?php echo isset($nacin_placanja) ? $nacin_placanja : ''; ?>" required><br><br>
            <input type="submit" value="Ažuriraj plaćanje" class="btn">
            <a href="index.php?page=placanje" class="btn">Odustani</a>
        </form>
    </div>
</body>
</html>