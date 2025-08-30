<?php
include '../config.php';

if (isset($_POST['archive_id'], $_POST['key_name'])) {
    $archiveId = (int) $_POST['archive_id'];
    $keyName   = $_POST['key_name'];

    // Get file name from archive
    $stmt = $conn->prepare("SELECT file_name FROM download_archive WHERE id = ?");
    $stmt->bind_param("i", $archiveId);
    $stmt->execute();
    $stmt->bind_result($fileName);
    $stmt->fetch();
    $stmt->close();

    if ($fileName) {
        // Save current image to archive before restoring
        $stmt = $conn->prepare("SELECT content FROM download WHERE key_name = ?");
        $stmt->bind_param("s", $keyName);
        $stmt->execute();
        $stmt->bind_result($currentImage);
        $stmt->fetch();
        $stmt->close();

        if ($currentImage) {
            $stmt = $conn->prepare("INSERT INTO download_archive (key_name, file_name) VALUES (?, ?)");
            $stmt->bind_param("ss", $keyName, $currentImage);
            $stmt->execute();
            $stmt->close();
        }

        // Restore old image
        $stmt = $conn->prepare("UPDATE download SET content = ? WHERE key_name = ?");
        $stmt->bind_param("ss", $fileName, $keyName);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: ../../components/admin_dashboard/download_archive.php");
exit;
