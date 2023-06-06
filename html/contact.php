<?php
$databaseFile = "mijnvilla.db";

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
    <form action="" method="POST" id="contact-form">
  <h1>Neem contact met ons op</h1>
  <p>
    heeft u een vraag of is er iets waarvan u denkt: dit klopt niet? neem
    dan contact met ons op via dit formulier
  </p>
  <div id="form">
    <input type="text" name="voornaam" placeholder="voornaam" />
    <input type="text" name="achternaam" placeholder="achternaam" />
    <input type="text" name="telefoonnummer" placeholder="telefoonnummer" />
    <input type="text" name="email" placeholder="email" />
    <textarea name="vraag_opmerking" placeholder="vraag/opmerking" cols="40" rows="3"></textarea>
    <input type="submit" value="verstuur" class="submit-button" />
  </div>
  <?php
// Controleer of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Gegevens van het formulier ophalen
  $voornaam = $_POST['voornaam'];
  $achternaam = $_POST['achternaam'];
  $email = $_POST['email'];
  $telefoonnummer = $_POST['telefoonnummer'];
  $vraag_opmerking = $_POST['vraag_opmerking'];

  // Controleren of de email al bestaat in de database
  $existingQuery = "SELECT COUNT(*) as count FROM contact_form WHERE email = ?";
  $existingStatement = $dbh->prepare($existingQuery);
  $existingStatement->execute([$email]);
  $existingResult = $existingStatement->fetch(PDO::FETCH_ASSOC);

  if ($existingResult['count'] > 0) {
      echo "Een opmerking met dit e-mailadres bestaat al.";
  } else {
      // Voeg gegevens toe aan de database
      $insertQuery = "INSERT INTO contact_form (voornaam, achternaam, email, telefoonnummer, vraag_opmerking) 
                      VALUES (?, ?, ?, ?, ?)";
      $insertStatement = $dbh->prepare($insertQuery);
      $insertStatement->execute([$voornaam, $achternaam, $email, $telefoonnummer, $vraag_opmerking]);

}
}

// Vraag/opmerkingen uit de database ophalen
$query = "SELECT voornaam, achternaam, vraag_opmerking FROM contact_form";
$statement = $dbh->query($query);
$vraag_opmerkingen = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

</form>
    <div class="opmerkingen">
    <?php
    foreach ($vraag_opmerkingen as $vraag_opmerking) {
    $voornaam = $vraag_opmerking['voornaam'];
    $achternaam = $vraag_opmerking['achternaam'];
    $bericht = $vraag_opmerking['vraag_opmerking'];

    echo "<p><strong>$voornaam $achternaam:</strong> $bericht</p>";
}
?>
    </div>

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