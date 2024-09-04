<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodavanje osiguranja</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <header>
        <h1>Dodavanje osiguranja</h1>
    </header>

    <div class="container">
        <form action="add_osiguranje.php" method="POST" class="add-form-container">
            Vrsta osiguranja: 
            <select name="vrsta_osiguranja" required>
                <option value="Osnovno">Osnovno</option>
                <option value="Punokasko">Punokasko</option>
            </select><br><br>
            Datum osiguranja: <input type="date" name="datum_osiguranja" required><br><br>
            Period osiguranja: <br>
            <input type="radio" name="period_osiguranja" value="1" required> 1 godina<br>
            <input type="radio" name="period_osiguranja" value="2"> 2 godine<br>
            <input type="radio" name="period_osiguranja" value="3"> 3 godine<br>
            <input type="radio" name="period_osiguranja" value="4"> 4 godine<br>
            <input type="radio" name="period_osiguranja" value="5"> 5 godina<br><br>
            Premija: <input type="text" name="premija" required> KM<br><br>
            Osiguravajuća kuća: <input type="text" name="osiguravajuca_kuca" required><br><br>

            <div class="btn-container">
                <input type="submit" value="Dodaj osiguranje" class="btn">
                <a href="index.php?page=osiguranje" class="btn">Odustani</a>
            </div>
        </form>
    </div>

    <?php
    require_once('db_konekcija.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $vrsta_osiguranja = $_POST['vrsta_osiguranja'];
        $datum_osiguranja = $_POST['datum_osiguranja'];
        $period_osiguranja = $_POST['period_osiguranja'];
        $premija = $_POST['premija'];
        $osiguravajuca_kuca = $_POST['osiguravajuca_kuca'];

        $sql = "INSERT INTO Osiguranje (vrsta_osiguranja, datum_osiguranja, period_osiguranja, premija, osiguravajuca_kuca) VALUES ('$vrsta_osiguranja', '$datum_osiguranja', '$period_osiguranja', '$premija', '$osiguravajuca_kuca')";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php?page=osiguranje");
            exit;
        } else {
            echo "Greška prilikom dodavanja osiguranja: " . $conn->error;
        }
    }

    $conn->close();
    ?>
</body>
</html>