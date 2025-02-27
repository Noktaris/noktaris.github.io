<?php
define('SERVEUR', '10.56.8.61');
define('LOGIN', 'minde001');
define('MDP', 'LPH3r96Gxh');
define('BASE', 'blog');

$mysqli = new mysqli(SERVEUR, LOGIN, MDP, BASE);

if ($mysqli->connect_error) {
    die("Erreur de connexion : " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $mysqli->real_escape_string($_POST['nom']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $message = $mysqli->real_escape_string($_POST['message']);

    $sql = "INSERT INTO messages (nom, email, message) VALUES ('$nom', '$email', '$message')";

    if ($mysqli->query($sql)) {
        echo "Message envoyé avec succès.";
    } else {
        echo "Erreur : " . $mysqli->error;
    }
}

$mysqli->close();
?>
