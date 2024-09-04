<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('db_konekcija.php');

    $id_vozila = $_POST['id_vozila'];
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

    $sql = "UPDATE Vozilo SET brend='$brend', model='$model', VIN='$VIN', boja='$boja', tip_karoserije='$tip_karoserije', godina_proizvodnje='$godina_proizvodnje', zapremina_motora='$zapremina_motora', snaga_motora='$snaga_motora', vrsta_motora='$vrsta_motora', broj_sjedista='$broj_sjedista', nosivost='$nosivost' WHERE id_vozila='$id_vozila'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?page=vozilo");
        exit();
    } else {
        echo "Greška prilikom ažuriranja podataka: " . $conn->error;
    }

    $conn->close();
}

if(isset($_GET['id_vozila']) && is_numeric($_GET['id_vozila'])) {
    $id_vozila = $_GET['id_vozila'];

    require_once('db_konekcija.php');

    $sql_select = "SELECT * FROM Vozilo WHERE id_vozila = $id_vozila";
    $result_select = $conn->query($sql_select);

    if ($result_select->num_rows == 1) {
        $row = $result_select->fetch_assoc();
        $brend = $row['brend'];
        $model = $row['model'];
        $VIN = $row['VIN'];
        $boja = $row['boja'];
        $tip_karoserije = $row['tip_karoserije'];
        $godina_proizvodnje = $row['godina_proizvodnje'];
        $zapremina_motora = $row['zapremina_motora'];
        $snaga_motora = $row['snaga_motora'];
        $vrsta_motora = $row['vrsta_motora'];
        $broj_sjedista = $row['broj_sjedista'];
        $nosivost = $row['nosivost'];
    } else {
        echo "Nema podataka o vozilu.";
    }
    $conn->close();
} else {
    echo "ID vozila nije pravilno postavljen.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Izmjena podataka vozila</title>
</head>
<body>
    <div class="container">
        <h1>Izmjena podataka vozila</h1>
        <form action="update_vozilo.php" method="post">
            <label for="id_vozila">ID vozila:</label><br>
            <input type="text" id="id_vozila" name="id_vozila" value="<?php echo $id_vozila; ?>" readonly><br>
            <label for="brend">Brend:</label><br>
            <input type="text" id="brend" name="brend" value="<?php echo $brend; ?>" required><br>
            <label for="model">Model:</label><br>
            <input type="text" id="model" name="model" value="<?php echo $model; ?>" required><br>
            <label for="VIN">VIN:</label><br>
            <input type="text" id="VIN" name="VIN" value="<?php echo $VIN; ?>" required><br>
            <label for="boja">Boja:</label><br>
            <input type="text" id="boja" name="boja" value="<?php echo $boja; ?>" required><br>
            <label for="tip_karoserije">Tip karoserije:</label><br>
            <input type="text" id="tip_karoserije" name="tip_karoserije" value="<?php echo $tip_karoserije; ?>" required><br>
            <label for="godina_proizvodnje">Godina proizvodnje:</label><br>
            <input type="text" id="godina_proizvodnje" name="godina_proizvodnje" value="<?php echo $godina_proizvodnje; ?>" required><br>
            <label for="zapremina_motora">Zapremina motora:</label><br>
            <input type="text" id="zapremina_motora" name="zapremina_motora" value="<?php echo $zapremina_motora; ?>" required> L<br>
            <label for="snaga_motora">Snaga motora:</label><br>
            <input type="text" id="snaga_motora" name="snaga_motora" value="<?php echo $snaga_motora; ?>" required> kW<br>
            <label for="vrsta_motora">Vrsta motora:</label><br>
            <input type="text" id="vrsta_motora" name="vrsta_motora" value="<?php echo $vrsta_motora; ?>" required><br>
            <label for="broj_sjedista">Broj sjedišta:</label><br>
            <input type="text" id="broj_sjedista" name="broj_sjedista" value="<?php echo $broj_sjedista; ?>" required><br>
            <label for="nosivost">Nosivost:</label><br>
            <input type="text" id="nosivost" name="nosivost" value="<?php echo $nosivost; ?>" required> kg<br><br>
            <input type="submit" value="Ažuriraj vozilo" class="btn">
            <a href="index.php?page=vozilo" class="btn">Odustani</a>
        </form>
    </div>
</body>
</html>