<?php
// Connexion à la base de données
$conn = new mysqli("10.56.8.61", "minde001", "LPH3r96Gxh", "portfolio_db");

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Récupérer les données du formulaire
$nom = htmlspecialchars($_POST['nom']);
$prenom = htmlspecialchars($_POST['prenom']);
$email = htmlspecialchars($_POST['email']);
$telephone = htmlspecialchars($_POST['phone']);
$message = htmlspecialchars($_POST['message']);

// Vérifier si tous les champs requis sont remplis
if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($message)) {
    // Préparer la requête
    $stmt = $conn->prepare("INSERT INTO messages (nom, prenom, email, telephone, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nom, $prenom, $email, $telephone, $message);

    if ($stmt->execute()) {
        echo "Message envoyé avec succès !";
    } else {
        echo "Erreur lors de l'envoi du message.";
    }
    
    $stmt->close();
} else {
    echo "Veuillez remplir tous les champs obligatoires.";
}

$conn->close();
?>
