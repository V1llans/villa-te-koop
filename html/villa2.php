<?php
$databaseFile = "biedingen2.db";

// Verbinding maken met de database
try {
    $dbh = new PDO("sqlite:" . $databaseFile);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Fout bij het maken van de databaseverbinding: " . $e->getMessage();
    die();
}
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>bekijk villa</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Prompt:wght@100;200;300;400;500;600;700;800;900&display=swap"
      rel="stylesheet"
    />
    <script src="../JS/slideshow.js" defer></script>
  </head>
  <body>
    <nav>
      <a id="logo" href="index.html">
        <img src="../img/villaTeKoop-logo.png" alt="villa te koop logo" />
        <h3>Villa te koop</h3>
      </a>
      <a href="index.html">Home</a>
      <a href="./contact.html">Contact</a>
      <div id="nav-buttons">
        <button id="login-btn">Log in</button>
        <button id="register-btn">Register</button>
      </div>
    </nav>
    <section class="slider-wrapper">
      <button class="slide-arrow" id="slide-arrow-prev">
        &#8249;
      </button>
      <button class="slide-arrow" id="slide-arrow-next">
        &#8250;
      </button>
      <ul class="slides-container" id="slides-container">
        <img src="../img/villa 2 foto 1.png" width="100%" class="slide"></img>
        <img src="../img/villa 2 foto 1.png" width="100%" class="slide"></img>
        <img src="../img/villa 2 foto 1.png" width="100%" class="slide"></img>
        <img src="../img/img-placeholder.png" width="100%" class="slide"></img>
        <img src="../img/img-placeholder.png" width="100%" class="slide"></img>
        <img src="../img/img-placeholder.png" width="100%" class="slide"></img>
        <img src="../img/img-placeholder.png" width="100%" class="slide"></img>
        <img src="../img/img-placeholder.png" width="100%" class="slide"></img>
        <img src="../img/img-placeholder.png" width="100%" class="slide"></img>
        <img src="../img/img-placeholder.png" width="100%" class="slide"></img>
        <img src="../img/img-placeholder.png" width="100%" class="slide"></img>
        <img src="../img/img-placeholder.png" width="100%" class="slide"></img>
        <img src="../img/img-placeholder.png" width="100%" class="slide"></img>
        <img src="../img/img-placeholder.png" width="100%" class="slide"></img>
        <img src="../img/img-placeholder.png" width="100%" class="slide"></img>
      </ul>
    </section>
    <main id="villa-info">
      <section id="villa-beschrijving">
        <h1>Villa Sydney</h1>
        <h3>Beschrijving</h3>
          <p>Betreed een wereld van elegantie en grandeur in een betoverende villa. Met ruime kamers, hoogwaardige afwerking en prachtige architectuur, biedt deze exclusieve woning een ongeëvenaarde levensstijl. Geniet van luxe voorzieningen zoals een privébioscoop, een professionele keuken en een prachtig aangelegde tuin. In deze villa komen dromen tot leven en ervaart u het toppunt van luxe wonen.</p>      </section>
      <section>
        <h3>Locatie</h3>
        <img src="../img/maps-placeholder.jpeg" alt="maps placeholder">
      </section>
    </main>
    <article id="veiling">
  <section>
    <h3>Hoogste biedingen:</h3>
    <?php
    // Vraag alleen de 4 hoogste biedingen op (van hoog naar laag)
    $query = "SELECT voornaam, bod FROM bod ORDER BY bod DESC LIMIT 4";
    $statement = $dbh->query($query);
    $boden = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($boden as $bod) {
        $voornaam = $bod['voornaam'];
        $bericht = $bod['bod'];

        echo "<p>Naam: $voornaam | Bod: € $bericht</p>";
    }
    ?>
  </section>
  <form method="POST" id="contact-form" >
    <h3>Doe een bod</h3>
    <input type="text" name="voornaam" placeholder="Voornaam" required/>
    <input type="text" name="achternaam" placeholder="Achternaam" required/>
    <input type="tel" id="telefoonnummer" name="telefoonnummer" placeholder="Telefoonnummer" required>
    <input type="text" id="email" name="email" placeholder="Email" required>
    <input type="text" id="bod" name="bod" pattern="[0-9]{6,8}" placeholder="Je bod hier" required>
    <input type="submit" value="Verstuur" class="submit-button">
  </form>
</article>
    <?php
    // Controleer of het formulier is ingediend
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Gegevens van het formulier ophalen
        $voornaam = $_POST['voornaam'];
        $achternaam = $_POST['achternaam'];
        $email = $_POST['email'];
        $telefoonnummer = $_POST['telefoonnummer'];
        $bod = $_POST['bod'];

        // Controleren of de email al bestaat in de database
        $existingQuery = "SELECT COUNT(*) as count FROM bod WHERE email = ?";
        $existingStatement = $dbh->prepare($existingQuery);
        $existingStatement->execute([$email]);
        $existingResult = $existingStatement->fetch(PDO::FETCH_ASSOC);

        if ($existingResult['count'] > 0) {
            echo "Een opmerking met dit e-mailadres bestaat al.";
        } else {
            // Voeg gegevens toe aan de database
            $insertQuery = "INSERT INTO bod (voornaam, achternaam, email, telefoonnummer, bod) 
                      VALUES (?, ?, ?, ?, ?)";
            $insertStatement = $dbh->prepare($insertQuery);
            $insertStatement->execute([$voornaam, $achternaam, $email, $telefoonnummer, $bod]);

        }
    }

    // Vraag/opmerkingen uit de database ophalen
    $query = "SELECT voornaam, bod FROM bod";
    $statement = $dbh->query($query);
    $boden = $statement->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <footer>
      <div id="footer-nav">
        <a href="#">Mobile app</a>
        <a href="#">Community</a>
        <a href="#">Company</a>
        <img src="../img/villaTeKoop-logo.png" alt="villa te koop logo" />
        <a href="#">Help Desk</a>
        <a href="#">Blog</a>
        <a href="#">Resources</a>
      </div>
      <a href="https://github.com/V1llans/villa-te-koop"
        ><img src="../img/github.png" alt="github" id="github"
      /></a>
      <p id="footer-text">Made by: Pauline, Brian en Uros</p>
    </footer>
  </body>
</html>
