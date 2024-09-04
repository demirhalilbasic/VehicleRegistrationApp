<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('db_konekcija.php');

    $id_klijenta = $_POST['id_klijenta'];
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $adresa = $_POST['adresa'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];

    $sql = "UPDATE Klijent SET ime='$ime', prezime='$prezime', adresa='$adresa', email='$email', telefon='$telefon' WHERE id_klijenta='$id_klijenta'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?page=klijent");
        exit();
    } else {
        echo "Greška prilikom ažuriranja podataka: " . $conn->error;
    }

    $conn->close();
}

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_klijenta = $_GET['id'];

    require_once('db_konekcija.php');

    $sql_select = "SELECT * FROM Klijent WHERE id_klijenta = $id_klijenta";
    $result_select = $conn->query($sql_select);

    if ($result_select->num_rows == 1) {
        $row = $result_select->fetch_assoc();
        $ime = $row['ime'];
        $prezime = $row['prezime'];
        $adresa = $row['adresa'];
        $email = $row['email'];
        $telefon = $row['telefon'];
    } else {
        echo "Nema podataka o klijentu.";
    }
    $conn->close();
} else {
    echo "ID klijenta nije pravilno postavljen.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Izmjena podataka klijenta</title>
</head>
<body>
    <div class="container">
        <h1>Izmjena podataka klijenta</h1>
        <form action="update_klijent.php" method="post">
            <label for="id_klijenta">ID klijenta:</label><br>
            <input type="text" id="id_klijenta" name="id_klijenta" value="<?php echo $id_klijenta; ?>" readonly><br>
            <label for="ime">Ime:</label><br>
            <input type="text" id="ime" name="ime" value="<?php echo $ime; ?>" required><br>
            <label for="prezime">Prezime:</label><br>
            <input type="text" id="prezime" name="prezime" value="<?php echo $prezime; ?>" required><br>
            <label for="adresa">Adresa:</label><br>
            <input type="text" id="adresa" name="adresa" value="<?php echo $adresa; ?>" required><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br>
            <label for="telefon">Telefon:</label><br>
            <input type="tel" id="telefon" name="telefon" value="<?php echo $telefon; ?>" required><br><br>
            <input type="submit" value="Ažuriraj klijenta" class="btn">
            <a href="index.php?page=klijent" class="btn">Odustani</a>
        </form>
    </div>
</body>
</html>