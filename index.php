<?php
// index.php - Hotel Management System Dashboard
include 'config.php';

$roomCount = $pdo->query("SELECT COUNT(*) FROM rooms")->fetchColumn();
$guestCount = $pdo->query("SELECT COUNT(*) FROM guests")->fetchColumn();
$bookingCount = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status != 'cancelled'")->fetchColumn();
$availableRooms = $pdo->query("SELECT COUNT(*) FROM rooms WHERE status = 'available'")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Système de Gestion d'Hôtel</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .dashboard { display: flex; gap: 20px; }
        .card { border: 1px solid #ccc; padding: 20px; border-radius: 5px; flex: 1; }
        nav { margin-bottom: 20px; }
        nav a { margin-right: 15px; text-decoration: none; color: blue; }
    </style>
</head>
<body>
    <h1>Système de Gestion d'Hôtel</h1>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="rooms.php">Chambres</a>
        <a href="guests.php">Clients</a>
        <a href="bookings.php">Réservations</a>
        <a href="payments.php">Paiements</a>
    </nav>

    <div class="dashboard">
        <div class="card">
            <h2>Chambres Totales</h2>
            <p><?php echo $roomCount; ?></p>
        </div>
        <div class="card">
            <h2>Clients</h2>
            <p><?php echo $guestCount; ?></p>
        </div>
        <div class="card">
            <h2>Réservations Actives</h2>
            <p><?php echo $bookingCount; ?></p>
        </div>
        <div class="card">
            <h2>Chambres Disponibles</h2>
            <p><?php echo $availableRooms; ?></p>
        </div>
    </div>
</body>
</html>