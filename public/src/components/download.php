<?php
include 'backend/config.php'; 

$keys = ['header1', 'paragraph1', 'apple_dl', 'google_dl', 'phone_img' ,'download_bg_color','download_title_color','download_desc_color'];
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
<section class="download_section" 
         data-aos="fade-down" 
         data-aos-duration="500"
         style="background-color: <?php echo htmlspecialchars($content['download_bg_color'] ?? '#BF0D3D'); ?>;">

           <?php if (isset($_SESSION['user_id'])): ?>
    <div class="pt-3 d-flex gap-3 justify-content-center ">
       <button type="button" class="contact_button w-25 px-3 py-2 rounded text-white" data-bs-toggle="modal" data-bs-target=".editContentModal">Edit Contents</button>
    </div>
  <?php endif; ?>
<div class="text-center text-white py-2 w-75 mx-auto">
  <!-- Heading -->
  <h1 class="fw-bold py-3 fs-1 fs-md-2 fs-lg-1 download-title"
      data-aos="fade-down" 
      data-aos-duration="1000"
      style="color: <?php echo htmlspecialchars($content['download_title_color'] ?? '#FFFFFF'); ?>;">
      <?php echo htmlspecialchars($content['header1'] ?? 'DOWNLOAD OUR APP NOW!'); ?>
  </h1>

  <!-- Paragraph -->
  <p class="mx-auto py-3 fs-6 fs-md-5 w-100 w-md-75 w-lg-50 download-desc"
     data-aos="fade-down" 
     data-aos-duration="1500" 
     style="color: <?php echo htmlspecialchars($content['download_desc_color'] ?? '#FFFFFF'); ?>;">
     <?php echo htmlspecialchars($content['paragraph1'] ?? "Download the Philippine Trans App System today..."); ?>
  </p>
</div>

<!-- Download Buttons -->
<div class="download_app text-center mb-5 d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3">
  <img src="../../public/main/images/download_section/apple.png" alt="Apple Store" class="img-fluid" style="max-width: 180px;" data-aos="fade-right" data-aos-duration="1500">
  <img src="../../public/main/images/download_section/google.png" alt="Google Play" class="img-fluid" style="max-width: 180px;" data-aos="fade-left" data-aos-duration="1500">
</div>

<?php if (isset($_SESSION['user_id'])): ?>
    <div class="d-flex gap-3 pb-4 justify-content-center ">
      <button type="button" class="contact_button w-25  px-3 py-2 rounded text-white" data-bs-toggle="modal" data-bs-target=".edit-download-image">Change Image</button>
    </div>
<?php endif?>

  <div class="download_3_mobile position-relative pb-4" data-aos="fade-up" data-aos-duration="1500">

      <img src="../../public/main/images/download_section/<?php echo htmlspecialchars($content['phone_img'] ?? 'Download_imgs.png')?>" class="d-block mx-auto img-fluid w-50 current-cms-img" alt="Download Image" data-cms-key="phone_img">

    </div>
</section>

<!-- Edit Modal -->
<div class="modal fade editContentModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
      <div class="modal-header">
        <h3 class="modal-title">Edit Content</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="downloadForm" method="POST" action="backend/savecms.php">
          <!-- Background Color -->
          <label for="download_bg_color" class="form-label fw-bold text-secondary">Background Color:</label>
          <div class="d-flex flex-column flex-md-row align-items-center gap-3 mb-2">
            <input type="text" id="download_bg_hex" class="form-control text-uppercase mb-1 mb-md-0" maxlength="10" style="border-color: black; flex: 0 0 27%;" value="<?php echo htmlspecialchars($content['download_bg_color'] ?? '#1a1a1a'); ?>">
            <input type="color" class="form-control form-control-color w-100 w-md-auto" id="download_bg_color" name="download_bg_color" style="height: 38px; padding: 5px; border-color: black; flex: 1 1 auto;" value="<?php echo htmlspecialchars($content['download_bg_color'] ?? '#1a1a1a'); ?>">
          </div>

          <div class="d-flex flex-column flex-md-row align-items-start gap-4 mt-3">
            <!-- Color Pickers -->
            <div style="min-width: 200px; width: 100%; max-width: 200px;">
              <label for="download_title_color" class="form-label fw-bold text-secondary">Title Font Color:</label>
              <input type="text" id="download_title_hex" name="download_title_color" class="form-control text-uppercase mb-2" maxlength="10" style="border-color: black;" value="<?php echo htmlspecialchars($content['download_title_color'] ?? '#1a1a1a'); ?>">
              <input type="color" class="form-control form-control-color mb-2" id="download_title_color" style="height: 40px; padding: 5px; border-color: black; width: 100%;" value="<?php echo htmlspecialchars($content['download_title_color'] ?? '#1a1a1a'); ?>">

             <!-- Description Font Color -->
              <label for="download_desc_color" class="form-label fw-bold text-secondary mt-3">Description Font Color:</label>
              <input type="text" id="download_desc_hex" class="form-control text-uppercase mb-2" maxlength="10" style="border-color: black; width: 100%;" value="<?php echo htmlspecialchars($content['download_desc_color'] ?? '#1a1a1a'); ?>">
              <input type="color" class="form-control form-control-color mb-2" id="download_desc_color" name="download_desc_color" style="height: 44px; padding: 5px; border-color: black; width: 100%;" value="<?php echo htmlspecialchars($content['download_desc_color'] ?? '#1a1a1a'); ?>">

            </div>

            <div class="flex-grow-1 w-100">
              <label for="header1" class="form-label fw-bold text-secondary">Title:</label>
              <textarea name="header1" class="form-control mb-3" style="border-color: black;" rows="3"><?php echo htmlspecialchars($content['header1']??'DOWNLOAD OUR APP NOW!'); ?></textarea>

              <label for="paragraph1" class="form-label fw-bold text-secondary mt-2">Description:</label>
              <textarea name="paragraph1" class="form-control mb-3 border border-dark" rows="5"><?php echo htmlspecialchars($content['paragraph1']??"Download the Philippine Trans App System today..."); ?></textarea>
            </div>
          </div>

          <div class="text-center modal-footer">
            <button type="button" class="contact_button px-5 py-2 rounded text-dark save-button w-100 w-md-auto" style="border-color: black;">Save</button>
            <button type="button" class="contact_button px-5 py-2 rounded text-dark  w-100 w-md-auto" style="border-color: black;" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade edit-download-image" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
      <div class="modal-header">
        <h3 class="modal-title fs-4 fw-bold">Download Section Image</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-4">
        <hr>
        <form id="header1-form" method="POST" action="backend/savecms.php" class="text-center">
            <img src="../main/images/download_section/<?php echo htmlspecialchars($content['phone_img'] ?? 'Download_imgs.png')?>" alt="phone" class="img-fluid w-50 current-cms-img mx-auto" data-cms-key="phone_img">
            <div class="upload-box uploadBox">
              <input type="file" class="form-control cms-image-input fileInput" data-cms-key="phone_img" accept="image/*">
              <p>Click or drag a file here to upload</p>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- JS -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const bgColorPicker = document.getElementById("download_bg_color");
    const bgHexInput    = document.getElementById("download_bg_hex");
    const titleColorPicker = document.getElementById("download_title_color");
    const titleHexInput    = document.getElementById("download_title_hex");
    const descColorPicker = document.getElementById("download_desc_color");
    const descHexInput    = document.getElementById("download_desc_hex");

    const titleElement = document.querySelector(".download-title");
    const descElement  = document.querySelector(".download-desc");
    const sectionElement = document.querySelector("section.download_section");

    const form = document.getElementById("downloadForm");

    const original = {
      bgColor: '<?php echo addslashes($content['download_bg_color'] ?? '#BF0D3D'); ?>',
      titleColor: '<?php echo addslashes($content['download_title_color'] ?? '#FFFFFF'); ?>',
      descColor: '<?php echo addslashes($content['download_desc_color'] ?? '#FFFFFF'); ?>',
      titleText: '<?php echo addslashes($content['header1'] ?? 'DOWNLOAD OUR APP NOW!'); ?>',
      descText: '<?php echo addslashes($content['paragraph1'] ?? 'Download the Philippine Trans App System today...'); ?>',
    };

    // BG
    bgColorPicker.addEventListener("input", function () {
        bgHexInput.value = this.value;
        sectionElement.style.backgroundColor = this.value;
    });
    bgHexInput.addEventListener("input", function () {
        bgColorPicker.value = this.value;
        sectionElement.style.backgroundColor = this.value;
    });

    // Title
    titleColorPicker.addEventListener("input", function () {
        titleHexInput.value = this.value;
        titleElement.style.color = this.value;
    });
    titleHexInput.addEventListener("input", function () {
        titleColorPicker.value = this.value;
        titleElement.style.color = this.value;
    });

    // Description
    descColorPicker.addEventListener("input", function () {
        descHexInput.value = this.value;
        descElement.style.color = this.value;
    });
    descHexInput.addEventListener("input", function () {
        descColorPicker.value = this.value;
        descElement.style.color = this.value;
    });

    // Reset function
    function resetPreview() {
      bgColorPicker.value = bgHexInput.value = original.bgColor;
      titleColorPicker.value = titleHexInput.value = original.titleColor;
      descColorPicker.value = descHexInput.value = original.descColor;

      sectionElement.style.backgroundColor = original.bgColor;
      titleElement.style.color = original.titleColor;
      descElement.style.color = original.descColor;

      titleElement.textContent = original.titleText;
      descElement.textContent = original.descText;

      form.querySelector("[name='header1']").value = original.titleText;
      form.querySelector("[name='paragraph1']").value = original.descText;
    }

    const modal = document.querySelector(".editContentModal");
    modal.addEventListener('hidden.bs.modal', resetPreview);
});
</script>
