<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodavanje klijenta</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <header>
        <h1>Dodavanje klijenta</h1>
    </header>

    <div class="container">
        <form action="add_klijent.php" method="POST" class="add-form-container">
            Ime: <input type="text" name="ime" required><br><br>
            Prezime: <input type="text" name="prezime" required><br><br>
            Adresa: <input type="text" name="adresa" required><br><br>
            Email: <input type="email" name="email" required><br><br>
            Telefon: <input type="tel" name="telefon" required><br><br>

            <div class="btn-container">
                <input type="submit" value="Dodaj klijenta" class="btn">
                <a href="index.php?page=klijent" class="btn">Odustani</a>
            </div>
        </form>
    </div>

    <?php
    require_once('db_konekcija.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ime = $_POST['ime'];
        $prezime = $_POST['prezime'];
        $adresa = $_POST['adresa'];
        $email = $_POST['email'];
        $telefon = $_POST['telefon'];

        $sql = "INSERT INTO Klijent (ime, prezime, adresa, email, telefon) VALUES ('$ime', '$prezime', '$adresa', '$email', '$telefon')";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php?page=klijent");
            exit;
        } else {
            echo "Greška prilikom dodavanja klijenta: " . $conn->error;
        }
    }

    $conn->close();
    ?>
</body>
</html>