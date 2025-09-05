<?php
include 'backend/config.php'; 

$keys = ['contact_title', 'email', 'number', 'location', 'phone4_img', 'location_img', 'contact_img', 'web_img', 'contact_bg_color', 'contact_title_color', 'contact_font_color'];
$placeholders = implode(',', array_fill(0, count($keys), '?'));

$sql = "SELECT key_name, content FROM contact WHERE key_name IN ($placeholders)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($keys)), ...$keys);
$stmt->execute();
$result = $stmt->get_result();

$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}
?>

<style>
  .icon-circle:hover {
  box-shadow: 5px 5px  <?php echo htmlspecialchars($content['contact_bg_color'] ?? '#BF0D3D'); ?>;";
  transition: 0.3s;
  border: 1px solid white;
}
</style>
<section class="contact " style="background-color: <?php echo htmlspecialchars($content['contact_bg_color'] ?? '#BF0D3D'); ?>;">
  <?php if (isset($_SESSION['user_id'])): ?>
    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center pt-5 px-5">
      <button type="button" class="btn contact_button px-5 py-2 rounded text-white w-100 w-sm-50 border-white" onclick="toggleEditAll(this)" data-modal-target=".contactContent">Edit Content</button>
      <button type="button" class="btn contact_button px-5 py-2 rounded text-white w-100 w-sm-50  border-white" onclick="toggleEditAll(this)" data-modal-target=".edit-contact-image">Change Image</button>
    </div>
  <?php endif; ?>

  <div class="container py-5">
    <div class="row align-items-center g-4">
      <!-- Form Column -->
      <div class="col-lg-6">
        <h5 class="display-5 fw-bold" data-aos="fade-right" style="color: <?php echo htmlspecialchars($content['contact_title_color'] ?? '#FFFFFF'); ?>;" data-aos-duration="500"><?php echo htmlspecialchars($content['contact_title'] ?? "Get in Touch."); ?></h5>

        <form class="mt-4" method="POST" action="backend/save_message.php">
          <!-- Name Field -->
          <div class="mb-3" data-aos="fade-right" data-aos-duration="1000">
            <input type="text" class="form-control" id="inputName" name="name" placeholder="Enter your name" required>
          </div>

          <!-- Email Field -->
          <div class="mb-3" data-aos="fade-right" data-aos-duration="1000">
            <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Enter your email" required>
          </div>

          <!-- Message Field -->
          <div class="mb-4" data-aos="fade-right" data-aos-duration="1000">
            <textarea class="form-control" id="inputMessage" name="message" rows="7" placeholder="Type your message here..." required></textarea>
          </div>

          <!-- Submit Button -->
          <div class="text-end">
            <button type="submit" class="contact_button px-3 py-2 rounded text-white">
              Send Message
            </button>
          </div>
        </form>

      </div>

      <!-- Image Column -->
      <div class="col-lg-6 text-center position-relative" data-aos="fade-up" data-aos-duration="2500">
        <div class="position-relative d-inline-block w-100">
          <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['phone4_img'] ?? 'contact_img.png')?>" class="img-fluid rounded current-cms-img" alt="Phone Image" data-cms-key="phone4_img">
          
          <!-- Icon 1: Message -->
          <div class="position-absolute d-flex align-items-center gap-3" style="top: 20%; left: 12%;" data-aos="fade-up" data-aos-duration="500">
            <div class="icon-circle" style="background-color: <?php echo htmlspecialchars($content['contact_bg_color'] ?? '#BF0D3D'); ?>;">
              <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['contact_img'] ?? 'message_imgs.png')?>" class="icon-img current-cms-img" alt="Mail Icon" data-cms-key="contact_img">
            </div>
            <div class="contact_nav d-flex flex-column text-start small ">
              <a href=""><?php echo htmlspecialchars($content['email'] ?? "info@philtransinc.com"); ?></a>
              <a href=""><?php echo htmlspecialchars($content['number'] ?? "+63 917 501 0018"); ?></a>
            </div>
          </div>

          <!-- Icon 2: Website -->
          <div class="position-absolute d-flex align-items-center gap-3 mb-4" style="top: 38%; left: 12%;" data-aos="fade-up" data-aos-duration="1000">
            <div class="icon-circle" style="background-color: <?php echo htmlspecialchars($content['contact_bg_color'] ?? '#BF0D3D'); ?>;">
              <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['web_img'] ?? 'web.png')?>" class="icon-img current-cms-img" alt="Web Icon" data-cms-key="web_img">
            </div>
            <div class="contact_nav d-flex flex-column text-start small ">
              <a href="#about">About us</a>
              <a href="">Copyright</a>
              <a href="">Privacy Policy</a>
              <a href="">Terms and Condition</a>
              <a href="">FAQs</a>
            </div>
          </div>

          <!-- Icon 3: Location -->
          <div class="position-absolute d-flex align-items-center gap-3" style="top: 62%; left: 12%;" data-aos="fade-up" data-aos-duration="2000">
            <div class="icon-circle" style="background-color: <?php echo htmlspecialchars($content['contact_bg_color'] ?? '#BF0D3D'); ?>;">
              <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['location_img'] ?? 'location.png')?>" class="icon-img w-75 current-cms-img" alt="Location Icon" data-cms-key="location_img">
            </div>
            <div class="contact_nav text-start small d-flex align-items-center">
              <p class="mb-0 w-75">
                <?php echo htmlspecialchars($content['location'] ?? "D-3 2F Plaza Victoria, Santo Rosario St., Sto Domingo, Angeles City 2009 Pampanga Philippines"); ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade contactContent" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
      <div class="modal-header">
        <h3 class="modal-title fw-bold fs-4">Edit Contact Content</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="contact-content-form" method="POST" action="backend/savecms.php">
          <hr>
          <!-- Background Color -->
          <label for="contact_bg_color" class="form-label fw-bold text-secondary">Background Color:</label>
          <div class="d-flex flex-column flex-md-row align-items-center gap-3">
            <input type="text" id="contact_bg_hex" name="contact_bg_color" class="form-control text-uppercase mb-1 mb-md-0" maxlength="10" style="border-color: black; flex: 0 0 27%;" value="<?php echo htmlspecialchars($content['contact_bg_color'] ?? '#1a1a1a'); ?>">
            <input type="color" class="form-control form-control-color w-100 w-md-auto" id="contact_bg_picker" style="height: 36px; padding: 5px; border-color: black; flex: 1 1 auto;" value="<?php echo htmlspecialchars($content['contact_bg_color'] ?? '#1a1a1a'); ?>">
          </div>

          <div class="d-flex flex-column flex-md-row align-items-start gap-4 mt-3">
            <div style="min-width: 200px; width: 100%; max-width: 200px;">
              <!-- Title Color -->
              <label class="form-label fw-bold text-secondary">Title Color:</label>
              <input type="text" id="contact_title_hex" name="contact_title_color" class="form-control text-uppercase mb-2" maxlength="10" style="border-color: black;" value="<?php echo htmlspecialchars($content['contact_title_color'] ?? '#1a1a1a'); ?>">
              <input type="color" id="contact_title_picker" class="form-control form-control-color mb-2" style="height: 40px; padding: 5px; border-color: black; width: 100%;" value="<?php echo htmlspecialchars($content['contact_title_color'] ?? '#FFFFFF'); ?>">

              <!-- Font Color -->
              <label class="form-label fw-bold text-secondary mt-3">Font Color:</label>
              <input type="text" id="contact_font_hex" name="contact_font_color" class="form-control text-uppercase mb-2" maxlength="10" style="border-color: black;" value="<?php echo htmlspecialchars($content['contact_font_color'] ?? '#1a1a1a'); ?>">
              <input type="color" id="contact_font_picker" class="form-control form-control-color mb-2" style="height: 38px; padding: 5px; border-color: black; width: 100%;" value="<?php echo htmlspecialchars($content['contact_font_color'] ?? '#FFFFFF'); ?>">
            </div>

            <!-- Contact Title / Other Fields -->
            <div class="flex-grow-1 w-100">
              <label class="form-label fw-bold text-secondary ">Contact Title:</label>
              <textarea name="contact_title" class="form-control border-dark mb-3" rows="3"><?php echo htmlspecialchars($content['contact_title'] ?? 'Get in Touch.'); ?></textarea>

              <label class="form-label fw-bold text-secondary pt-2">Email:</label>
              <input type="email" name="email" class="form-control  border-dark" value="<?php echo htmlspecialchars($content['email'] ?? 'info@philtransinc.com'); ?>">

              <label class="form-label fw-bold text-secondary pt-2 mt-3">Phone Number:</label>
              <input type="text" name="number" class="form-control mb-3 border-dark" value="<?php echo htmlspecialchars($content['number'] ?? '+63 917 501 0018'); ?>">

              <label class="form-label fw-bold text-secondary pt-2">Location:</label>
              <textarea name="location" class="form-control mb-3 border-dark" rows="3"><?php echo htmlspecialchars($content['location'] ?? 'Your location address here...'); ?></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" form="contact-content-form" class="btn contact_button px-5 py-2 rounded text-dark border-dark save-button w-100 w-md-auto">Save</button>
            <button type="button" class="btn contact_button px-5 py-2 rounded text-dark border-dark w-100 w-md-auto" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Image Edit Modal -->
<div class="modal fade edit-contact-image" tabindex="-1">
 <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
      <div class="modal-header">
        <h3 class="modal-title fw-bold fs-4">Edit Contact Images</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="contact-image-form" method="POST" action="backend/savecms.php" enctype="multipart/form-data">
          <div class="row g-4">
            <!-- Phone Image -->
            <div class="col-md-4 text-center">
              <label class="fw-bold mb-2">Phone Image</label>

              <div class="text-center" style="height: 150px; display: flex; justify-content: center; align-items: center; margin-bottom: 1rem;">

                <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['phone4_img'] ?? 'contact_img.png')?>" class="img-fluid w-50 mb-1 current-cms-img" alt="Phone Image" data-cms-key="phone4_img">
              </div>

              <div class="upload-box uploadBox">
                <input type="file" class="fileInput cms-image-input" data-cms-key="phone4_img" name="phone4_img" accept="image/*">
                <p>Click or drag a file here to upload</p>
              </div>
            </div>

            <!-- Contact Icon -->
            <div class="col-md-4 text-center">
                <label class="fw-bold mb-2">Contact Icon</label>
                <div class="text-center" style="height: 150px; display: flex; justify-content: center; align-items: center; margin-bottom: 1rem;">
                <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['contact_img'] ?? 'message_imgs.png')?>" class="img-fluid w-25 mb-3">
              </div>

              <div class="upload-box uploadBox">
                <input type="file" class="fileInput cms-image-input" data-cms-key="contact_img" name="contact_img" accept="image/*">
                <p>Click or drag a file here to upload</p>
              </div>
            </div>

            <!-- Web Icon -->
            <div class="col-md-4 text-center">
              <label class="fw-bold mb-2">Web Icon</label>
              <div class="text-center" style="height: 150px; display: flex; justify-content: center; align-items: center; margin-bottom: 1rem;">

                <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['web_img'] ?? 'web.png')?>" class="img-fluid w-25 mb-3">
              </div>
              <div class="upload-box uploadBox">
                <input type="file" class="fileInput cms-image-input" data-cms-key="web_img" name="web_img" accept="image/*">
                <p>Click or drag a file here to upload</p>
              </div>
            </div>

            <!-- Location Icon -->
            <div class="col-md-4 text-center">
              <label class="fw-bold mb-2">Location Icon</label>
              <div class="text-center" style="height: 150px; display: flex; justify-content: center; align-items: center; margin-bottom: 1rem;">

                <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['location_img'] ?? 'location.png')?>" class="img-fluid w-25 mb-3">
              </div>
              <div class="upload-box uploadBox">
                <input type="file" class="fileInput cms-image-input" data-cms-key="location_img" name="location_img" accept="image/*">
                <p>Click or drag a file here to upload</p>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
// === Sync hex + color pickers ===
function syncColorInputs(hexId, pickerId) {
  const hexInput = document.getElementById(hexId);
  const picker = document.getElementById(pickerId);
  if (!hexInput || !picker) return;

  hexInput.addEventListener("input", () => {
    let val = hexInput.value.trim();
    if (!val.startsWith("#")) val = "#" + val;
    if (/^#([0-9A-Fa-f]{3})$/.test(val)) {
      val = "#" + val[1]+val[1]+val[2]+val[2]+val[3]+val[3];
    }
    if (/^#([0-9A-Fa-f]{6})$/.test(val)) {
      picker.value = val.toUpperCase();
      hexInput.value = val.toUpperCase();
      picker.dispatchEvent(new Event("input"));
    }
  });
  picker.addEventListener("input", () => {
    hexInput.value = picker.value.toUpperCase();
  });
}
syncColorInputs("contact_bg_hex", "contact_bg_picker");
syncColorInputs("contact_title_hex", "contact_title_picker");
syncColorInputs("contact_font_hex", "contact_font_picker");

document.addEventListener("DOMContentLoaded", function() {
  const form = document.getElementById("contact-content-form");
  const contactSection = document.querySelector(".contact");
  const titleEl = contactSection.querySelector("h5");

  // all text-containing elements
  const textEls = contactSection.querySelectorAll(
    ".contact_nav a, .contact_nav p, .contact_nav h5, .contact_nav span, .contact_nav li, form label, form input, form textarea, form button, .contact_button"
  );

  const contactModal = document.querySelector(".contactContent");
  if (contactModal && form) {
    contactModal.addEventListener("hidden.bs.modal", function () {
      form.reset();
      const bgHex = document.getElementById("contact_bg_hex");
      const titleHex = document.getElementById("contact_title_hex");
      const fontHex = document.getElementById("contact_font_hex");

      if (bgHex) contactSection.style.backgroundColor = bgHex.value; 
      if (titleHex && titleEl) titleEl.style.color = titleHex.value; 
      if (fontHex) {
        textEls.forEach(el => { el.style.color = fontHex.value; });
      }
    });
  }

  // live preview
  const bgPicker = document.getElementById("contact_bg_picker");
  const titlePicker = document.getElementById("contact_title_picker");
  const fontPicker = document.getElementById("contact_font_picker");

  if (bgPicker) {
    bgPicker.addEventListener("input", () => {
      contactSection.style.backgroundColor = bgPicker.value;
    });
  }
  if (titlePicker && titleEl) {
    titlePicker.addEventListener("input", () => {
      titleEl.style.color = titlePicker.value;
    });
  }
  if (fontPicker) {
    fontPicker.addEventListener("input", () => {
      textEls.forEach(el => { el.style.color = fontPicker.value; });
    });
  }
});
</script>
