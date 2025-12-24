<?php
require_once '../config/database.php';
requireLogin();

if (!canManageItems()) {
    header('Location: dashboard.php?error=access_denied');
    exit();
}

$conn = getDBConnection();
$message = '';
$message_type = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        $item_name = trim($_POST['item_name'] ?? '');
        $item_description = trim($_POST['item_description'] ?? '');
        $item_category = trim($_POST['item_category'] ?? '');
        $item_price = floatval($_POST['item_price'] ?? 0);
        $item_quantity = intval($_POST['item_quantity'] ?? 0);
        $item_code = trim($_POST['item_code'] ?? '');
        
        if (!empty($item_name) && $item_price > 0) {
            $stmt = $conn->prepare("INSERT INTO items_tbl (item_name, item_description, item_category, item_price, item_quantity, item_code) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssdss", $item_name, $item_description, $item_category, $item_price, $item_quantity, $item_code);
            
            if ($stmt->execute()) {
                $message = "Item added successfully!";
                $message_type = "success";
            } else {
                $message = "Error adding item: " . $conn->error;
                $message_type = "error";
            }
            $stmt->close();
        } else {
            $message = "Please fill all required fields!";
            $message_type = "error";
        }
    } elseif ($action === 'update') {
        $item_id = intval($_POST['item_id'] ?? 0);
        $item_name = trim($_POST['item_name'] ?? '');
        $item_description = trim($_POST['item_description'] ?? '');
        $item_category = trim($_POST['item_category'] ?? '');
        $item_price = floatval($_POST['item_price'] ?? 0);
        $item_quantity = intval($_POST['item_quantity'] ?? 0);
        $item_code = trim($_POST['item_code'] ?? '');
        
        if ($item_id > 0 && !empty($item_name) && $item_price > 0) {
            $stmt = $conn->prepare("UPDATE items_tbl SET item_name=?, item_description=?, item_category=?, item_price=?, item_quantity=?, item_code=? WHERE item_id=?");
            $stmt->bind_param("sssdssi", $item_name, $item_description, $item_category, $item_price, $item_quantity, $item_code, $item_id);
            
            if ($stmt->execute()) {
                $message = "Item updated successfully!";
                $message_type = "success";
            } else {
                $message = "Error updating item: " . $conn->error;
                $message_type = "error";
            }
            $stmt->close();
        }
    }
}


if (isset($_GET['delete'])) {
    $item_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM items_tbl WHERE item_id=?");
    $stmt->bind_param("i", $item_id);
    
    if ($stmt->execute()) {
        $message = "Item deleted successfully!";
        $message_type = "success";
    } else {
        $message = "Error deleting item: " . $conn->error;
        $message_type = "error";
    }
    $stmt->close();
}


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


$edit_item = null;
if (isset($_GET['edit'])) {
    $item_id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM items_tbl WHERE item_id=?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $edit_item = $result->fetch_assoc();
    }
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Items - InventoryHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>
    
    <main class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-box"></i> Manage Items</h1>
            <div class="page-actions">
                <button class="btn btn-primary" onclick="openAddModal()">
                    <i class="fas fa-plus"></i> Add New Item
                </button>
            </div>
        </div>
        
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <i class="fas fa-<?php echo $message_type === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-header">
                <h3>Search Items</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="items.php" class="search-form">
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
                        <a href="items.php" class="btn btn-outline">
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
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['item_code'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                                        <td><?php echo htmlspecialchars($item['item_category'] ?? 'N/A'); ?></td>
                                        <td>₱<?php echo number_format($item['item_price'], 2); ?></td>
                                        <td>
                                            <span class="badge <?php echo $item['item_quantity'] < 10 ? 'badge-warning' : 'badge-success'; ?>">
                                                <?php echo $item['item_quantity']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="items.php?edit=<?php echo $item['item_id']; ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="items.php?delete=<?php echo $item['item_id']; ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirmDelete('item')">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
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
    
   
    <div id="itemModal" class="modal <?php echo $edit_item ? 'show' : ''; ?>">
        <div class="modal-content">
            <div class="modal-header">
                <h3><?php echo $edit_item ? 'Edit Item' : 'Add New Item'; ?></h3>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <form method="POST" action="items.php">
                <input type="hidden" name="action" value="<?php echo $edit_item ? 'update' : 'add'; ?>">
                <?php if ($edit_item): ?>
                    <input type="hidden" name="item_id" value="<?php echo $edit_item['item_id']; ?>">
                <?php endif; ?>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label>Item Name <span class="required">*</span></label>
                        <input type="text" name="item_name" required 
                               value="<?php echo htmlspecialchars($edit_item['item_name'] ?? ''); ?>"
                               class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>Item Code</label>
                        <input type="text" name="item_code" 
                               value="<?php echo htmlspecialchars($edit_item['item_code'] ?? ''); ?>"
                               class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" name="item_category" 
                               value="<?php echo htmlspecialchars($edit_item['item_category'] ?? ''); ?>"
                               class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="item_description" rows="3" 
                                  class="form-control"><?php echo htmlspecialchars($edit_item['item_description'] ?? ''); ?></textarea>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Price <span class="required">*</span></label>
                            <input type="number" name="item_price" step="0.01" required 
                                   value="<?php echo $edit_item['item_price'] ?? ''; ?>"
                                   class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Quantity <span class="required">*</span></label>
                            <input type="number" name="item_quantity" required 
                                   value="<?php echo $edit_item['item_quantity'] ?? 0; ?>"
                                   class="form-control">
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> <?php echo $edit_item ? 'Update' : 'Add'; ?> Item
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <?php include '../Bot/chatbot.php'; ?>
    <script src="../assets/js/main.js"></script>
    <script>
        function openAddModal() {
            const modal = document.getElementById('itemModal');
            if (modal) {
                
                const form = modal.querySelector('form');
                if (form) {
                    form.reset();
                    
                    const actionInput = form.querySelector('input[name="action"]');
                    if (actionInput) {
                        actionInput.value = 'add';
                    }
                    
                    const itemIdInput = form.querySelector('input[name="item_id"]');
                    if (itemIdInput) {
                        itemIdInput.remove();
                    }
                   
                    const modalTitle = modal.querySelector('.modal-header h3');
                    if (modalTitle) {
                        modalTitle.textContent = 'Add New Item';
                    }
                   
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-save"></i> Add Item';
                    }
                }
                modal.classList.add('show');
            }
        }
        
        function closeModal() {
            const modal = document.getElementById('itemModal');
            if (modal) {
                modal.classList.remove('show');
            }
      
            if (window.location.search.includes('edit=')) {
                window.location.href = 'items.php';
            }
        }
        
        function confirmDelete(type) {
            return confirm('Are you sure you want to delete this ' + type + '? This action cannot be undone.');
        }
        
      
        window.onclick = function(event) {
            const modal = document.getElementById('itemModal');
            if (event.target == modal) {
                closeModal();
            }
        }
        
     
        <?php if ($edit_item): ?>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('itemModal');
                if (modal) {
                    modal.classList.add('show');
                }
            });
        <?php endif; ?>
    </script>
</body>
</html>
