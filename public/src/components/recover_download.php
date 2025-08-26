<?php
include "backend/config.php";

$id = $_POST['id'];

$stmt = $conn->prepare("SELECT * FROM download_archive WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($row) {
    $archivePath = "uploads/download/archive/{$row['file_name']}";
    $activePath  = "uploads/download/";

    if (file_exists($archivePath)) {
        $recoveredName = "recovered_" . time() . "_" . $row['original_name'];
        copy($archivePath, $activePath.$recoveredName);

        // Update main table
        $stmt = $conn->prepare("UPDATE download SET content=? WHERE key_name=?");
        $stmt->bind_param("ss", $recoveredName, $row['key_name']);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: download_archive.php");
