<?php
session_start();

if(isset($_GET['logout']) && $_GET['logout'] == 1) {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit;
}

$logged_in = false;
if(isset($_SESSION['user'])) {
    $logged_in = true;
}

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username === 'a' && $password === 'a') {
        $_SESSION['user'] = 'admin';
        $logged_in = true;
    } else if ($username === 'k' && $password === 'k') {
        $_SESSION['user'] = 'korisnik';
        $logged_in = true;
    } else {
        echo "<p style='color: red;'>Pogrešno korisničko ime ili lozinka.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upravljanje osiguranjem i registracija vozila</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <style>
        .container {
            position: relative;
        }
        .logout-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        color: maroon;
        font-weight: bold;
        text-decoration: none;
        padding: 8px 16px;
        background-color: white;
        border-radius: 4px;
        }
        .logout-btn:before {
            content: "";
            position: absolute;
            top: 50%;
            right: -10px;
            width: 0;
            height: 0;
            border-top: 6px solid transparent;
            border-bottom: 6px solid transparent;
            border-left: 8px solid maroon;
            transform: translateY(-50%);
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="?page=welcome">Dobrodošli</a></li>
                <?php if(isset($_SESSION['user']) && $_SESSION['user'] === 'admin'): ?>
                    <li><a href="?page=klijent">Klijent</a></li>
                    <li><a href="?page=osiguranje">Osiguranje</a></li>
                    <li><a href="?page=vozilo">Vozilo</a></li>
                    <li><a href="?page=registracija">Registracija</a></li>
                    <li><a href="?page=placanje">Plaćanje</a></li>
                <?php elseif(isset($_SESSION['user']) && $_SESSION['user'] === 'korisnik'): ?>
                    <li><a href="?page=pretraga_klijent">Pretraga po klijentu</a></li>
                    <li><a href="?page=pretraga_vozilo">Pretraga po vozilu</a></li>
                <?php endif; ?>
                <?php if($logged_in): ?>
                    <li><a href="?logout=1" class="logout-btn">Odjava</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <div class="container">
        <?php if(!$logged_in): ?>
            <h2>Prijava</h2>
            <form action="" method="POST">
                <label for="username">Korisničko ime:</label><br>
                <input type="text" id="username" name="username" required><br><br>
                <label for="password">Lozinka:</label><br>
                <input type="password" id="password" name="password" required><br><br>
                <button type="submit" class="btn">Prijava</button>
            </form>
        <?php else: ?>
            <?php
            if(isset($_GET['page'])) {
                $page = $_GET['page'];
                switch($page) {
                    case 'welcome':
                        echo "<h1>Aplikacija za upravljanje osiguranjem i registraciju vozila</h1>";
                        echo "<p>Dobrodošli na početnu stranicu aplikacije. Preproučujemo Vam da se služite meni trakom iznad
                                kako bi pristupili različitim funkcionalnostima aplikacije.</p>";
                        echo "<p>Omogućavamo Vam jednostavno vođenje evidencije o osiguranjima, pristup različitim
                                podacima i obavljanje administrativnih zadataka.</p>";
                        echo "<p>Nadamo se da ćete pronaći našu aplikaciju korisnom. Ukoliko uočite neku grešku u radu aplikacije
                                ili imate dodatna pitanja, molimo Vas kontaktirajte administraciju.</p><br>";
                        echo "<img src='vehicleicon.png' alt='vehicle-icon' width='200' height='190'>";
                        echo "<h2>Uputstvo za dodavanje nove registracije</h2>";
                        echo "<p>Prilikom registracije vozila klijenta koji prethodno nije unesen u sistem, molimo Vas da
                                unos u tabele vršite redoslijedom naglašenim u zaglavlju, odnosno unos treba biti slijedom:</p>";
                        echo "<ul>
                                <li>1. Klijent
                                <li>2. Osiguranje
                                <li>3. Vozilo
                                <li>4. Registracija
                                <li>5. Plaćanje
                              </ul>";
                        echo "<p>Na taj način biti će osigurano da su uneseni podaci adekvatno povezani i isti ne
                                narušavaju referencijalni integritet u bazi podataka, u suprotnom će program
                                javiti grešku prilikom unosa.</p>";
                        echo "<h2>Uputstvo za brisanje postojećeg zapisa iz sistema</h2>";
                        echo "<p>Prilikom brisanja postojećeg klijenta, njegovih podataka i registracija iz sistema, molimo Vas da
                                brisanje zapisa iz tabele vršite obrnutim redoslijedom naglašenim u zaglavlju, odnosno brisanje
                                treba biti slijedom:</p>";
                        echo "<ul>
                                <li>1. Plaćanje
                                <li>2. Registracija
                                <li>3. Vozilo
                                <li>4. Osiguranje
                                <li>5. Klijent
                              </ul>";
                        echo "<p>Svaki drugi vid pokušaja brisanja određenog zapisa, potencijalno može javiti grešku
                                i spriječiti izvršavanje željene naredbe.</p>";
                        break;
                    case 'klijent':
                        if($_SESSION['user'] === 'admin') {
                            include 'klijent.php';
                        } else {
                            echo "<p>Pravo pristupa odbijeno.</p>";
                        }
                        break;
                    case 'registracija':
                        if($_SESSION['user'] === 'admin') {
                            include 'registracija.php';
                        } else {
                            echo "<p>Pravo pristupa odbijeno.</p>";
                        }
                        break;
                    case 'placanje':
                        if($_SESSION['user'] === 'admin') {
                            include 'placanje.php';
                        } else {
                            echo "<p>Pravo pristupa odbijeno.</p>";
                        }
                        break;
                    case 'vozilo':
                        if($_SESSION['user'] === 'admin') {
                            include 'vozilo.php';
                        } else {
                            echo "<p>Pravo pristupa odbijeno.</p>";
                        }
                        break;
                    case 'osiguranje':
                        if($_SESSION['user'] === 'admin') {
                            include 'osiguranje.php';
                        } else {
                            echo "<p>Pravo pristupa odbijeno.</p>";
                        }
                        break;
                    case 'pretraga_klijent':
                        if($_SESSION['user'] === 'korisnik') {
                            echo "<h2>Pretraga klijenata</h2>";
                            echo "<div class='search-container'>";
                            echo "<input type='text' id='searchBarKlijent' class='searchBar' placeholder='Pretraži po imenu ili prezimenu'>";
                            echo "</div>";
                            echo "<div id='searchResultsKlijent'></div>";
                        } else {
                            echo "<p>Pravo pristupa odbijeno.</p>";
                        }
                        break;                       
                    case 'pretraga_vozilo':
                        if($_SESSION['user'] === 'korisnik') {
                            echo "<h2>Pretraga vozila</h2>";
                            echo "<div class='search-container'>";
                            echo "<input type='text' id='searchBarVozilo' class='searchBar' placeholder='Pretraži po VIN-u, brendu ili modelu'>";
                            echo "</div>";
                            echo "<div id='searchResultsVozilo'></div>";
                        } else {
                            echo "<p>Pravo pristupa odbijeno.</p>";
                        }
                        break;
                    default:
                        echo "<h1>404 - Stranica nije pronađena</h1>";
                }
            } else {
                echo "<h1>Aplikacija za upravljanje osiguranjem i registraciju vozila</h1>";
                echo "<p>Dobrodošli na početnu stranicu aplikacije. Preproučujemo Vam da se služite meni trakom iznad
                        kako bi pristupili različitim funkcionalnostima aplikacije.</p>";
                echo "<p>Omogućavamo Vam jednostavno vođenje evidencije o osiguranjima, pristup različitim
                        podacima i obavljanje administrativnih zadataka.</p>";
                echo "<p>Nadamo se da ćete pronaći našu aplikaciju korisnom. Ukoliko uočite neku grešku u radu aplikacije
                        ili imate dodatna pitanja, molimo Vas kontaktirajte administraciju.</p><br>";
                echo "<img src='vehicleicon.png' alt='vehicle-icon' width='200' height='190'>";
                echo "<h2>Uputstvo za dodavanje nove registracije</h2>";
                echo "<p>Prilikom registracije vozila klijenta koji prethodno nije unesen u sistem, molimo Vas da
                        unos u tabele vršite redoslijedom naglašenim u zaglavlju, odnosno unos treba biti slijedom:</p>";
                echo "<ul>
                        <li>1. Klijent
                        <li>2. Osiguranje
                        <li>3. Vozilo
                        <li>4. Registracija
                        <li>5. Plaćanje
                      </ul>";
                echo "<p>Na taj način biti će osigurano da su uneseni podaci adekvatno povezani i isti ne
                        narušavaju referencijalni integritet u bazi podataka, u suprotnom će program
                        javiti grešku prilikom unosa.</p>";
                echo "<h2>Uputstvo za brisanje postojećeg zapisa iz sistema</h2>";
                echo "<p>Prilikom brisanja postojećeg klijenta, njegovih podataka i registracija iz sistema, molimo Vas da
                        brisanje zapisa iz tabele vršite obrnutim redoslijedom naglašenim u zaglavlju, odnosno brisanje
                        treba biti slijedom:</p>";
                echo "<ul>
                        <li>1. Plaćanje
                        <li>2. Registracija
                        <li>3. Vozilo
                        <li>4. Osiguranje
                        <li>5. Klijent
                      </ul>";
                echo "<p>Svaki drugi vid pokušaja brisanja određenog zapisa, potencijalno može javiti grešku
                                i spriječiti izvršavanje željene naredbe.</p>";
            }
            ?>
        <?php endif; ?>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var searchBarKlijent = document.querySelector('#searchBarKlijent');
        var searchResultsKlijent = document.querySelector('#searchResultsKlijent');
        var searchBarVozilo = document.querySelector('#searchBarVozilo');
        var searchResultsVozilo = document.querySelector('#searchResultsVozilo');

        if (searchBarKlijent && searchResultsKlijent) {
            searchBarKlijent.addEventListener('input', function() {
                var searchQuery = this.value.trim();
                if (searchQuery === '') {
                    searchResultsKlijent.innerHTML = '';
                    return;
                }
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        searchResultsKlijent.innerHTML = xhr.responseText;
                    }
                };
                xhr.open('GET', 'pretraga_klijent.php?search=' + searchQuery, true);
                xhr.send();
            });
        }

        if (searchBarVozilo && searchResultsVozilo) {
            searchBarVozilo.addEventListener('input', function() {
                var searchQuery = this.value.trim();
                if (searchQuery === '') {
                    searchResultsVozilo.innerHTML = '';
                    return;
                }
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        searchResultsVozilo.innerHTML = xhr.responseText;
                    }
                };
                xhr.open('GET', 'pretraga_vozilo.php?search=' + searchQuery, true);
                xhr.send();
            });
        }
    });
    </script>
</body>
</html>