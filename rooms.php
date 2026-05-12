<?php
// rooms.php - Manage Rooms
include 'config.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_room'])) {
        $stmt = $pdo->prepare("INSERT INTO rooms (room_number, room_type, price, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['room_number'], $_POST['room_type'], $_POST['price'], $_POST['status']]);
    } elseif (isset($_POST['update_room'])) {
        $stmt = $pdo->prepare("UPDATE rooms SET room_number=?, room_type=?, price=?, status=? WHERE id=?");
        $stmt->execute([$_POST['room_number'], $_POST['room_type'], $_POST['price'], $_POST['status'], $_POST['id']]);
    } elseif (isset($_POST['delete_room'])) {
        $stmt = $pdo->prepare("DELETE FROM rooms WHERE id=?");
        $stmt->execute([$_POST['id']]);
    }
}

// Fetch all rooms
$rooms = $pdo->query("SELECT * FROM rooms")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Chambres</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        form { margin-bottom: 20px; }
        input, select { margin: 5px; padding: 5px; }
    </style>
</head>
<body>
    <h1>Gestion des Chambres</h1>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="rooms.php">Chambres</a>
        <a href="guests.php">Clients</a>
        <a href="bookings.php">Réservations</a>
        <a href="payments.php">Paiements</a>
    </nav>

    <h2>Ajouter une Chambre</h2>
    <form method="POST">
        <input type="text" name="room_number" placeholder="Numéro de chambre" required>
        <input type="text" name="room_type" placeholder="Type de chambre" required>
        <input type="number" step="0.01" name="price" placeholder="Prix" required>
        <select name="status">
            <option value="available">Disponible</option>
            <option value="occupied">Occupée</option>
            <option value="maintenance">Maintenance</option>
        </select>
        <button type="submit" name="add_room">Ajouter</button>
    </form>

    <h2>Liste des Chambres</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Numéro</th>
            <th>Type</th>
            <th>Prix</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($rooms as $room): ?>
        <tr>
            <td><?php echo $room['id']; ?></td>
            <td><?php echo $room['room_number']; ?></td>
            <td><?php echo $room['room_type']; ?></td>
            <td><?php echo $room['price']; ?>€</td>
            <td><?php echo $room['status']; ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $room['id']; ?>">
                    <input type="text" name="room_number" value="<?php echo $room['room_number']; ?>" required>
                    <input type="text" name="room_type" value="<?php echo $room['room_type']; ?>" required>
                    <input type="number" step="0.01" name="price" value="<?php echo $room['price']; ?>" required>
                    <select name="status">
                        <option value="available" <?php if ($room['status'] == 'available') echo 'selected'; ?>>Disponible</option>
                        <option value="occupied" <?php if ($room['status'] == 'occupied') echo 'selected'; ?>>Occupée</option>
                        <option value="maintenance" <?php if ($room['status'] == 'maintenance') echo 'selected'; ?>>Maintenance</option>
                    </select>
                    <button type="submit" name="update_room">Modifier</button>
                    <button type="submit" name="delete_room" onclick="return confirm('Supprimer cette chambre?')">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>