<?php
$databaseFile = "mijnvilla.db";

// Verbinding maken met de database
try {
    $dbh = new PDO("sqlite:" . $databaseFile);
} catch (PDOException $e) {
    echo "Fout bij het maken van de databaseverbinding: " . $e->getMessage();
    die();
}

// Controleer of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Gegevens van het formulier ophalen
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];
    $telefoonnummer = $_POST['telefoonnummer'];
    $vraag_opmerking = $_POST['vraag_opmerking'];

    // Voeg gegevens toe aan de database
    $query = "INSERT INTO contact_form (voornaam, achternaam, email, telefoonnummer, vraag_opmerking) 
              VALUES (?, ?, ?, ?, ?)";
    $statement = $dbh->prepare($query);
    $statement->execute([$voornaam, $achternaam, $email, $telefoonnummer, $vraag_opmerking]);

    echo "Opmerking geplaatst" ;
}

// Vraag/opmerkingen uit de database ophalen
$query = "SELECT voornaam, achternaam, vraag_opmerking FROM contact_form";
$statement = $dbh->query($query);
$vraag_opmerkingen = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Prompt:wght@100;200;300;400;500;600;700;800;900&display=swap"
      rel="stylesheet"
    />
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
    <form action="/php/contact.php method="POST" id="contact-form">
      <h1>Neem contact met ons op</h1>
      <p>
        heeft u een vraag of is er iets waarvan u denkt: dit klopt niet? neem
        dan contact met ons op via dit formulier
      </p>
      <div id="form">
        <input type="text" placeholder="voornaam" />
        <input type="text" placeholder="achternaam" />
        <input type="text" placeholder="telefoonnummer" />
        <input type="text" placeholder="email" />
        <textarea placeholder="vraag/opmerking" cols="40" rows="3"></textarea>
        <input type="submit" value="verstuur" class="submit-button" />
      </div>
    </form>

    <?php
foreach ($vraag_opmerkingen as $vraag_opmerking) {
    $voornaam = $vraag_opmerking['voornaam'];
    $achternaam = $vraag_opmerking['achternaam'];
    $bericht = $vraag_opmerking['vraag_opmerking'];

    echo "<p><strong>$voornaam $achternaam:</strong> $bericht</p>";
}
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
