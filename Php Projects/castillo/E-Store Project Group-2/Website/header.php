<header class="main-header">
    <div class="header-content">
        <div class="header-left">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <h2 class="logo">
                <i class="fas fa-store"></i> InventoryHub
            </h2>
        </div>
        <div class="header-right">
            <div class="user-menu">
                <span class="user-info">
                    <i class="fas fa-user-circle"></i>
                    <?php echo htmlspecialchars($_SESSION['full_name']); ?>
                    <span class="badge badge-<?php echo strtolower($_SESSION['position']); ?>">
                        <?php echo $_SESSION['position']; ?>
                    </span>
                </span>
                <a href="logout.php" class="btn btn-sm btn-outline">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>
</header>
