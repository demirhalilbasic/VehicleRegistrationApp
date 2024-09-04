<?php
require_once('db_konekcija.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['delete'])) {
        $id_vozila = $_POST['id_vozila'];

        $sql = "DELETE FROM Vozilo WHERE id_vozila='$id_vozila'";

        if ($conn->query($sql) === TRUE) {
            header("Location: index.php?page=vozilo");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['cancel'])) {
        header("Location: index.php?page=vozilo");
        exit();
    }
}

if(isset($_GET['id_vozila'])) {
    $id_vozila = $_GET['id_vozila'];

    $sql = "SELECT * FROM Vozilo WHERE id_vozila='$id_vozila'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $brend = $row["brend"];
        $model = $row["model"];
        $VIN = $row["VIN"];
        $boja = $row["boja"];
        $tip_karoserije = $row["tip_karoserije"];
        $godina_proizvodnje = $row["godina_proizvodnje"];
        $zapremina_motora = $row["zapremina_motora"];
        $snaga_motora = $row["snaga_motora"];
        $vrsta_motora = $row["vrsta_motora"];
        $broj_sjedista = $row["broj_sjedista"];
        $nosivost = $row["nosivost"];
    } else {
        echo "Greška: Vozilo nije pronađeno.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Brisanje vozila</title>
</head>
<body>
    <div class="container">
        <h1>Brisanje vozila</h1>
        <?php if(isset($row)): ?>
        <p>Da li ste sigurni da želite obrisati vozilo:</p>
        <p>ID vozila: <?php echo $id_vozila; ?></p>
        <p>Brend: <?php echo $brend; ?></p>
        <p>Model: <?php echo $model; ?></p>
        <p>VIN: <?php echo $VIN; ?></p>
        <p>Boja: <?php echo $boja; ?></p>
        <p>Tip karoserije: <?php echo $tip_karoserije; ?></p>
        <p>Godina proizvodnje: <?php echo $godina_proizvodnje; ?></p>
        <p>Zapremina motora: <?php echo $zapremina_motora; ?></p>
        <p>Snaga motora: <?php echo $snaga_motora; ?></p>
        <p>Vrsta motora: <?php echo $vrsta_motora; ?></p>
        <p>Broj sjedišta: <?php echo $broj_sjedista; ?></p>
        <p>Nosivost: <?php echo $nosivost; ?></p>
        <form action="delete_vozilo.php" method="post">
            <input type="hidden" name="id_vozila" value="<?php echo $id_vozila; ?>">
            <input type="submit" name="delete" value="Obriši" class="btn">
            <input type="submit" name="cancel" value="Odustani" class="btn">
        </form>
        <?php else: ?>
        <p>Greška: Vozilo nije pronađeno.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>