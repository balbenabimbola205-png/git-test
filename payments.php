<?php
// payments.php - Manage Payments
include 'config.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_payment'])) {
        $stmt = $pdo->prepare("INSERT INTO payments (booking_id, amount, payment_date, payment_method) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['booking_id'], $_POST['amount'], $_POST['payment_date'], $_POST['payment_method']]);
    } elseif (isset($_POST['update_payment'])) {
        $stmt = $pdo->prepare("UPDATE payments SET booking_id=?, amount=?, payment_date=?, payment_method=? WHERE id=?");
        $stmt->execute([$_POST['booking_id'], $_POST['amount'], $_POST['payment_date'], $_POST['payment_method'], $_POST['id']]);
    } elseif (isset($_POST['delete_payment'])) {
        $stmt = $pdo->prepare("DELETE FROM payments WHERE id=?");
        $stmt->execute([$_POST['id']]);
    }
}

// Fetch all payments with booking info
$payments = $pdo->query("SELECT p.*, b.id as booking_id, g.name as guest_name, r.room_number FROM payments p JOIN bookings b ON p.booking_id = b.id JOIN guests g ON b.guest_id = g.id JOIN rooms r ON b.room_id = r.id")->fetchAll(PDO::FETCH_ASSOC);

// Fetch bookings for dropdown
$bookings = $pdo->query("SELECT b.id, g.name, r.room_number FROM bookings b JOIN guests g ON b.guest_id = g.id JOIN rooms r ON b.room_id = r.id")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Paiements</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        form { margin-bottom: 20px; }
        input, select { margin: 5px; padding: 5px; }
    </style>
</head>
<body>
    <h1>Gestion des Paiements</h1>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="rooms.php">Chambres</a>
        <a href="guests.php">Clients</a>
        <a href="bookings.php">Réservations</a>
        <a href="payments.php">Paiements</a>
    </nav>

    <h2>Ajouter un Paiement</h2>
    <form method="POST">
        <select name="booking_id" required>
            <option value="">Sélectionner Réservation</option>
            <?php foreach ($bookings as $booking): ?>
                <option value="<?php echo $booking['id']; ?>"><?php echo $booking['name'] . ' - ' . $booking['room_number']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" step="0.01" name="amount" placeholder="Montant" required>
        <input type="date" name="payment_date" required>
        <input type="text" name="payment_method" placeholder="Méthode de paiement" required>
        <button type="submit" name="add_payment">Ajouter</button>
    </form>

    <h2>Liste des Paiements</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Réservation</th>
            <th>Montant</th>
            <th>Date</th>
            <th>Méthode</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($payments as $payment): ?>
        <tr>
            <td><?php echo $payment['id']; ?></td>
            <td><?php echo $payment['guest_name'] . ' - ' . $payment['room_number']; ?></td>
            <td><?php echo $payment['amount']; ?>€</td>
            <td><?php echo $payment['payment_date']; ?></td>
            <td><?php echo $payment['payment_method']; ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $payment['id']; ?>">
                    <select name="booking_id" required>
                        <?php foreach ($bookings as $booking): ?>
                            <option value="<?php echo $booking['id']; ?>" <?php if ($booking['id'] == $payment['booking_id']) echo 'selected'; ?>><?php echo $booking['name'] . ' - ' . $booking['room_number']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" step="0.01" name="amount" value="<?php echo $payment['amount']; ?>" required>
                    <input type="date" name="payment_date" value="<?php echo $payment['payment_date']; ?>" required>
                    <input type="text" name="payment_method" value="<?php echo $payment['payment_method']; ?>" required>
                    <button type="submit" name="update_payment">Modifier</button>
                    <button type="submit" name="delete_payment" onclick="return confirm('Supprimer ce paiement?')">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>