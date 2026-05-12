<?php
// index.php - Hotel Management System Dashboard
include 'config.php';
include 'session.php';

// Redirect to login if not authenticated
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$roomCount = $pdo->query("SELECT COUNT(*) FROM rooms")->fetchColumn();
$guestCount = $pdo->query("SELECT COUNT(*) FROM guests")->fetchColumn();
$bookingCount = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status != 'cancelled'")->fetchColumn();
$availableRooms = $pdo->query("SELECT COUNT(*) FROM rooms WHERE status = 'available'")->fetchColumn();

// Handle logout
if (isset($_GET['logout'])) {
    logout();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Système de Gestion d'Hôtel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 { font-size: 24px; }
        .user-info {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        .user-info span { font-size: 14px; }
        .logout-btn {
            background: rgba(255, 255, 255, 0.3);
            border: 1px solid white;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .logout-btn:hover { background: rgba(255, 255, 255, 0.5); }
        nav { 
            background: white;
            padding: 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        nav a { 
            display: inline-block;
            padding: 15px 20px;
            text-decoration: none; 
            color: #333;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }
        nav a:hover { 
            background: #f0f0f0;
            border-bottom-color: #667eea;
        }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .dashboard { 
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .card { 
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s;
        }
        .card:hover { transform: translateY(-5px); }
        .card h2 { color: #666; font-size: 14px; margin-bottom: 10px; text-transform: uppercase; }
        .card p { font-size: 32px; color: #667eea; font-weight: bold; }
        .restricted { color: #999; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Système de Gestion d'Hôtel</h1>
        <div class="user-info">
            <span>Connecté en tant que: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong> (<?php echo ucfirst($_SESSION['role']); ?>)</span>
            <a href="index.php?logout=1" class="logout-btn">Déconnexion</a>
        </div>
    </div>

    <nav>
        <a href="index.php">Accueil</a>
        
        <?php if (hasRole('admin') || hasRole('receptionist')): ?>
            <a href="rooms.php">Chambres</a>
            <a href="bookings.php">Réservations</a>
            <a href="payments.php">Paiements</a>
        <?php endif; ?>

        <?php if (hasRole('admin')): ?>
            <a href="guests.php">Clients</a>
            <a href="admin.php">Gestion Admin</a>
        <?php endif; ?>

        <?php if (hasRole('guest')): ?>
            <a href="client_bookings.php">Mes Réservations</a>
            <a href="available_rooms.php">Réserver une Chambre</a>
        <?php endif; ?>
    </nav>

    <div class="container">
        <?php if (hasRole('admin') || hasRole('receptionist')): ?>
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
        <?php else: ?>
            <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                <h2>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
                <p style="margin-top: 10px; color: #666;">
                    Vous pouvez consulter les chambres disponibles et faire vos réservations.
                </p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>