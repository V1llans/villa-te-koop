<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voornaam = $_POST["voornaam"];
    $achternaam = $_POST["achternaam"];
    $telefoonnummer = $_POST["telefoonnummer"];
    $email = $_POST["email"];
    $vraag = $_POST["vraag"];

    $to = "89605@glr.nl"; //Uros Email
    $subject = "Contactformulier - Villa te koop";
    $message = "Voornaam: " . $voornaam . "\n" .
               "Achternaam: " . $achternaam . "\n" .
               "Telefoonnummer: " . $telefoonnummer . "\n" .
               "E-mail: " . $email . "\n" .
               "Vraag/opmerking: " . $vraag;

    //Verzend           
    mail($to, $subject, $message);
}
?>
