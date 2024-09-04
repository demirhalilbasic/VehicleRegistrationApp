<?php
require_once('db_konekcija.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['delete'])) {
        $id = $_POST['id_klijenta'];

        $sql = "DELETE FROM Klijent WHERE id_klijenta='$id'";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php?page=klijent");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['cancel'])) {
        header("Location: index.php?page=klijent");
        exit();
    }
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM Klijent WHERE id_klijenta='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $ime = $row["ime"];
        $prezime = $row["prezime"];
        $adresa = $row["adresa"];
        $email = $row["email"];
        $telefon = $row["telefon"];
    } else {
        echo "Greška: Klijent nije pronađen.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Brisanje klijenta</title>
</head>
<body>
    <div class="container">
        <h1>Brisanje klijenta</h1>
        <?php if(isset($row)): ?>
        <p>Da li ste sigurni da želite obrisati klijenta:</p>
        <p>ID: <?php echo $id; ?></p>
        <p>Ime: <?php echo $ime; ?></p>
        <p>Prezime: <?php echo $prezime; ?></p>
        <p>Adresa: <?php echo $adresa; ?></p>
        <p>Email: <?php echo $email; ?></p>
        <p>Telefon: <?php echo $telefon; ?></p>
        <form action="delete_klijent.php" method="post">
            <input type="hidden" name="id_klijenta" value="<?php echo $id; ?>">
            <input type="submit" name="delete" value="Obriši" class="btn">
            <input type="submit" name="cancel" value="Odustani" class="btn">
        </form>
        <?php else: ?>
        <p>Greška: Klijent nije pronađen.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>