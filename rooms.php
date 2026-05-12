<?php
// rooms.php - Manage Rooms
include 'config.php';
include 'session.php';

// Check if user is admin or receptionist
requireLogin();
if (!hasRole('admin') && !hasRole('receptionist')) {
    header('Location: index.php?error=unauthorized');
    exit();
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_room'])) {
        $image_path = null;
        
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/rooms/';
            $file_name = time() . '_' . basename($_FILES['image']['name']);
            $upload_path = $upload_dir . $file_name;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                $image_path = $upload_path;
            }
        }
        
        $stmt = $pdo->prepare("INSERT INTO rooms (room_number, room_type, price, status, image_path, description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['room_number'], $_POST['room_type'], $_POST['price'], $_POST['status'], $image_path, $_POST['description']]);
    } elseif (isset($_POST['update_room'])) {
        $image_path = $_POST['current_image'];
        
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/rooms/';
            $file_name = time() . '_' . basename($_FILES['image']['name']);
            $upload_path = $upload_dir . $file_name;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                // Delete old image if exists
                if ($image_path && file_exists($image_path)) {
                    unlink($image_path);
                }
                $image_path = $upload_path;
            }
        }
        
        $stmt = $pdo->prepare("UPDATE rooms SET room_number=?, room_type=?, price=?, status=?, image_path=?, description=? WHERE id=?");
        $stmt->execute([$_POST['room_number'], $_POST['room_type'], $_POST['price'], $_POST['status'], $image_path, $_POST['description'], $_POST['id']]);
    } elseif (isset($_POST['delete_room'])) {
        // Get image path and delete file
        $stmt = $pdo->prepare("SELECT image_path FROM rooms WHERE id=?");
        $stmt->execute([$_POST['id']]);
        $room = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($room && $room['image_path'] && file_exists($room['image_path'])) {
            unlink($room['image_path']);
        }
        
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
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="room_number" placeholder="Numéro de chambre" required>
        <input type="text" name="room_type" placeholder="Type de chambre" required>
        <input type="number" step="0.01" name="price" placeholder="Prix" required>
        <select name="status">
            <option value="available">Disponible</option>
            <option value="occupied">Occupée</option>
            <option value="maintenance">Maintenance</option>
        </select>
        <textarea name="description" placeholder="Description de la chambre"></textarea>
        <label>Image de la chambre:</label>
        <input type="file" name="image" accept="image/*">
        <button type="submit" name="add_room">Ajouter</button>
    </form>

    <h2>Liste des Chambres</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Numéro</th>
            <th>Type</th>
            <th>Prix</th>
            <th>Description</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($rooms as $room): ?>
        <tr>
            <td><?php echo $room['id']; ?></td>
            <td>
                <?php if ($room['image_path'] && file_exists($room['image_path'])): ?>
                    <img src="<?php echo $room['image_path']; ?>" style="max-width: 100px; max-height: 100px;">
                <?php else: ?>
                    <span style="color: #999;">Aucune image</span>
                <?php endif; ?>
            </td>
            <td><?php echo $room['room_number']; ?></td>
            <td><?php echo $room['room_type']; ?></td>
            <td><?php echo $room['price']; ?>€</td>
            <td><?php echo substr($room['description'], 0, 50); ?></td>
            <td><?php echo $room['status']; ?></td>
            <td>
                <form method="POST" enctype="multipart/form-data" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $room['id']; ?>">
                    <input type="hidden" name="current_image" value="<?php echo $room['image_path']; ?>">
                    <input type="text" name="room_number" value="<?php echo $room['room_number']; ?>" required>
                    <input type="text" name="room_type" value="<?php echo $room['room_type']; ?>" required>
                    <input type="number" step="0.01" name="price" value="<?php echo $room['price']; ?>" required>
                    <select name="status">
                        <option value="available" <?php if ($room['status'] == 'available') echo 'selected'; ?>>Disponible</option>
                        <option value="occupied" <?php if ($room['status'] == 'occupied') echo 'selected'; ?>>Occupée</option>
                        <option value="maintenance" <?php if ($room['status'] == 'maintenance') echo 'selected'; ?>>Maintenance</option>
                    </select>
                    <textarea name="description"><?php echo $room['description']; ?></textarea>
                    <input type="file" name="image" accept="image/*">
                    <button type="submit" name="update_room">Modifier</button>
                    <button type="submit" name="delete_room" onclick="return confirm('Supprimer cette chambre?')">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>