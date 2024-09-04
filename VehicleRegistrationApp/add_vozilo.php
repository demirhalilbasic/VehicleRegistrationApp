<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodavanje vozila</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <header>
        <h1>Dodavanje vozila</h1>
    </header>

    <div class="container">
        <form action="add_vozilo.php" method="POST" class="add-form-container">
            ID klijenta: 
            <select name="id_klijenta" required>
                <?php
                require_once('db_konekcija.php');

                $sql = "SELECT id_klijenta FROM Klijent ORDER BY id_klijenta";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id_klijenta'] . "'>" . $row['id_klijenta'] . "</option>";
                    }
                }
                ?>
            </select><br><br>
            
            Brend: <input type="text" name="brend" required><br><br>
            Model: <input type="text" name="model" required><br><br>
            VIN: <input type="text" name="VIN" required><br><br>
            Boja: <input type="text" name="boja" required><br><br>
            Tip karoserije: 
            <select name="tip_karoserije" required>
                <option value="Limuzina">Limuzina</option>
                <option value="Hečbek">Hečbek</option>
                <option value="Karavan">Karavan</option>
                <option value="Kupe">Kupe</option>
                <option value="Kabriolet">Kabriolet</option>
                <option value="Monovolumen">Monovolumen</option>
                <option value="SUV">SUV</option>
                <option value="Pickup">Pickup</option>
            </select><br><br>
            Godina proizvodnje: <input type="text" name="godina_proizvodnje" required><br><br>
            Zapremina motora: <input type="text" name="zapremina_motora" required> L<br><br>
            Snaga motora: <input type="text" name="snaga_motora" required> kW<br><br>
            Vrsta motora: 
            <select name="vrsta_motora" required>
                <option value="Benzin">Benzin</option>
                <option value="Dizel">Dizel</option>
                <option value="Električni">Električni</option>
                <option value="CNG">CNG</option>
                <option value="LPG">LPG</option>
                <option value="Hibrid">Hibrid</option>
                <option value="PlugIn">PlugIn</option>
                <option value="Vodik">Vodik</option>
            </select><br><br>
            Broj sjedišta: <input type="text" name="broj_sjedista" required><br><br>
            Nosivost: <input type="text" name="nosivost" required> kg<br><br>

            <div class="btn-container">
                <input type="submit" value="Dodaj vozilo" class="btn">
                <a href="index.php?page=vozilo" class="btn">Odustani</a>
            </div>
        </form>
    </div>

    <?php
    require_once('db_konekcija.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_klijenta = $_POST['id_klijenta'];
        $brend = $_POST['brend'];
        $model = $_POST['model'];
        $VIN = $_POST['VIN'];
        $boja = $_POST['boja'];
        $tip_karoserije = $_POST['tip_karoserije'];
        $godina_proizvodnje = $_POST['godina_proizvodnje'];
        $zapremina_motora = $_POST['zapremina_motora'];
        $snaga_motora = $_POST['snaga_motora'];
        $vrsta_motora = $_POST['vrsta_motora'];
        $broj_sjedista = $_POST['broj_sjedista'];
        $nosivost = $_POST['nosivost'];

        $sql = "INSERT INTO Vozilo (id_klijenta, brend, model, VIN, boja, tip_karoserije, godina_proizvodnje, zapremina_motora, snaga_motora, vrsta_motora, broj_sjedista, nosivost) VALUES ('$id_klijenta', '$brend', '$model', '$VIN', '$boja', '$tip_karoserije', '$godina_proizvodnje', '$zapremina_motora', '$snaga_motora', '$vrsta_motora', '$broj_sjedista', '$nosivost')";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php?page=vozilo");
            exit;
        } else {
            echo "Greška prilikom dodavanja vozila: " . $conn->error;
        }
    }

    $conn->close();
    ?>
</body>
</html>