<?php
require_once('db_konekcija.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['delete'])) {
        $id_placanja = $_POST['id_placanja'];

        $sql = "DELETE FROM Placanje WHERE id_placanja='$id_placanja'";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php?page=placanje");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['cancel'])) {
        header("Location: index.php?page=placanje");
        exit();
    }
}

if(isset($_GET['id_placanja'])) {
    $id_placanja = $_GET['id_placanja'];

    $sql = "SELECT * FROM Placanje WHERE id_placanja='$id_placanja'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $broj_registracije = $row["broj_registracije"];
        $iznos = $row["iznos"];
        $datum = $row["datum"];
        $nacin_placanja = $row["nacin_placanja"];
    } else {
        echo "Greška: Podatak o plaćanju nije pronađen.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Brisanje plaćanja</title>
</head>
<body>
    <div class="container">
        <h1>Brisanje plaćanja</h1>
        <?php if(isset($row)): ?>
        <p>Da li ste sigurni da želite obrisati plaćanje:</p>
        <p>ID plaćanja: <?php echo $id_placanja; ?></p>
        <p>Broj registracije: <?php echo $broj_registracije; ?></p>
        <p>Iznos: <?php echo $iznos; ?></p>
        <p>Datum: <?php echo $datum; ?></p>
        <p>Način plaćanja: <?php echo $nacin_placanja; ?></p>
        <form action="delete_placanje.php" method="post">
            <input type="hidden" name="id_placanja" value="<?php echo $id_placanja; ?>">
            <input type="submit" name="delete" value="Obriši" class="btn">
            <input type="submit" name="cancel" value="Odustani" class="btn">
        </form>
        <?php else: ?>
        <p>Greška: Podatak o plaćanju nije pronađen.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>