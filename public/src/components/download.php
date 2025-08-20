<?php
include 'backend/config.php'; 

$keys = ['header1', 'paragraph1', 'apple_dl', 'google_dl', 'phone_img'];
$placeholders = implode(',', array_fill(0, count($keys), '?'));

$sql = "SELECT key_name, content FROM download WHERE key_name IN ($placeholders)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($keys)), ...$keys);
$stmt->execute();
$result = $stmt->get_result();


$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}
?>
<section class="download_section pb-5 mb-5" data-aos="fade-down" data-aos-duration="500">
  <?php if (isset($_SESSION['user_id'])): ?>
    <div class="pt-3 d-flex gap-3 justify-content-center ">
       <button type="button" class="contact_button w-auto px-3 py-2 rounded text-white" onclick="toggleEditAll(this)" data-modal-target=".editContentModal">Edit Contents</button>
       
    </div>
  <?php endif; ?>
  <div class="text-center text-white py-2">
    <h1 class="fs-1 py-3 fw-bold " data-aos="fade-down" data-aos-duration="1000"><?php echo htmlspecialchars($content['header1']  ?? 'DOWNLOAD OUR APP NOW!'); ?></h1>
    <p class="w-75 w-md-75 w-lg-50 mx-auto fs-4 py-3" data-aos="fade-down" data-aos-duration="1500">
      <?php echo htmlspecialchars($content['paragraph1'] ?? "Download the Philippine Trans App System today and experience transportation like never before. Whether you're traveling for business or pleasure, our app makes getting around the Philippines easier, safer, and more convenient than ever before."); ?>
    </p>
  </div>
    <!-- Download Buttons -->
     <div class="text-center mb-5 d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3">
  <img src="../../public/main/images/download_section/apple.png" 
       alt="Apple Store" 
       class="img-fluid" 
       style="max-width: 180px;" 
       data-aos="fade-right" data-aos-duration="1500">

  <img src="../../public/main/images/download_section/google.png" 
       alt="Google Play" 
       class="img-fluid" 
       style="max-width: 180px;" 
       data-aos="fade-left" data-aos-duration="1500">
</div>

<?php if (isset($_SESSION['user_id'])): ?>
    <div class="d-flex gap-3 pb-4 justify-content-center ">
      <button type="button" class="contact_button w-auto px-3 py-2 rounded text-white" onclick="toggleEditAll(this)" data-modal-target=".edit-download-image">Change Image</button>
    </div>
<?php endif?>
    <div class="download_3_mobile position-relative pb-4" data-aos="fade-up" data-aos-duration="1500">
      <img src="../../public/main/images/download_section/<?php echo htmlspecialchars($content['phone_img'] ?? 'Download_imgs.png')?>" class="d-block mx-auto img-fluid w-50 current-cms-img" alt="Download Image" data-cms-key="phone_img">
    </div>
</section>
<!-- Edit Modal -->
<div class="modal fade editContentModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Edit Content</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="header1-form" method="POST" action="backend/savecms.php">
          <textarea name="header1" class="form-control mb-3" rows="2"><?php echo htmlspecialchars($content['header1']??'DOWNLOAD OUR APP NOW!'); ?></textarea>
          <textarea name="paragraph1" class="form-control mb-3" rows="5"><?php echo htmlspecialchars($content['paragraph1']??"Download the Philippine Trans App System today and experience transportation like never before. Whether you're traveling for business or pleasure, our app makes getting around the Philippines easier, safer, and more convenient than ever before. "); ?></textarea>
          <div class="text-center modal-footer">
            <button type="button" form="header1-form" class="btn btn-success mb-2 save-button">Save</button>
            <button type="button" class="btn btn-secondary mb-2 ms-2" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade edit-download-image" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Edit Content</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="header1-form" method="POST" action="backend/savecms.php" class="text-center">
            <img src="../main/images/download_section/<?php echo htmlspecialchars($content['phone_img'] ?? 'Download_imgs.png')?>" alt="phone" class="img-fluid w-50 current-cms-img mx-auto" data-cms-key="phone_img">
            <div class="upload-box uploadBox">
              <input type="file" class="cms-image-input fileInput" data-cms-key="phone_img" accept="image/*">
              <p>Click or drag a file here to upload</p>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Viewport -->
<style>

</style>