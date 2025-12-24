<?php
require_once '../config/database.php';
requireLogin();

if (!canManageUsers()) {
    header('Location: dashboard.php?error=access_denied');
    exit();
}

$conn = getDBConnection();
$message = '';
$message_type = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $position = $_POST['position'] ?? '';
        $status = $_POST['status'] ?? 'Active';
        
        if (!empty($username) && !empty($password) && !empty($first_name) && !empty($last_name) && !empty($position)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users_tbl (uname, upword, ufname, ulname, uposition, ustatus) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $username, $hashed_password, $first_name, $last_name, $position, $status);
            
            if ($stmt->execute()) {
                $message = "User added successfully!";
                $message_type = "success";
            } else {
                $message = "Error adding user: " . $conn->error;
                $message_type = "error";
            }
            $stmt->close();
        } else {
            $message = "Please fill all required fields!";
            $message_type = "error";
        }
    } elseif ($action === 'update') {
        $user_id = intval($_POST['user_id'] ?? 0);
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $position = $_POST['position'] ?? '';
        $status = $_POST['status'] ?? 'Active';
        
        if ($user_id > 0 && !empty($username) && !empty($first_name) && !empty($last_name) && !empty($position)) {
            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users_tbl SET uname=?, upword=?, ufname=?, ulname=?, uposition=?, ustatus=? WHERE user_id=?");
                $stmt->bind_param("ssssssi", $username, $hashed_password, $first_name, $last_name, $position, $status, $user_id);
            } else {
                $stmt = $conn->prepare("UPDATE users_tbl SET uname=?, ufname=?, ulname=?, uposition=?, ustatus=? WHERE user_id=?");
                $stmt->bind_param("sssssi", $username, $first_name, $last_name, $position, $status, $user_id);
            }
            
            if ($stmt->execute()) {
                $message = "User updated successfully!";
                $message_type = "success";
            } else {
                $message = "Error updating user: " . $conn->error;
                $message_type = "error";
            }
            $stmt->close();
        }
    }
}


if (isset($_GET['delete'])) {
    $user_id = intval($_GET['delete']);
    
 
    if ($user_id == $_SESSION['user_id']) {
        $message = "You cannot delete your own account!";
        $message_type = "error";
    } else {
        $stmt = $conn->prepare("DELETE FROM users_tbl WHERE user_id=?");
        $stmt->bind_param("i", $user_id);
        
        if ($stmt->execute()) {
            $message = "User deleted successfully!";
            $message_type = "success";
        } else {
            $message = "Error deleting user: " . $conn->error;
            $message_type = "error";
        }
        $stmt->close();
    }
}


$search = $_GET['search'] ?? '';
$search_query = '%' . $search . '%';


if (!empty($search)) {
    $stmt = $conn->prepare("SELECT * FROM users_tbl WHERE uname LIKE ? OR ufname LIKE ? OR ulname LIKE ? OR uposition LIKE ? ORDER BY ufname, ulname");
    $stmt->bind_param("ssss", $search_query, $search_query, $search_query, $search_query);
    $stmt->execute();
    $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    $result = $conn->query("SELECT * FROM users_tbl ORDER BY ufname, ulname");
    $users = $result->fetch_all(MYSQLI_ASSOC);
}


$edit_user = null;
if (isset($_GET['edit'])) {
    $user_id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM users_tbl WHERE user_id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $edit_user = $result->fetch_assoc();
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
    <title>Manage Users - InventoryHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>
    
    <main class="main-content">
        <div class="page-header">
            <h1><i class="fas fa-users-cog"></i> Manage Users</h1>
            <div class="page-actions">
                <button class="btn btn-primary" onclick="openAddModal()">
                    <i class="fas fa-user-plus"></i> Add New User
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
                <h3>Search Users</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="users.php" class="search-form">
                    <div class="form-group">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Search by username, first name, last name, or position..." 
                            value="<?php echo htmlspecialchars($search); ?>"
                            class="form-control"
                        >
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <?php if (!empty($search)): ?>
                        <a href="users.php" class="btn btn-outline">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3>Users List</h3>
            </div>
            <div class="card-body">
                <?php if (count($users) > 0): ?>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Full Name</th>
                                    <th>Position</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user['uname']); ?></td>
                                        <td><?php echo htmlspecialchars(trim($user['ufname'] . ' ' . $user['ulname'])); ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo strtolower($user['uposition']); ?>">
                                                <?php echo $user['uposition']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?php echo strtolower($user['ustatus']); ?>">
                                                <?php echo $user['ustatus']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="users.php?edit=<?php echo $user['user_id']; ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <?php if ($user['user_id'] != $_SESSION['user_id']): ?>
                                                <a href="users.php?delete=<?php echo $user['user_id']; ?>" 
                                                   class="btn btn-sm btn-danger" 
                                                   onclick="return confirmDelete('user')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Current User</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No users found.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
    
   
    <div id="userModal" class="modal <?php echo $edit_user ? 'show' : ''; ?>">
        <div class="modal-content">
            <div class="modal-header">
                <h3><?php echo $edit_user ? 'Edit User' : 'Add New User'; ?></h3>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <form method="POST" action="users.php">
                <input type="hidden" name="action" value="<?php echo $edit_user ? 'update' : 'add'; ?>">
                <?php if ($edit_user): ?>
                    <input type="hidden" name="user_id" value="<?php echo $edit_user['user_id']; ?>">
                <?php endif; ?>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label>Username <span class="required">*</span></label>
                        <input type="text" name="username" required 
                               value="<?php echo htmlspecialchars($edit_user['uname'] ?? ''); ?>"
                               class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>Password <?php echo $edit_user ? '(leave blank to keep current)' : '<span class="required">*</span>'; ?></label>
                        <input type="password" name="password" 
                               <?php echo $edit_user ? '' : 'required'; ?>
                               class="form-control"
                               placeholder="<?php echo $edit_user ? 'Enter new password or leave blank' : 'Enter password'; ?>">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name <span class="required">*</span></label>
                            <input type="text" name="first_name" required 
                                   value="<?php echo htmlspecialchars($edit_user['ufname'] ?? ''); ?>"
                                   class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Last Name <span class="required">*</span></label>
                            <input type="text" name="last_name" required 
                                   value="<?php echo htmlspecialchars($edit_user['ulname'] ?? ''); ?>"
                                   class="form-control">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Position <span class="required">*</span></label>
                            <select name="position" required class="form-control">
                                <option value="">Select Position</option>
                                <option value="Admin" <?php echo ($edit_user['uposition'] ?? '') === 'Admin' ? 'selected' : ''; ?>>Admin</option>
                                <option value="Encoder" <?php echo ($edit_user['uposition'] ?? '') === 'Encoder' ? 'selected' : ''; ?>>Encoder</option>
                                <option value="Viewer" <?php echo ($edit_user['uposition'] ?? '') === 'Viewer' ? 'selected' : ''; ?>>Viewer</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Status <span class="required">*</span></label>
                            <select name="status" required class="form-control">
                                <option value="Active" <?php echo ($edit_user['ustatus'] ?? 'Active') === 'Active' ? 'selected' : ''; ?>>Active</option>
                                <option value="Inactive" <?php echo ($edit_user['ustatus'] ?? '') === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> <?php echo $edit_user ? 'Update' : 'Add'; ?> User
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <?php include '../Bot/chatbot.php'; ?>
    <script src="../assets/js/main.js"></script>
    <script>
        function openAddModal() {
            const modal = document.getElementById('userModal');
            if (modal) {
                
                const form = modal.querySelector('form');
                if (form) {
                    form.reset();
              
                    const actionInput = form.querySelector('input[name="action"]');
                    if (actionInput) {
                        actionInput.value = 'add';
                    }
             
                    const userIdInput = form.querySelector('input[name="user_id"]');
                    if (userIdInput) {
                        userIdInput.remove();
                    }
            
                    const modalTitle = modal.querySelector('.modal-header h3');
                    if (modalTitle) {
                        modalTitle.textContent = 'Add New User';
                    }
              
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-save"></i> Add User';
                    }
             
                    const passwordInput = form.querySelector('input[name="password"]');
                    if (passwordInput) {
                        passwordInput.required = true;
                        passwordInput.placeholder = 'Enter password';
                    }
          
                    const passwordLabel = form.querySelector('label[for], label');
                    if (passwordLabel && passwordLabel.textContent.includes('Password')) {
                        const passwordLabelText = form.querySelectorAll('label');
                        passwordLabelText.forEach(label => {
                            if (label.textContent.includes('Password')) {
                                label.innerHTML = 'Password <span class="required">*</span>';
                            }
                        });
                    }
                }
                modal.classList.add('show');
            }
        }
        
        function closeModal() {
            const modal = document.getElementById('userModal');
            if (modal) {
                modal.classList.remove('show');
            }
  
            if (window.location.search.includes('edit=')) {
                window.location.href = 'users.php';
            }
        }
        
        function confirmDelete(type) {
            return confirm('Are you sure you want to delete this ' + type + '? This action cannot be undone.');
        }
        

        window.onclick = function(event) {
            const modal = document.getElementById('userModal');
            if (event.target == modal) {
                closeModal();
            }
        }
        

        <?php if ($edit_user): ?>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('userModal');
                if (modal) {
                    modal.classList.add('show');
                }
            });
        <?php endif; ?>
    </script>
</body>
</html>
