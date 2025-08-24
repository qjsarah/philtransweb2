<?php
include 'backend/config.php';

$keys = ['header3', 'paragraph3', 'paragraph3_1', 'tricycle_img', 'header3_1','aboutus_title_color','aboutus_sub_color', 'aboutus_desc_color'];
$placeholders = implode(',', array_fill(0, count($keys), '?'));
$sql = "SELECT key_name, content FROM aboutus WHERE key_name IN ($placeholders)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($keys)), ...$keys);
$stmt->execute();
$result = $stmt->get_result();

$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}
$titleColor = htmlspecialchars($content['aboutus_title_color'] ?? '#1a1a1a');
$subColor   = htmlspecialchars($content['aboutus_sub_color'] ?? '#1a1a1a');
$descColor  = htmlspecialchars($content['aboutus_desc_color'] ?? '#1a1a1a');
?>
<section class="container py-4 aboutus-section" style="color: #000066;">
  
  <!-- DISPLAY -->
  <h3 class="text-center fs-1 w-100 px-3 mx-auto py-3 about-title"
  data-aos="fade-down" data-aos-duration="1000"
  style="color: <?= $titleColor ?>;"><?php echo htmlspecialchars($content['header3']  ?? 'PTAS: REVOLUTIONIZING RIDES AND REDEFINING THE TRICYCLE INDUSTRY'); ?></h3>
  
  <div class="d-flex flex-column flex-lg-row align-items-center gap-4 px-3">

    <!-- Left Text -->
    <div class="col-12 col-lg-4">
        <p class="mt-3 mt-lg-5 about-desc" style="color: <?= $descColor ?>;" data-aos="fade-right" data-aos-duration="1500">
            <?php echo htmlspecialchars($content['paragraph3']  ?? 'In the ever-evolving landscape of transportation, PTAS emerges as more than just another app. It shatters the mold of traditional ride-hailing services, offering a revolutionary approach centered around the very people who keep the tricycle industry moving – the drivers.'); ?>
        </p>
    </div>

    <!-- Image -->
    <div class="col-12 col-lg-4 text-center">
        <img src="../../public/main/images/about_section/<?php echo htmlspecialchars($content['tricycle_img'] ?? 'desktop_trycicle.png')?>" alt="About Image" class="img-fluid mb-3 mt-5 current-cms-img" style="max-width: 100%;" data-aos="zoom-in-down" data-aos-duration="2000" data-cms-key="tricycle_img">
    </div>

    <!-- Right Text -->
    <div class="col-12 col-lg-4 text-lg-end text-center">
        <h4 class="fs-2 about-subtitle" data-aos="fade-right" style="color: <?= $subColor ?>;" data-aos-duration="2000">
            <?php echo htmlspecialchars($content['header3_1']  ?? 'ABOUT US'); ?>
        </h4>

        <p class="mt-3 mt-lg-5 about-desc" data-aos="fade-right" style="color: <?= $descColor ?>;" data-aos-duration="2000">
            <?php echo htmlspecialchars($content['paragraph3_1']  ?? "PTAS transcends the mere act of getting you from point A to point B; it's a catalyst for positive change, empowering drivers, enhancing passenger experiences."); ?>
        </p>
    </div> 
</section>
 <?php if (isset($_SESSION['user_id'])): ?> \
  <!-- EDIT BUTTONS -->
    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center mb-5 px-5">
      <button type="button" class="contact_button rounded text-dark w-100 w-sm-50 px-3 py-2 mt-2 border-dark" onclick="toggleEditAll(this)" data-modal-target=".aboutContent">Edit Content</button>
      <button type="button" class="contact_button rounded text-dark w-100 w-sm-50 px-3 py-2 mt-2 border-dark" onclick="toggleEditAll(this)" data-modal-target=".edit-about-image">Change Image</button>
    </div>
  <?php endif; ?>
<!-- Modal -->
<div class="modal fade aboutContent" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
        <div class="modal-header">
          <h3 class="modal-title fs-4 fw-bold">Edit About Us Section Content</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="form" method="POST" action="backend/savecms.php" id="aboutusForm">
          <hr>
          <div class="d-flex flex-column flex-md-row align-items-start gap-4 mt-3">
          <div style="min-width: 200px; width: 100%; max-width: 200px;">
                  <!-- Title Color -->
                  <label for="aboutus_title_color" class="form-label fw-bold text-secondary">Title Font Color:</label>
                  <input type="text" id="aboutus_title_hex" class="form-control text-uppercase mb-2" maxlength="7" style="border-color: black;" value="<?= $titleColor ?>">
                  <input type="color" id="aboutus_title_color" name="aboutus_title_color" class="form-control form-control-color mb-2" style="height: 40px; padding: 5px; border-color: black; width: 100%;" value="<?= $titleColor ?>">

                  <!-- Subtitle Color -->
                  <label for="aboutus_sub_color" class="form-label fw-bold text-secondary mt-2">Subtitle Font Color:</label>
                  <input type="text" id="aboutus_sub_hex" class="form-control text-uppercase mb-2" maxlength="7" style="border-color: black; width: 100%;" value="<?= $subColor ?>">
                  <input type="color" id="aboutus_sub_color" name="aboutus_sub_color" class="form-control form-control-color mb-2" style="height: 40px; padding: 5px; border-color: black; width: 100%;" value="<?= $subColor ?>">

                  <!-- Description Color -->
                  <label for="aboutus_desc_color" class="form-label fw-bold text-secondary mt-2">Description L & R Color:</label>
                  <input type="text" id="aboutus_desc_hex" class="form-control text-uppercase mb-2" maxlength="7" style="border-color: black; width: 100%;" value="<?= $descColor ?>">
                  <input type="color" id="aboutus_desc_color" name="aboutus_desc_color" class="form-control form-control-color mb-2" style="height: 44px; padding: 5px; border-color: black; width: 100%;" value="<?= $descColor ?>">
                </div>

            <!-- Editable Fields -->
             <div class="flex-grow-1 w-100">
               <label for="header3" class="form-label fw-bold text-secondary ">Title:</label>
              <textarea name="header3" class="form-control mb-3 border-dark" rows="3"><?php echo htmlspecialchars($content['header3'] ?? ""); ?></textarea>

               <label for="header3_1" class="form-label fw-bold text-secondary">SubTitle:</label>
              <textarea name="header3_1" class="form-control mb-3 border-dark" rows="3"><?php echo htmlspecialchars($content['header3_1'] ?? "ABOUT US"); ?></textarea>

              <label for="paragraph3" class="form-label fw-bold text-secondary">Description Left:</label>
              <textarea name="paragraph3" class="form-control mb-3 border-dark" rows="5"><?php echo htmlspecialchars($content['paragraph3'] ?? ""); ?></textarea>

              <label for="paragraph3_1" class="form-label fw-bold text-secondary">Description Right :</label>
              <textarea name="paragraph3_1" class="form-control mb-3 border-dark" rows="5"><?php echo htmlspecialchars($content['paragraph3_1'] ?? ""); ?></textarea>
            </div>
          </div> 
            <div class="text-center modal-footer">
              <button type="button" class="contact_button rounded text-dark w-100 px-3 py-2 mt-2 border-dark save-button">Save</button>                        
              <button type="button" class="contact_button rounded text-dark w-100 px-3 py-2 mt-2 border-dark" data-bs-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade edit-about-image" tabindex="-1">
     <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
          <div class="modal-header">
              <h3 class="modal-title fw-bold fs-4">Edit Content</h3>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="all-form" method="POST" action="backend/savecms.php" class="text-center">
              <img src="../main/images/about_section/<?php echo htmlspecialchars($content['tricycle_img'] ?? 'desktop_trycicle.png')?>" class="current-cms-img img-fluid w-50" data-cms-key="tricycle_img" alt="">
              <div class="upload-box uploadBox">
                <input type="file" class="cms-image-input fileInput" data-cms-key="tricycle_img" accept="image/*">
                <p>Click or drag a file here to upload</p>
              </div>
            </form>
          </div>
        </div>
    </div>
  </div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const titlePicker = document.getElementById("aboutus_title_color");
    const titleHex = document.getElementById("aboutus_title_hex");

    const subPicker = document.getElementById("aboutus_sub_color");
    const subHex = document.getElementById("aboutus_sub_hex");

    const descPicker = document.getElementById("aboutus_desc_color");
    const descHex = document.getElementById("aboutus_desc_hex");

    const titleEl = document.querySelector(".about-title");
    const subEl = document.querySelector(".about-subtitle");
    const descEls = document.querySelectorAll(".about-desc"); // <-- both descs

    const form = document.getElementById("aboutusForm");
    const modal = document.querySelector(".aboutContent");
    const cancelBtn = modal.querySelector("[data-bs-dismiss='modal']");

    // Store original values from PHP
    const original = {
        titleColor: "<?= $titleColor ?>",
        subColor: "<?= $subColor ?>",
        descColor: "<?= $descColor ?>",
        titleText: `<?= addslashes($content['header3'] ?? "ABOUT US") ?>`,
        subText: `<?= addslashes($content['paragraph3'] ?? "") ?>`,
        subTitleText: `<?= addslashes($content['header3_1'] ?? "ABOUT US") ?>`,
        descText: `<?= addslashes($content['paragraph3_1'] ?? "") ?>`
    };

    // Sync function for colors
    function syncColor(picker, hexInput, elements){
        picker.addEventListener("input", () => {
            hexInput.value = picker.value.toUpperCase();
            elements.forEach(el=>el.style.color=picker.value);
        });
        hexInput.addEventListener("input", () => {
            if(/^#([0-9A-F]{3}){1,2}$/i.test(hexInput.value)){
                picker.value = hexInput.value.toUpperCase();
                elements.forEach(el=>el.style.color=hexInput.value);
            }
        });
    }

    // Apply syncing
    syncColor(titlePicker, titleHex, [titleEl]);
    syncColor(subPicker, subHex, [subEl]);
    syncColor(descPicker, descHex, descEls);

    // Live sync for textareas
    /*
    form.header3.addEventListener("input", () => {
        titleEl.textContent = form.header3.value;
    });
    form.paragraph3.addEventListener("input", () => {
        if(descEls[0]) descEls[0].textContent = form.paragraph3.value;
    });
    form.header3_1.addEventListener("input", () => {
        subEl.textContent = form.header3_1.value;
    });
    form.paragraph3_1.addEventListener("input", () => {
        if(descEls[1]) descEls[1].textContent = form.paragraph3_1.value;
    });*/

    // Reset function when modal is closed/cancelled
    function resetPreview() {
        titlePicker.value = original.titleColor;
        titleHex.value = original.titleColor;
        subPicker.value = original.subColor;
        subHex.value = original.subColor;
        descPicker.value = original.descColor;
        descHex.value = original.descColor;

        // Reset live preview
        titleEl.style.color = original.titleColor;
        subEl.style.color = original.subColor;
        descEls.forEach(el => el.style.color = original.descColor);

        // Reset text
        titleEl.textContent = original.titleText;
        subEl.textContent = original.subTitleText;
        if(descEls[0]) descEls[0].textContent = original.subText;
        if(descEls[1]) descEls[1].textContent = original.descText;

        // Reset form textareas
        form.header3.value = original.titleText;
        form.paragraph3.value = original.subText;
        form.header3_1.value = original.subTitleText;
        form.paragraph3_1.value = original.descText;
    }

    cancelBtn.addEventListener("click", resetPreview);
    modal.addEventListener('hidden.bs.modal', resetPreview);
});
</script>
