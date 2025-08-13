<?php
include 'backend/config.php';

// Fetch ads3 and ads4 from DB
$result = $conn->query("SELECT key_name, content FROM ads_section WHERE key_name IN ('ads3', 'ads4')");
$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}
?>
<section class="mt-5">
    <?php if (isset($_SESSION['user_id'])): ?>
    <!-- Display current image -->
    <div class="d-flex flex-column flex-xl-row justify-content-center align-items-center gap-3">
        <div>
        <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads3'] ?? 'ads_no_3.png'); ?>" alt="Ad Image" class="img-fluid mb-2 current-cms-img" data-cms-key="ads3" style="max-width: 100%; height: auto;" data-aos="fade-up" data-aos-duration="1000">
      </div>
      <div>
        <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads4'] ?? 'ads_no_4.png'); ?>" alt="Ad Image" class="img-fluid mb-2 current-cms-img" data-cms-key="ads4" style="max-width: 100%; height: auto;" data-aos="fade-up" data-aos-duration="1000">
      </div>
        <!-- <img src="../../public/main/images/ads_section/ads_no_3.png" alt="Adkoto image" class="img-fluid" style="max-width: 100%;" data-aos="fade-up" data-aos-duration="1000">
        <img src="../../public/main/images/ads_section/ads_no_4.png" alt="Adkoto image" class="img-fluid" style="max-width: 100%;" data-aos="fade-up" data-aos-duration="1000"> -->
    </div>

    <!--EDIT BOTAN-->
    <div class="text-center mb-3 ad1" data-aos="fade-up" data-aos-duration="1000">
      <button type="button" class="btn btn-warning mt-3" onclick="toggleEditAll(this)" data-modal-target=".edit-ads-3">Edit</button>
    </div>

    <!-- Modal -->
    <div class="modal fade edit-ads-3" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h3 class="modal-title">Edit Content</h3>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <div class="modal-body">
          <?php if (isset($_SESSION['user_id'])): ?>
            <div class="d-flex flex-column flex-xl-row justify-content-center align-items-center gap-3">
              <div>
                <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads3'] ?? 'ads_no_3.png'); ?>" alt="Ad Image" class="img-fluid mb-2 current-cms-img" data-cms-key="ads3" style="max-width: 100%; height: auto;">
                <div class="upload-box uploadBox">
                    <input type="file" class="form-control mb-2 cms-image-input fileInput" data-cms-key="ads3" accept="image/*">
                    <p>Click or drag a file here to upload</p>
                </div>
              </div>
              <div>
                <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads4'] ?? 'ads_no_4.png'); ?>" alt="Ad Image" class="img-fluid mb-2 current-cms-img" data-cms-key="ads4" style="max-width: 100%; height: auto;">
                <div class="upload-box uploadBox">
                    <input type="file" class="form-control mb-2 cms-image-input fileInput" data-cms-key="ads4" accept="image/*">
                    <p>Click or drag a file here to upload</p>
                </div>
              </div>
            </div>
          <?php endif; ?>
          <div id="edit-buttons" class="text-center modal-footer">
            <button type="button" class="btn btn-secondary mb-2 ms-2" data-bs-dismiss="modal">Cancel</button>
          </div>
        </div>
          </div>
      </div>
  </div>

  <!-- Display -->
   <?php else: ?>
  <div class="ad1 d-flex flex-column flex-xl-row justify-content-center align-items-center gap-3">
    <div>
      <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads3'] ?? 'ads_no_3.png'); ?>" alt="Ad Image" class="img-fluid mb-2 current-cms-img" data-cms-key="ads3" style="max-width: 100%; height: auto;" data-aos="fade-up" data-aos-duration="1000">
    </div>
    <div>
      <img src="../main/images/ads_section/<?php echo htmlspecialchars($content['ads4'] ?? 'ads_no_4.png'); ?>" alt="Ad Image" class="img-fluid mb-2 current-cms-img" data-cms-key="ads4" style="max-width: 100%; height: auto;" data-aos="fade-up" data-aos-duration="1000">
    </div>
  </div>
<?php endif; ?>
</section>

<!-- <section class="py-4">
    <div class="d-flex flex-column flex-xl-row justify-content-around gap-3">
        <img src="../../public/main/images/ads_section/ads_no_3.png" class="img-fluid" alt="Adkoto image" style="max-width: 100%;" data-aos="fade-right" 
                 data-aos-duration="1500">
        <img src="../../public/main/images/ads_section/ads_no_4.png" class="img-fluid" alt="Adkoto image" style="max-width: 100%;" data-aos="fade-left" 
                 data-aos-duration="1500">
    </div>
</section> -->
