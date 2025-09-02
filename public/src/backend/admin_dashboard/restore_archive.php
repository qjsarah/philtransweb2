<?php
include '../config.php';

if (isset($_POST['id'], $_POST['key_name'])) {
    $id  = (int)$_POST['id'];
    $key = $_POST['key_name'];

    // Fetch archive record
    $stmt = $conn->prepare("SELECT file_name FROM download_archive WHERE id=? AND key_name=?");
    $stmt->bind_param("is", $id, $key);
    $stmt->execute();
    $stmt->bind_result($restoreFile);
    $stmt->fetch();
    $stmt->close();

    if ($restoreFile) {
        // Define folders
        $rootPath   = dirname(__DIR__, 4);
        $archiveDir = $rootPath . "/public/main/images/download_section/archive/";
        $uploadDir  = $rootPath . "/public/main/images/download_section/";

        $archivePath = $archiveDir . $restoreFile;
        $restorePath = $uploadDir . $restoreFile;

        // ✅ STEP 1: Get the current active image
        $stmt = $conn->prepare("SELECT content FROM download WHERE key_name=?");
        $stmt->bind_param("s", $key);
        $stmt->execute();
        $stmt->bind_result($currentImage);
        $stmt->fetch();
        $stmt->close();

        $currentFile = $currentImage ? basename($currentImage) : null;

        // ✅ STEP 2: Copy archived file back to main folder
        if (file_exists($archivePath)) {
            if (copy($archivePath, $restorePath)) {

                // If there’s an active file, move it to archive
                if ($currentFile && file_exists($uploadDir . $currentFile)) {
                    $archivedName = time() . "_archived_" . $currentFile;
                    $archivedPath = $archiveDir . $archivedName;

                    if (rename($uploadDir . $currentFile, $archivedPath)) {
                        $stmt = $conn->prepare("INSERT INTO download_archive (key_name, file_name) VALUES (?, ?)");
                        $stmt->bind_param("ss", $key, $archivedName);
                        $stmt->execute();
                        $stmt->close();
                    }
                }

                // ✅ STEP 3: Update main table (store only file name)
                $dbPath = $restoreFile;
                $stmt = $conn->prepare("UPDATE download SET content=? WHERE key_name=?");
                $stmt->bind_param("ss", $dbPath, $key);
                $stmt->execute();
                $stmt->close();

                // ✅ STEP 4: Remove restored file from archive table + folder
                $stmt = $conn->prepare("DELETE FROM download_archive WHERE id=?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->close();

                unlink($archivePath);
            }
        }
    }
}

header("Location: ../../components/admin_dashboard/download_archive.php");
exit;
