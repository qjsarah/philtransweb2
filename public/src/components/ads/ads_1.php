<?php
include 'backend/config.php';

// Fetch ads1 and ads2 from DB
$result = $conn->query("SELECT key_name, content FROM ads_section WHERE key_name IN ('ads1', 'ads2')");
$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}
?>
<section class="mt-5">
  <?php if (isset($_SESSION['user_id'])): ?>
    <!--EDIT BOTAN-->
    <div class="text-center mb-3 ad1" data-aos="fade-up" data-aos-duration="1000">
      <button type="button" class="btn btn-warning mt-3" onclick="toggleEditAll(this)" data-modal-target=".edit-ads-1">Edit</button>
    </div>
  <?php endif; ?>

  <!-- Display current image -->
  <div class="d-flex flex-column flex-xl-row justify-content-center align-items-center gap-3">
    <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads1'] ?? 'ads_no_1.png'); ?>" alt="Ad Image" class="img-fluid mb-2 current-cms-img" data-cms-key="ads1" style="max-width: 100%; height: auto;" data-aos="fade-up" data-aos-duration="1000">
    <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads2'] ?? 'ads_no_2.png'); ?>" alt="Ad Image" class="img-fluid mb-2 current-cms-img" data-cms-key="ads2" style="max-width: 100%; height: auto;" data-aos="fade-up" data-aos-duration="1000">
  </div>

</section>
<!-- Modal -->
<div class="modal fade edit-ads-1" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Edit Content</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
  <div class="modal-body">
      <div class="d-flex flex-column flex-xl-row justify-content-center align-items-center gap-3">
        <div class="image-upload">
          <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads1'] ?? 'ads_no_1.png'); ?>" alt="Ad Image" class="img-fluid mb-2 current-cms-img" data-cms-key="ads1" style="max-width: 100%; height: auto;">
          <div class="upload-box uploadBox">
              <input type="file" class="cms-image-input fileInput" data-cms-key="ads1" accept="image/*">
              <p>Click or drag a file here to upload</p>
          </div>
        </div>
        <div class="image-upload">
          <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads2'] ?? 'ads_no_2.png'); ?>" alt="Ad Image" class="img-fluid mb-2 current-cms-img" data-cms-key="ads2" style="max-width: 100%; height: auto;">
          <div class="upload-box uploadBox">
              <input type="file" class="cms-image-input fileInput" data-cms-key="ads2" accept="image/*">
              <p>Click or drag a file here to upload</p>
          </div>
        </div>
      </div>
  </div>
  </div>
</div>