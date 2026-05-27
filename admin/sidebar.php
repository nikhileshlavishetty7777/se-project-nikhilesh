<?php 
// Include the session start check to ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get the current page filename for active menu highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Sidebar Start -->
<!-- sidebar.php -->
<aside id="sidebar" class="sidebar bg-light p-3 shadow-sm" style="min-height: 100vh; width: 250px; position: fixed;">
    <a href="#" class="brand">
        <img src="../images/logo.png" width="80px" alt="">
    </a>
    <ul class="side-menu top">
        <li class="active">
            <a href="dashboard.php">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="manage-admin.php">
                <i class='bx bxs-group'></i>
                <span class="text">Admin Panel</span>
            </a>
        </li>
        <li>
            <a href="manage-online-order.php">
                <i class='bx bxs-cart'></i>
                <span class="text">Online Orders</span>
                <?php if ($row_online_order_notif > 0) { ?>
                    <span class="num-ei"><?php echo $row_online_order_notif; ?></span>
                <?php } ?>
            </a>
        </li>
        <li>
            <a href="manage-ei-order.php">
                <i class='bx bx-qr-scan'></i>
                <span class="text">Eat In Orders</span>
                <?php if ($row_ei_order_notif > 0) { ?>
                    <span class="num-ei"><?php echo $row_ei_order_notif; ?></span>
                <?php } ?>
            </a>
        </li>
        <li>
            <a href="settings.php">
                <i class='bx bxs-cog'></i>
                <span class="text">Settings</span>
            </a>
        </li>
        <li>
            <a href="logout.php" class="logout">
                <i class='bx bxs-log-out-circle'></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>
</aside>

<!-- Sidebar End -->

<!-- Sidebar CSS -->
<style>
  .nav-link {
    display: flex;
    align-items: center;
    padding: 10px 15px;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-weight: 500;
  }

  .nav-link:hover {
    background-color: #f1f1f1;
    text-decoration: none;
  }

  .active-link {
    background-color: #5A4FCF;
    color: white !important;
    font-weight: 600;
  }

  .active-link:hover {
    background-color: #483dba;
  }

  /* Custom sidebar width and fixed positioning */
  .sidebar {
    min-height: 100vh;
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    padding-top: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }

  /* Optional: Hide sidebar on small screens and toggle visibility */
  @media (max-width: 768px) {
    .sidebar {
      width: 100%;
      position: relative;
      min-height: 100vh;
    }

    .sidebar .nav-link {
      padding: 10px;
    }
  }
</style>
