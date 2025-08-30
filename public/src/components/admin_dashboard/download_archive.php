<?php
include '../backend/config.php';

$key = 'phone_img'; // you can make this dynamic if needed

$stmt = $conn->prepare("SELECT * FROM download_archive WHERE key_name = ? ORDER BY created_at DESC");
$stmt->bind_param("s", $key);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Archived Images for <?php echo htmlspecialchars($key); ?></h2>
<table border="1" cellpadding="10">
    <tr>
        <th>Preview</th>
        <th>File Name</th>
        <th>Uploaded On</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><img src="../public/main/images/download_section/<?php echo $row['file_name']; ?>" width="120"></td>
        <td><?php echo htmlspecialchars($row['file_name']); ?></td>
        <td><?php echo $row['created_at']; ?></td>
        <td>
            <form method="POST" action="../backend/admin_dashboard/restore_archive.php">
                <input type="hidden" name="archive_id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="key_name" value="<?php echo $row['key_name']; ?>">
                <button type="submit">Restore</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
