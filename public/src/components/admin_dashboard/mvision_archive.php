<link rel="stylesheet" href="../../../main/style/main.css">
<?php
include __DIR__ . '/../../backend/config.php';

$keys = ['mission_img', 'vision_img', 'phone3_img'];
$placeholders = implode(',', array_fill(0, count($keys), '?')); // ?,?,?,?

$sql = "SELECT * FROM missionvision_archive WHERE key_name IN ($placeholders) ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);

// bind_param requires types string. We can do str_repeat('s', count($keys))
$stmt->bind_param(str_repeat('s', count($keys)), ...$keys);
$stmt->execute();
$result = $stmt->get_result();

?>
<div class="container">
    <h1 class="mb-3">Archived Images for Misson and Vision Section</h1>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col">
                <div class="card h-auto p-3">
                    <img src="/philtransweb2/public/main/images/mission_and_vission_section/archive/<?php echo htmlspecialchars($row['file_name']); ?>" 
                        class="card-img-top" 
                        alt="Archived Image">

                    <div class="card-body">
                        <p class="card-text">
                            <small class="text-muted">Uploaded On: <?php echo $row['created_at']; ?></small>
                        </p>
                    </div>

                    <div class="card-footer text-center">
                        <form method="POST" action="../../backend/admin_dashboard/restore_mvision.php" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="key_name" value="<?php echo $row['key_name']; ?>">
                            <button type="button" class="btn btn-outline-primary border-none restore-button">↺</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-secondary text-light w-100 d-flex align-items-center justify-content-center" style="height: 450px;">
                <p class="mb-0">No archived images found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<script src="../../../main/scripts/bootstrap.bundle.min.js"></script>
<script src="/philtransweb2/public/main/scripts/swal_archive.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>