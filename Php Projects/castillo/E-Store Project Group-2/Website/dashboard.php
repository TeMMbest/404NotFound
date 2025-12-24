<?php
require_once '../config/database.php';
requireLogin();

$conn = getDBConnection();


$stats = [];


$result = $conn->query("SELECT COUNT(*) as total FROM items_tbl");
$stats['total_items'] = $result->fetch_assoc()['total'];


$result = $conn->query("SELECT COUNT(*) as total FROM users_tbl");
$stats['total_users'] = $result->fetch_assoc()['total'];


$result = $conn->query("SELECT COUNT(*) as total FROM items_tbl WHERE item_quantity < 10");
$stats['low_stock'] = $result->fetch_assoc()['total'];


$result = $conn->query("SELECT * FROM items_tbl ORDER BY created_at DESC LIMIT 5");
$recent_items = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - InventoryHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>
    
    <main class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
            <p>Welcome back, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: #4CAF50;">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['total_items']; ?></h3>
                    <p>Total Items</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: #2196F3;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['total_users']; ?></h3>
                    <p>Total Users</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: #FF9800;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $stats['low_stock']; ?></h3>
                    <p>Low Stock Items</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: #9C27B0;">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $_SESSION['position']; ?></h3>
                    <p>Your Position</p>
                </div>
            </div>
        </div>
        
        <div class="content-grid">
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-clock"></i> Recent Items</h3>
                </div>
                <div class="card-body">
                    <?php if (count($recent_items) > 0): ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_items as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                                        <td><?php echo htmlspecialchars($item['item_category'] ?? 'N/A'); ?></td>
                                        <td>₱<?php echo number_format($item['item_price'], 2); ?></td>
                                        <td><?php echo $item['item_quantity']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-muted">No items found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    
    <?php include '../Bot/chatbot.php'; ?>
    <script src="../assets/js/main.js"></script>
</body>
</html>
