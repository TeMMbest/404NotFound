<?php
require_once '../config/database.php';
requireLogin();

$conn = getDBConnection();


$search = $_GET['search'] ?? '';
$search_query = '%' . $search . '%';


if (!empty($search)) {
    $stmt = $conn->prepare("SELECT * FROM items_tbl WHERE item_name LIKE ? OR item_code LIKE ? OR item_category LIKE ? ORDER BY item_name");
    $stmt->bind_param("sss", $search_query, $search_query, $search_query);
    $stmt->execute();
    $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    $result = $conn->query("SELECT * FROM items_tbl ORDER BY item_name");
    $items = $result->fetch_all(MYSQLI_ASSOC);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Items - InventoryHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>
    
    <main class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-eye"></i> View Items</h1>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3>Search Items</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="items_view.php" class="search-form">
                    <div class="form-group">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Search by name, code, or category..." 
                            value="<?php echo htmlspecialchars($search); ?>"
                            class="form-control"
                        >
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <?php if (!empty($search)): ?>
                        <a href="items_view.php" class="btn btn-outline">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3>Items List</h3>
            </div>
            <div class="card-body">
                <?php if (count($items) > 0): ?>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['item_code'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                                        <td><?php echo htmlspecialchars($item['item_category'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($item['item_description'] ?? 'N/A'); ?></td>
                                        <td>₱<?php echo number_format($item['item_price'], 2); ?></td>
                                        <td>
                                            <span class="badge <?php echo $item['item_quantity'] < 10 ? 'badge-warning' : 'badge-success'; ?>">
                                                <?php echo $item['item_quantity']; ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No items found.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
    
    <?php include '../Bot/chatbot.php'; ?>
    <script src="../assets/js/main.js"></script>
</body>
</html>
