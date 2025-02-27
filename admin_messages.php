<?php
session_start();

// Vérifier l'authentification (à améliorer avec un vrai système de connexion)
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$conn = new mysqli("10.56.8.61", "minde001", "LPH3r96Gxh", "portfolio_db");

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Filtre : Afficher seulement les messages non traités par défaut
$filtre = "WHERE statut = 'non traité'";
if (isset($_GET['voir_tout'])) {
    $filtre = ""; // Afficher tous les messages
}

// Marquer un message comme traité
if (isset($_GET['traiter'])) {
    $id = intval($_GET['traiter']);
    $conn->query("UPDATE messages SET statut = 'traité' WHERE id = $id");
    header("Location: admin_messages.php");
    exit();
}

// Récupérer les messages
$result = $conn->query("SELECT * FROM messages $filtre ORDER BY date_envoi DESC");

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Messages</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<h1>Gestion des Messages</h1>
<a href="admin_messages.php?voir_tout=1">Voir tous les messages</a>

<table border="1">
    <tr>
        <th>Nom</th>
        <th>Email</th>
        <th>Message</th>
        <th>Date</th>
        <th>Statut</th>
        <th>Action</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['nom']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['message']) ?></td>
            <td><?= $row['date_envoi'] ?></td>
            <td><?= $row['statut'] ?></td>
            <td>
                <?php if ($row['statut'] == "non traité"): ?>
                    <a href="admin_messages.php?traiter=<?= $row['id'] ?>">Marquer comme traité</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

</body>
</html>
