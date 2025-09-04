<?php 
session_start(); 
if (isset($_SESSION['user_id'])): ?>
    <h1>Download Section</h1>
    <a href="admin_dashboard/download_archive.php">download</a>

    <h1>Intro Section</h1>
    <a href="admin_dashboard/intro_archive.php">intro</a>

    <h1>about Section</h1>
    <a href="admin_dashboard/aboutus_archive.php">About us</a>


    <h1>Mission & Vision Section</h1>
    <a href="admin_dashboard/mvision_archive.php">Mvision</a>


    <h1>Services Section</h1>
    <a href="admin_dashboard/services_archive.php">Services</a>

    <h1>Testimonial Section</h1>
    <a href="admin_dashboard/testimonial_archive.php">Testimonial</a>

    <h1>Contact Section</h1>
    <a href="admin_dashboard/contact_archive.php">Testimonial</a>
<?php 
else: 
    header("Location: ../index.php");
    exit;
endif; 
?>
    