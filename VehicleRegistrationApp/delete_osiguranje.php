<?php
require_once('db_konekcija.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['delete'])) {
        $broj_polise = $_POST['broj_polise'];

        $sql = "DELETE FROM Osiguranje WHERE broj_polise='$broj_polise'";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php?page=osiguranje");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['cancel'])) {
        header("Location: index.php?page=osiguranje");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['broj_polise']) && is_numeric($_GET['broj_polise'])) {
    $broj_polise = $_GET['broj_polise'];

    $sql = "SELECT * FROM Osiguranje WHERE broj_polise='$broj_polise'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $vrsta_osiguranja = $row["vrsta_osiguranja"];
        $datum_osiguranja = $row["datum_osiguranja"];
        $period_osiguranja = $row["period_osiguranja"];
        $premija = $row["premija"];
        $osiguravajuca_kuca = $row["osiguravajuca_kuca"];
    } else {
        echo "Greška: Osiguranje nije pronađeno.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Brisanje osiguranja</title>
</head>
<body>
    <div class="container">
        <h1>Brisanje osiguranja</h1>
        <?php if(isset($row)): ?>
        <p>Da li ste sigurni da želite obrisati osiguranje:</p>
        <p>Broj polise: <?php echo $broj_polise; ?></p>
        <p>Vrsta osiguranja: <?php echo $vrsta_osiguranja; ?></p>
        <p>Datum osiguranja: <?php echo $datum_osiguranja; ?></p>
        <p>Period osiguranja: <?php echo $period_osiguranja; ?></p>
        <p>Premija: <?php echo $premija; ?></p>
        <p>Osiguravajuća kuća: <?php echo $osiguravajuca_kuca; ?></p>
        <form action="delete_osiguranje.php" method="post">
            <input type="hidden" name="broj_polise" value="<?php echo $broj_polise; ?>">
            <input type="submit" name="delete" value="Obriši" class="btn">
            <input type="submit" name="cancel" value="Odustani" class="btn">
        </form>
        <?php else: ?>
        <p>Greška: Osiguranje nije pronađeno.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>