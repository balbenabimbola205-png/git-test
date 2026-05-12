<?php
// guests.php - Manage Guests
include 'config.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_guest'])) {
        $stmt = $pdo->prepare("INSERT INTO guests (name, email, phone, address) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address']]);
    } elseif (isset($_POST['update_guest'])) {
        $stmt = $pdo->prepare("UPDATE guests SET name=?, email=?, phone=?, address=? WHERE id=?");
        $stmt->execute([$_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address'], $_POST['id']]);
    } elseif (isset($_POST['delete_guest'])) {
        $stmt = $pdo->prepare("DELETE FROM guests WHERE id=?");
        $stmt->execute([$_POST['id']]);
    }
}

// Fetch all guests
$guests = $pdo->query("SELECT * FROM guests")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Clients</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        form { margin-bottom: 20px; }
        input, textarea { margin: 5px; padding: 5px; }
    </style>
</head>
<body>
    <h1>Gestion des Clients</h1>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="rooms.php">Chambres</a>
        <a href="guests.php">Clients</a>
        <a href="bookings.php">Réservations</a>
        <a href="payments.php">Paiements</a>
    </nav>

    <h2>Ajouter un Client</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Nom" required>
        <input type="email" name="email" placeholder="Email">
        <input type="text" name="phone" placeholder="Téléphone">
        <textarea name="address" placeholder="Adresse"></textarea>
        <button type="submit" name="add_guest">Ajouter</button>
    </form>

    <h2>Liste des Clients</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Adresse</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($guests as $guest): ?>
        <tr>
            <td><?php echo $guest['id']; ?></td>
            <td><?php echo $guest['name']; ?></td>
            <td><?php echo $guest['email']; ?></td>
            <td><?php echo $guest['phone']; ?></td>
            <td><?php echo $guest['address']; ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $guest['id']; ?>">
                    <input type="text" name="name" value="<?php echo $guest['name']; ?>" required>
                    <input type="email" name="email" value="<?php echo $guest['email']; ?>">
                    <input type="text" name="phone" value="<?php echo $guest['phone']; ?>">
                    <textarea name="address"><?php echo $guest['address']; ?></textarea>
                    <button type="submit" name="update_guest">Modifier</button>
                    <button type="submit" name="delete_guest" onclick="return confirm('Supprimer ce client?')">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>