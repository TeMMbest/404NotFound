<aside class="sidebar" id="sidebar">
    <nav class="sidebar-nav">
        <a href="dashboard.php" class="nav-item">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        
        <?php if (canManageItems()): ?>
            <a href="items.php" class="nav-item">
                <i class="fas fa-box"></i>
                <span>Manage Items</span>
            </a>
        <?php endif; ?>
        
        <?php if (hasPosition('Viewer') || canManageItems()): ?>
            <a href="items_view.php" class="nav-item">
                <i class="fas fa-eye"></i>
                <span>View Items</span>
            </a>
        <?php endif; ?>
        
        <?php if (canManageUsers()): ?>
            <a href="users.php" class="nav-item">
                <i class="fas fa-users-cog"></i>
                <span>Manage Users</span>
            </a>
        <?php endif; ?>
        
        <a href="credits.php" class="nav-item">
            <i class="fas fa-users"></i>
            <span>Credits</span>
        </a>
    </nav>
</aside>
