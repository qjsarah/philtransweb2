<?php
// Include database config
include 'config.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs safely
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit;
    }

    // Prepare SQL query
    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("sss", $name, $email, $message);

    // Execute and redirect
    if ($stmt->execute()) {
        echo "<script>alert('Your message has been sent successfully!'); window.location.href='../index.php#contact';</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../index.php#contact");
    exit();
}
?>
