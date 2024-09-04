<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodavanje plaćanja</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <header>
        <h1>Dodavanje plaćanja</h1>
    </header>

    <div class="container">
        <form action="add_placanje.php" method="POST" class="add-form-container">
            Broj registracije: 
            <select name="broj_registracije" required>
                <?php
                require_once('db_konekcija.php');

                $sql = "SELECT broj_registracije FROM Registracija";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['broj_registracije'] . "'>" . $row['broj_registracije'] . "</option>";
                    }
                }
                ?>
            </select><br><br>
            Iznos: <input type="text" name="iznos" required> KM<br><br>
            Datum: <input type="date" name="datum" required><br><br>
            Način plaćanja: 
            <select name="nacin_placanja" required>
                <option value="Kartica">Kartica</option>
                <option value="Gotovina">Gotovina</option>
            </select><br><br>

            <div class="btn-container">
                <input type="submit" value="Dodaj plaćanje" class="btn">
                <a href="index.php?page=placanje" class="btn">Odustani</a>
            </div>
        </form>
    </div>

    <?php
    require_once('db_konekcija.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $broj_registracije = $_POST['broj_registracije'];
        $iznos = $_POST['iznos'];
        $datum = $_POST['datum'];
        $nacin_placanja = $_POST['nacin_placanja'];

        $sql = "INSERT INTO Placanje (broj_registracije, iznos, datum, nacin_placanja) VALUES ('$broj_registracije', '$iznos', '$datum', '$nacin_placanja')";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php?page=placanje");
            exit;
        } else {
            echo "Greška prilikom dodavanja plaćanja: " . $conn->error;
        }
    }

    $conn->close();
    ?>
</body>
</html>