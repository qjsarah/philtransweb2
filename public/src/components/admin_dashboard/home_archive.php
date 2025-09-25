<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}
include 'admin_navbar.php';
?>

  <h1 class="mb-4 display-4" style="color:#000066">Welcome to the Admin Dashboard</h1>
  <p class="display-6">Select a section from the sidebar to manage its archives.</p>


