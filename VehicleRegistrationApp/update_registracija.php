<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('db_konekcija.php');

    $broj_registracije = $_POST['broj_registracije'];
    $id_vozila = $_POST['id_vozila'];
    $tablice = $_POST['tablice'];
    $datum_registracije = $_POST['datum_registracije'];
    $datum_isteka_registracije = $_POST['datum_isteka_registracije'];
    $broj_polise = $_POST['broj_polise'];

    $sql = "UPDATE Registracija SET id_vozila='$id_vozila', tablice='$tablice', datum_registracije='$datum_registracije', datum_isteka_registracije='$datum_isteka_registracije', broj_polise='$broj_polise' WHERE broj_registracije='$broj_registracije'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?page=registracija");
        exit();
    } else {
        echo "Greška prilikom ažuriranja podataka: " . $conn->error;
    }

    $conn->close();
}

if(isset($_GET['broj_registracije']) && is_numeric($_GET['broj_registracije'])) {
    $broj_registracije = $_GET['broj_registracije'];

    require_once('db_konekcija.php');

    $sql_select = "SELECT * FROM Registracija WHERE broj_registracije = $broj_registracije";
    $result_select = $conn->query($sql_select);

    if ($result_select->num_rows == 1) {
        $row = $result_select->fetch_assoc();
        $id_vozila = $row['id_vozila'];
        $tablice = $row['tablice'];
        $datum_registracije = $row['datum_registracije'];
        $datum_isteka_registracije = $row['datum_isteka_registracije'];
        $broj_polise = $row['broj_polise'];
    } else {
        echo "Nema podataka o registraciji.";
    }
    $conn->close();
} else {
    echo "Broj registracije nije pravilno postavljen.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Izmjena podataka registracije</title>
</head>
<body>
    <div class="container">
        <h1>Izmjena podataka registracije</h1>
        <form action="update_registracija.php" method="post">
            <label for="broj_registracije">Broj registracije:</label><br>
            <input type="text" id="broj_registracije" name="broj_registracije" value="<?php echo $broj_registracije; ?>" readonly><br>
            <label for="id_vozila">ID vozila:</label><br>
            <input type="text" id="id_vozila" name="id_vozila" value="<?php echo $id_vozila; ?>" required><br>
            <label for="tablice">Tablice:</label><br>
            <input type="text" id="tablice" name="tablice" value="<?php echo $tablice; ?>" required><br>
            <label for="datum_registracije">Datum registracije:</label><br>
            <input type="date" id="datum_registracije" name="datum_registracije" value="<?php echo $datum_registracije; ?>" required><br>
            <label for="datum_isteka_registracije">Datum isteka registracije:</label><br>
            <input type="date" id="datum_isteka_registracije" name="datum_isteka_registracije" value="<?php echo $datum_isteka_registracije; ?>" required><br>
            <label for="broj_polise">Broj polise:</label><br>
            <input type="text" id="broj_polise" name="broj_polise" value="<?php echo $broj_polise; ?>" required><br><br>
            <input type="submit" value="Ažuriraj registraciju" class="btn">
            <a href="index.php?page=registracija" class="btn">Odustani</a>
        </form>
    </div>
</body>
</html>
