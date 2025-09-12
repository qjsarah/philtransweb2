<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}
include 'admin_navbar.php';
?>
<!-- Main content -->
<div id="mainContent">
  <h1 class="mb-4 display-3" style="color:#000066">Welcome to the Admin Dashboard</h1>
  <p class="display-6">Select a section from the sidebar to manage its archives.</p>
</div>

