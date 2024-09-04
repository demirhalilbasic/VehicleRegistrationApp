<?php
require_once('db_konekcija.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['delete'])) {
        $broj_registracije = $_POST['broj_registracije'];

        $sql = "DELETE FROM Registracija WHERE broj_registracije='$broj_registracije'";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php?page=registracija");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['cancel'])) {
        header("Location: index.php?page=registracija");
        exit();
    }
}

if(isset($_GET['broj_registracije'])) {
    $broj_registracije = $_GET['broj_registracije'];

    $sql = "SELECT * FROM Registracija WHERE broj_registracije='$broj_registracije'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $id_vozila = $row["id_vozila"];
        $tablice = $row["tablice"];
        $datum_registracije = $row["datum_registracije"];
        $datum_isteka_registracije = $row["datum_isteka_registracije"];
        $broj_polise = $row["broj_polise"];
    } else {
        echo "Greška: Registracija nije pronađena.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Brisanje registracije</title>
</head>
<body>
    <div class="container">
        <h1>Brisanje registracije</h1>
        <?php if(isset($row)): ?>
        <p>Da li ste sigurni da želite obrisati registraciju:</p>
        <p>Broj registracije: <?php echo $broj_registracije; ?></p>
        <p>ID vozila: <?php echo $id_vozila; ?></p>
        <p>Tablice: <?php echo $tablice; ?></p>
        <p>Datum registracije: <?php echo $datum_registracije; ?></p>
        <p>Datum isteka registracije: <?php echo $datum_isteka_registracije; ?></p>
        <p>Broj polise: <?php echo $broj_polise; ?></p>
        <form action="delete_registracija.php" method="post">
            <input type="hidden" name="broj_registracije" value="<?php echo $broj_registracije; ?>">
            <input type="submit" name="delete" value="Obriši" class="btn">
            <input type="submit" name="cancel" value="Odustani" class="btn">
        </form>
        <?php else: ?>
        <p>Greška: Registracija nije pronađena.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>