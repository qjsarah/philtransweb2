<?php
include 'backend/config.php';

$keys = ['header2', 'paragraph2', 'paragraph2_1', 'phone2_img', 'intro_title_color','intro_desc_color'];
$placeholders = implode(',', array_fill(0, count($keys), '?'));

$sql = "SELECT key_name, content FROM intro WHERE key_name IN ($placeholders)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($keys)), ...$keys);
$stmt->execute();
$result = $stmt->get_result();

$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}
?>
<section class="text-white">
  <!-- Desktop Layout -->
  <div class="container py-5">
    <div class="row align-items-center justify-content-between intro-row" style="color:#000066">
      <!-- Left Column -->
      <div class="col-lg-7 text-start fs-5">
        <h3 class="fw-bold display-5" data-aos="fade-right" data-aos-duration="1000"  style="color: <?php echo htmlspecialchars($content['intro_title_color'] ?? '#FFFFFF'); ?>;"><?php echo htmlspecialchars($content['header2']  ?? 'Welcome to Philippines Transportation App System!'); ?></h3><br>

        <p data-aos="fade-right" data-aos-duration="1500" style="color: <?php echo htmlspecialchars($content['intro_desc_color'] ?? '#FFFFFF'); ?>;">
          <?php echo htmlspecialchars($content['paragraph2'] ?? "PTAS breaks the mold of traditional transportation apps. They're not just about getting you from point A to point B; they're shaking up the transportation industry with a people-centric approach. 
          PTAS goes beyond offering rides. 
          They empower drivers by increasing their earning potential and fostering positive changes in their lives. But the impact doesn't stop there. 
          PTAS is dedicated to creating a smoother and more enjoyable experience for passengers as well."); ?>
        </p><br>
        <p data-aos="fade-right" data-aos-duration="1700"  style="color: <?php echo htmlspecialchars($content['intro_desc_color'] ?? '#FFFFFF'); ?>;">
          <?php echo htmlspecialchars($content['paragraph2_1'] ?? "In essence, PTAS represents a paradigm shift in transportation, where the focus lies not only on the journey's endpoint but also on enhancing the journey itself.
          It's about fostering empowerment, enriching experiences, and prioritizing the well-being of both drivers and passengers in every aspect of their transportation needs."); ?>
        </p>
      </div>

      <!-- Right Column -->
      <div class="col-lg-4 mt-4 text-center" data-aos="fade-left" data-aos-duration="2000"> 

       <img src="../main/images/intro_section/<?php echo htmlspecialchars($content['phone2_img'] ?? 'intro_image.png'); ?>" 
     alt="Intro Image" class="img-fluid current-cms-img" data-cms-key="phone2_img"> 

      </div>
  </div>
  <?php if (isset($_SESSION['user_id'])): ?>
          <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center mb-5">
  <button type="button" 
          class="contact_button rounded text-dark w-100 w-sm-50 w-lg-25 px-3 py-2 mt-2 border-dark" 
          onclick="toggleEditAll(this)" 
          data-modal-target=".introContent">
    Edit Content
  </button>

  <button type="button" 
          class="contact_button rounded text-dark w-100 w-sm-50 w-lg-25 px-3 py-2 mt-2 border-dark" 
          onclick="toggleEditAll(this)" 
          data-modal-target=".edit-intro-image">
    Change Image
  </button>
</div>

        <?php endif; ?>
  </section>
  
<!-- Modal -->
<div class="modal fade introContent" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
          <div class="modal-header">
              <h3 class="modal-title fw-bold fs-4">Edit Introduction Section Content</h3>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
      <div class="modal-body">
        <hr>
          <form method="POST" action="backend/savecms.php" enctype="multipart/form-data" class="form">

          <div class="d-flex flex-column flex-md-row align-items-start gap-4">
          <!-- Color Pickers -->
            <div style="min-width: 200px; width: 100%; max-width: 200px;">

              <label for="intro_title_color" class="form-label fw-bold text-secondary">Title Font Color:</label>
              <input type="text" id="intro_title_hex" name="intro_title_color" class="form-control text-uppercase mb-2" maxlength="10" style="border-color: black;" value="<?php echo htmlspecialchars($content['intro_title_color'] ?? '#1a1a1a'); ?>">
              <input type="color" id="intro_title_color" class="form-control form-control-color mb-2" style="height: 40px; padding: 5px; border-color: black; width: 100%;" value="<?php echo htmlspecialchars($content['intro_title_color'] ?? '#1a1a1a'); ?>">

              <label for="intro_desc_color" class="form-label fw-bold text-secondary mt-3">Description Font Color:</label>
              <input type="text" id="intro_desc_hex" name="intro_desc_color" class="form-control text-uppercase mb-2" maxlength="10" style="border-color: black; width: 100%;" value="<?php echo htmlspecialchars($content['intro_desc_color'] ?? '#1a1a1a'); ?>">
              <input type="color" id="intro_desc_color" class="form-control form-control-color mb-2" style="height: 44px; padding: 5px; border-color: black; width: 100%;" value="<?php echo htmlspecialchars($content['intro_desc_color'] ?? '#1a1a1a'); ?>">
            </div>

            <!-- Text Areas -->
            <div class="flex-grow-1 w-100">
              <label for="header2" class="form-label fw-bold text-secondary">Introduction Title:</label>
              <textarea name="header2" class="form-control mb-3 border-dark" rows="3"><?php echo htmlspecialchars($content['header2'] ?? "Welcome to Philippine Transportation App System"); ?></textarea>

              <label for="paragraph2" class="form-label fw-bold text-secondary mt-2">Paragraph 1:</label>
              <textarea name="paragraph2" class="form-control mb-3  border-dark" rows="4"><?php echo htmlspecialchars($content['paragraph2'] ?? "PTAS breaks the mold of traditional transportation apps. They're not just about getting you from point A to point B; they're shaking up the transportation industry with a people-centric approach. PTAS goes beyond offering rides. They empower drivers by increasing their earning potential and fostering positive changes in their lives. But the impact doesn't stop there. PTAS is dedicated to creating a smoother and more enjoyable experience for passengers as well."); ?></textarea>

              <label for="paragraph2_1" class="form-label fw-bold text-secondary mt-2">Paragraph 2:</label>
              <textarea name="paragraph2_1" class="form-control mb-3  border-dark" rows="4"><?php echo htmlspecialchars($content['paragraph2_1'] ?? "In essence, PTAS represents a paradigm shift in transportation, where the focus lies not only on the journey's endpoint but also on enhancing the journey itself. It's about fostering empowerment, enriching experiences, and prioritizing the well-being of both drivers and passengers in every aspect of their transportation needs."); ?></textarea>
              </div>
            </div>
              <div class="text-center modal-footer">
                  <button type="button" class="contact_button px-5 py-2 rounded text-dark save-button w-100 w-md-auto border-dark">Save</button>
                  <button type="button" class="contact_button px-5 py-2 rounded text-dark w-100 w-md-auto border-dark" data-bs-dismiss="modal">Cancel</button>
              </div>
          </form>
      </div>
      </div>
  </div>
</div>

<div class="modal fade edit-intro-image" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
        <div class="modal-header">
            <h3 class="modal-title fs-4 fw-bold">Edit Content</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="all-form" method="POST" action="backend/savecms.php" enctype="multipart/form-data" class="text-center form">
            <img src="../main/images/intro_section/<?php echo htmlspecialchars($content['phone2_img'] ?? 'intro_image.png')?>" class="current-cms-img img-fluid w-25" data-cms-key="phone2_img" alt="">
            <div class="upload-box uploadBox">
              <input type="file" class="form-control mb-2 cms-image-input fileInput" data-cms-key="phone2_img" name="phone2_img" accept="image/*">
              <p>Click or drag a file here to upload</p>
            </div>
          </form>
        </div>
      </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Title and description color inputs
    const titleColorPicker = document.getElementById("intro_title_color");
    const titleHexInput    = document.getElementById("intro_title_hex");
    const descColorPicker  = document.getElementById("intro_desc_color");
    const descHexInput     = document.getElementById("intro_desc_hex");

    // Live preview target elements
    const titleElement = document.querySelector(".fw-bold.display-5");
    const descElements = document.querySelectorAll(".intro-row p"); // paragraph2 = descElements[0], paragraph2_1 = descElements[1]

    const form = document.querySelector(".introContent form");

    // Textarea inputs for live preview
    const headerInput     = form.querySelector("textarea[name='header2']");
    const paragraph2Input = form.querySelector("textarea[name='paragraph2']");
    const paragraph21Input = form.querySelector("textarea[name='paragraph2_1']");

    // Store original values from PHP
    const original = {
        titleColor: '<?php echo addslashes($content['intro_title_color'] ?? '#FFFFFF'); ?>',
        descColor: '<?php echo addslashes($content['intro_desc_color'] ?? '#FFFFFF'); ?>',
        titleText: '<?php echo addslashes($content['header2'] ?? "Welcome to Philippine Transportation App System"); ?>',
        paragraph2Text: '<?php echo addslashes($content['paragraph2'] ?? "PTAS breaks the mold..."); ?>',
        paragraph21Text: '<?php echo addslashes($content['paragraph2_1'] ?? "In essence, PTAS represents a paradigm shift..."); ?>'
    };

    /** ---------------------------
     *  COLOR PICKER LIVE PREVIEW
     * --------------------------*/
    titleColorPicker.addEventListener("input", function () {
        titleHexInput.value = this.value;
        if(titleElement) titleElement.style.color = this.value;
    });
    titleHexInput.addEventListener("input", function () {
        titleColorPicker.value = this.value;
        if(titleElement) titleElement.style.color = this.value;
    });

    descColorPicker.addEventListener("input", function () {
        descHexInput.value = this.value;
        descElements.forEach(el => el.style.color = this.value);
    });
    descHexInput.addEventListener("input", function () {
        descColorPicker.value = this.value;
        descElements.forEach(el => el.style.color = this.value);
    });

    /** ---------------------------
     *  TEXTAREA LIVE PREVIEW
     * --------------------------*/
    if(headerInput){
        headerInput.addEventListener("input", function () {
            if(titleElement) titleElement.textContent = this.value;
        });
    }
    if(paragraph2Input){
        paragraph2Input.addEventListener("input", function () {
            if(descElements[0]) descElements[0].textContent = this.value;
        });
    }
    if(paragraph21Input){
        paragraph21Input.addEventListener("input", function () {
            if(descElements[1]) descElements[1].textContent = this.value;
        });
    }

    /** ---------------------------
     *  RESET ON MODAL CLOSE
     * --------------------------*/
    const modal = document.querySelector(".introContent");
    if(modal){
        function resetPreview() {
            if(titleElement) {
                titleElement.style.color = original.titleColor;
                titleElement.textContent = original.titleText;
            }
            descElements.forEach(el => el.style.color = original.descColor);
            if(descElements[0]) descElements[0].textContent = original.paragraph2Text;
            if(descElements[1]) descElements[1].textContent = original.paragraph21Text;

            // Reset form values too
            if(form){
                headerInput.value     = original.titleText;
                paragraph2Input.value = original.paragraph2Text;
                paragraph21Input.value = original.paragraph21Text;
                titleHexInput.value   = original.titleColor;
                titleColorPicker.value = original.titleColor;
                descHexInput.value    = original.descColor;
                descColorPicker.value = original.descColor;
            }
        }

        modal.addEventListener('hidden.bs.modal', resetPreview);
    }
});
</script>

