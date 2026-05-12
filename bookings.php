<?php
// bookings.php - Manage Bookings
include 'config.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_booking'])) {
        $stmt = $pdo->prepare("INSERT INTO bookings (guest_id, room_id, check_in, check_out, status, total_amount) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['guest_id'], $_POST['room_id'], $_POST['check_in'], $_POST['check_out'], $_POST['status'], $_POST['total_amount']]);
        // Update room status to occupied
        $pdo->prepare("UPDATE rooms SET status='occupied' WHERE id=?")->execute([$_POST['room_id']]);
    } elseif (isset($_POST['update_booking'])) {
        $stmt = $pdo->prepare("UPDATE bookings SET guest_id=?, room_id=?, check_in=?, check_out=?, status=?, total_amount=? WHERE id=?");
        $stmt->execute([$_POST['guest_id'], $_POST['room_id'], $_POST['check_in'], $_POST['check_out'], $_POST['status'], $_POST['total_amount'], $_POST['id']]);
    } elseif (isset($_POST['delete_booking'])) {
        $stmt = $pdo->prepare("DELETE FROM bookings WHERE id=?");
        $stmt->execute([$_POST['id']]);
    }
}

// Fetch all bookings with guest and room info
$bookings = $pdo->query("SELECT b.*, g.name as guest_name, r.room_number FROM bookings b JOIN guests g ON b.guest_id = g.id JOIN rooms r ON b.room_id = r.id")->fetchAll(PDO::FETCH_ASSOC);

// Fetch guests and rooms for dropdowns
$guests = $pdo->query("SELECT id, name FROM guests")->fetchAll(PDO::FETCH_ASSOC);
$rooms = $pdo->query("SELECT id, room_number FROM rooms WHERE status='available'")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Réservations</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        form { margin-bottom: 20px; }
        input, select { margin: 5px; padding: 5px; }
    </style>
</head>
<body>
    <h1>Gestion des Réservations</h1>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="rooms.php">Chambres</a>
        <a href="guests.php">Clients</a>
        <a href="bookings.php">Réservations</a>
        <a href="payments.php">Paiements</a>
    </nav>

    <h2>Ajouter une Réservation</h2>
    <form method="POST">
        <select name="guest_id" required>
            <option value="">Sélectionner Client</option>
            <?php foreach ($guests as $guest): ?>
                <option value="<?php echo $guest['id']; ?>"><?php echo $guest['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <select name="room_id" required>
            <option value="">Sélectionner Chambre</option>
            <?php foreach ($rooms as $room): ?>
                <option value="<?php echo $room['id']; ?>"><?php echo $room['room_number']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="date" name="check_in" required>
        <input type="date" name="check_out" required>
        <select name="status">
            <option value="confirmed">Confirmée</option>
            <option value="checked_in">Enregistré</option>
            <option value="checked_out">Sorti</option>
            <option value="cancelled">Annulée</option>
        </select>
        <input type="number" step="0.01" name="total_amount" placeholder="Montant Total">
        <button type="submit" name="add_booking">Ajouter</button>
    </form>

    <h2>Liste des Réservations</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Client</th>
            <th>Chambre</th>
            <th>Arrivée</th>
            <th>Départ</th>
            <th>Statut</th>
            <th>Montant</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($bookings as $booking): ?>
        <tr>
            <td><?php echo $booking['id']; ?></td>
            <td><?php echo $booking['guest_name']; ?></td>
            <td><?php echo $booking['room_number']; ?></td>
            <td><?php echo $booking['check_in']; ?></td>
            <td><?php echo $booking['check_out']; ?></td>
            <td><?php echo $booking['status']; ?></td>
            <td><?php echo $booking['total_amount']; ?>€</td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $booking['id']; ?>">
                    <select name="guest_id" required>
                        <?php foreach ($guests as $guest): ?>
                            <option value="<?php echo $guest['id']; ?>" <?php if ($guest['id'] == $booking['guest_id']) echo 'selected'; ?>><?php echo $guest['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="room_id" required>
                        <?php foreach ($rooms as $room): ?>
                            <option value="<?php echo $room['id']; ?>" <?php if ($room['id'] == $booking['room_id']) echo 'selected'; ?>><?php echo $room['room_number']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="date" name="check_in" value="<?php echo $booking['check_in']; ?>" required>
                    <input type="date" name="check_out" value="<?php echo $booking['check_out']; ?>" required>
                    <select name="status">
                        <option value="confirmed" <?php if ($booking['status'] == 'confirmed') echo 'selected'; ?>>Confirmée</option>
                        <option value="checked_in" <?php if ($booking['status'] == 'checked_in') echo 'selected'; ?>>Enregistré</option>
                        <option value="checked_out" <?php if ($booking['status'] == 'checked_out') echo 'selected'; ?>>Sorti</option>
                        <option value="cancelled" <?php if ($booking['status'] == 'cancelled') echo 'selected'; ?>>Annulée</option>
                    </select>
                    <input type="number" step="0.01" name="total_amount" value="<?php echo $booking['total_amount']; ?>">
                    <button type="submit" name="update_booking">Modifier</button>
                    <button type="submit" name="delete_booking" onclick="return confirm('Supprimer cette réservation?')">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>