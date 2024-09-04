<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodavanje registracije</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <header>
        <h1>Dodavanje registracije</h1>
    </header>

    <div class="container">
        <form action="add_registracija.php" method="POST" class="add-form-container">
            ID vozila: 
            <select name="id_vozila" required>
                <?php
                require_once('db_konekcija.php');

                $sql = "SELECT id_vozila FROM Vozilo ORDER BY CAST(id_vozila AS UNSIGNED)";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id_vozila'] . "'>" . $row['id_vozila'] . "</option>";
                    }
                }
                ?>
            </select><br><br>

            Tablice: <input type="text" name="tablice" required><br><br>
            Datum registracije: <input type="date" name="datum_registracije" required><br><br>
            Datum isteka registracije: <input type="date" name="datum_isteka_registracije" required><br><br>
            Broj polise: 
            <select name="broj_polise" required>
                <?php
                require_once('db_konekcija.php');

                $sql = "SELECT broj_polise FROM Osiguranje ORDER BY CAST(broj_polise AS UNSIGNED)";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['broj_polise'] . "'>" . $row['broj_polise'] . "</option>";
                    }
                }
                ?>
            </select><br><br>

            <div class="btn-container">
                <input type="submit" value="Dodaj registraciju" class="btn">
                <a href="index.php?page=registracija" class="btn">Odustani</a>
            </div>
        </form>
    </div>

    <?php
    require_once('db_konekcija.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_vozila = $_POST['id_vozila'];
        $tablice = $_POST['tablice'];
        $datum_registracije = $_POST['datum_registracije'];
        $datum_isteka_registracije = $_POST['datum_isteka_registracije'];
        $broj_polise = $_POST['broj_polise'];

        $sql = "INSERT INTO Registracija (id_vozila, tablice, datum_registracije, datum_isteka_registracije, broj_polise) VALUES ('$id_vozila', '$tablice', '$datum_registracije', '$datum_isteka_registracije', '$broj_polise')";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php?page=registracija");
            exit;
        } else {
            echo "Greška prilikom dodavanja registracije: " . $conn->error;
        }
    }

    $conn->close();
    ?>
</body>
</html>