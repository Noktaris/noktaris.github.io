<?php
session_start();

// Authentification basique
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

define('SERVEUR', '10.56.8.61');
define('LOGIN', 'minde001');
define('MDP', 'LPH3r96Gxh');
define('BASE', 'blog');

$mysqli = new mysqli(SERVEUR, LOGIN, MDP, BASE);

if ($mysqli->connect_error) {
    die("Erreur de connexion : " . $mysqli->connect_error);
}

// Filtre : afficher tous les messages ou seulement ceux non traités
$filtre = isset($_GET['voir_tout']) ? "" : "WHERE statut = 'non traité'";

// Marquer un message comme traité
if (isset($_POST['marquer_traite'])) {
    $id = (int) $_POST['id'];
    $mysqli->query("UPDATE messages SET statut = 'traité' WHERE id = $id");
}

// Supprimer un message traité
if (isset($_POST['supprimer'])) {
    $id = (int) $_POST['id'];
    $mysqli->query("DELETE FROM messages WHERE id = $id");
}

// Récupérer les messages
$result = $mysqli->query("SELECT * FROM messages $filtre ORDER BY date_envoi DESC");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des Messages</title>
</head>
<body>
    <h2>Messages reçus</h2>
    <a href="admin_messages.php?voir_tout=1">Voir tout</a> |
    <a href="admin_messages.php">Voir non traités</a>
    <table border="1">
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Message</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['nom']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['message']) ?></td>
            <td><?= $row['date_envoi'] ?></td>
            <td><?= $row['statut'] ?></td>
            <td>
                <?php if ($row['statut'] == 'non traité') { ?>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" name="marquer_traite">Marquer comme traité</button>
                    </form>
                <?php } else { ?>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" name="supprimer">Supprimer</button>
                    </form>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php
$mysqli->close();
?>
