<?php
include 'backend/config.php';

$keys = ['mission_img', 'vision_img', 'mission_con', 'vision_con', 'phone3_img', 'mvision_bg_color','mission_font_color', 'vision_font_color'];
$placeholders = implode(',', array_fill(0, count($keys), '?'));
$sql = "SELECT key_name, content FROM missionvision WHERE key_name IN ($placeholders)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($keys)), ...$keys);
$stmt->execute();
$result = $stmt->get_result();

$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}
?>
<section id="mv-view" class="py-5" style="background-color: <?php echo htmlspecialchars($content['mvision_bg_color'] ?? '#1a1a1a'); ?>">
  <div class="container">
    <div class="row  text-center text-lg-start">
      <!-- Mission -->
      <div class="col-12 col-lg-4 mb-4 mb-lg-0 d-flex flex-column justify-content-start text-start mission ">
        <img src="../../public/main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['mission_img'] ?? 'mission2.png')?>"
             alt="Mission Image"
             class="img-fluid current-cms-img mb-3"
             data-aos="fade-left" data-aos-duration="1000" data-cms-key="mission_img">

        <p class="fs-5" data-aos="fade-left" data-aos-duration="1500" style="color: <?php echo htmlspecialchars($content['mission_font_color'] ?? '#1a1a1a'); ?>">
          <?php echo htmlspecialchars($content['mission_con'] ?? "Our mission is to empower every tricycle driver in the Philippines..."); ?>
        </p>
      </div>

      <!-- Middle Image -->
      <div class="col-12 col-lg-4 mb-4 mb-lg-0 d-flex justify-content-center">
        <img src="../../public/main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['phone3_img'] ?? 'about_image.png')?>"
             alt="Middle Image"
             class="img-fluid"
             style="max-width:80%; height:auto;"
             data-aos="fade-up" data-aos-duration="500">
      </div>

      <!-- Vision -->
      <div class="col-12 col-lg-4 d-flex flex-column justify-content-end text-end vision">
        <img src="../../public/main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['vision_img'] ?? 'vision2.png')?>"
             alt="Vision Image"
             class="img-fluid current-cms-image mb-3"
             data-aos="fade-right" data-aos-duration="1000" data-cms-key="vision_img">
        <p class="fs-5 text-lg-end" data-aos="fade-right" data-aos-duration="1500" style="color: <?php echo htmlspecialchars($content['vision_font_color'] ?? '#1a1a1a'); ?>">
          <?php echo htmlspecialchars($content['vision_con'] ?? "In a future powered by our app, tricycle rides become effortless..."); ?>
        </p>
      </div>
    </div>
  </div>

    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="justify-content-center mb-3 d-flex gap-3 mt-4">
      <button type="button" class="contact_button px-5 py-2 rounded text-white w-25 w-md-auto" onclick="toggleEditAll(this)" data-modal-target=".mvisionContent">Edit Contents</button>
      <button type="button" class="contact_button px-5 py-2 rounded text-white w-25 w-md-auto" onclick="toggleEditAll(this)" data-modal-target=".edit-mv-images">Change Images</button>
    </div>
  <?php endif; ?>

</section>

<!-- Modal -->
<div class="modal fade mvisionContent" tabindex="-1">
   <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
      <div class="modal-header">
        <h3 class="modal-title fs-4 fw-bold">Edit Mission & Vision Content</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <hr>
        <form id="mvision-form" method="POST" action="backend/savecms.php">

          <!-- Background color -->
          <label for="services_bg_color" class="form-label fw-bold text-secondary">Background Color:</label>
            <div class="d-flex flex-column flex-md-row align-items-center gap-3 mb-2">
                <input type="text"
                    id="mvision_bg_color_hex"
                    class="form-control text-uppercase mb-1 mb-md-0"
                    maxlength="10"
                    style="border-color: black; flex: 0 0 27%;"
                    value="<?php echo htmlspecialchars($content['mvision_bg_color'] ?? '#1a1a1a'); ?>">
                <input type="color"
                    class="form-control form-control-color w-100 w-md-auto"
                    id="mvision_bg_color"
                    name="mvision_bg_color"
                    style="height: 38px; padding: 5px; border-color: black; flex: 1 1 auto;"
                    value="<?php echo htmlspecialchars($content['mvision_bg_color'] ?? '#1a1a1a'); ?>">
            </div>

          <div class="d-flex flex-column flex-md-row align-items-start gap-3 mt-3">

          
            <!-- Color Pickers Column -->
            <div style="min-width: 160px; width: 100%; max-width: 210px;">
              <!-- Mission Content Color -->
              <label class="form-label fw-bold text-secondary">Mission Content Font Color:</label>
              <input type="text" id="mission_font_hex" name="mission_font_color" class="form-control text-uppercase mb-2" maxlength="7" style="border-color: black;" value="<?= htmlspecialchars($content['mission_font_color'] ?? '#1a1a1a'); ?>">
              <input type="color" id="mission_font_color" class="form-control form-control-color mb-3" style="height: 64px; border-color: black; width: 100%;" value="<?= htmlspecialchars($content['mission_font_color'] ?? '#1a1a1a'); ?>">

              <!-- Vision Content Color -->
              <label class="form-label fw-bold text-secondary">Vision Content Font Color:</label>
              <input type="text" id="vision_font_hex" name="vision_font_color" class="form-control text-uppercase mb-2" maxlength="7" style="border-color: black;" value="<?= htmlspecialchars($content['vision_font_color'] ?? '#1a1a1a'); ?>">
              <input type="color" id="vision_font_color" class="form-control form-control-color mb-2" style="height: 64px; border-color: black; width: 100%;" value="<?= htmlspecialchars($content['vision_font_color'] ?? '#1a1a1a'); ?>">
            </div>

              <div class="flex-grow-1 w-100">
                <label class="form-label fw-bold text-secondary">Mission Content:</label>
                <textarea name="mission_con" id="mission_con"  class="form-control mb-3 border-dark" rows="4"><?php echo htmlspecialchars($content['mission_con'] ?? ""); ?></textarea>

                <label class="form-label fw-bold text-secondary">Vision Content:</label>
                <textarea name="vision_con" id="vision_con" class="form-control mb-3 border border-dark" rows="4"><?php echo htmlspecialchars($content['vision_con'] ?? ""); ?></textarea>
              </div>

          </div>

          <div id="edit-buttons" class="text-center modal-footer">
            <button type="button" form="mvision-form" class="save-button contact_button rounded text-dark w-100 px-3 py-2 mt-2 border-dark ">Save</button>
            <button type="button" class="contact_button rounded text-dark w-100 px-3 py-2 mt-2 border-dark" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>

  <div class="modal fade edit-mv-images" tabindex="-1">
   <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
      <div class="modal-header">
        <h3 class="modal-title fw-bold fs-4">Edit Content</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <hr>
        <form id="mvision-form" method="POST" action="backend/savecms.php" class="text-center">
        <div class="d-flex flex-column flex-xl-row justify-content-center align-items-center gap-5">

        <div class="">
            <label class="form-label fw-bold text-secondary">Mission Image:</label>
          <div class="">
            <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['mission_img'] ?? 'mission2.png')?>" alt="" class="current-cms-img img-fluid mb-3" data-cms-key="mission_img"
            style="max-width: 100%; height: auto;">
            <div class="upload-box uploadBox">
              <input type="file" class="form-control mb-2 cms-image-input fileInput" data-cms-key="mission_img" accept="image/*">
              <p>Click or drag a file here to upload</p>
            </div>
          </div>  
        </div>

         <div class="">
            <label class="form-label fw-bold text-secondary">Centered Image:</label>
            <div class="">

              <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['phone3_img'] ?? 'about_image.png')?>" alt="" class="current-cms-img img-fluid w-50 mb-2"
              data-cms-key="phone3_img">
              <div class="upload-box uploadBox">
                <input type="file" class="form-control mb-2 cms-image-input fileInput" data-cms-key="phone3_img" accept="image/*">
                <p>Click or drag a file here to upload</p>
              </div>
            </div>
        </div>

        <div class="">
            <label class="form-label fw-bold text-secondary">Vision Image:</label>
            <div class="">

              <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['vision_img'] ?? 'vision2.png')?>" alt="" class="current-cms-img img-fluid mb-3"
              style="max-width: 100%; height: auto;" data-cms-key="vision_img">
              <div class="upload-box uploadBox">
                <input type="file" class="form-control mb-2 cms-image-input fileInput" data-cms-key="vision_img" accept="image/*">
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
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.querySelector('.mvisionContent');
  const form  = document.getElementById('mvision-form');
  if (!modal || !form) return;

  // --- Elements ---
  const missionFontHex   = document.getElementById('mission_font_hex');
  const missionFontColor = document.getElementById('mission_font_color');

  const visionFontHex    = document.getElementById('vision_font_hex');
  const visionFontColor  = document.getElementById('vision_font_color');

  const missionInput     = document.getElementById('mission_con');
  const visionInput      = document.getElementById('vision_con');

  const missionContentEl = document.querySelector('#mv-view .mission p');
  const visionContentEl  = document.querySelector('#mv-view .vision p');

  const bgHex   = document.getElementById('mvision_bg_color_hex');
  const bgColor = document.getElementById('mvision_bg_color');
  const mvView  = document.getElementById('mv-view');

  // --- Save original values ---
  let original = {};
  modal.addEventListener('show.bs.modal', () => {
    original = {
      missionColor: missionContentEl.style.color,
      visionColor:  visionContentEl.style.color,
      bgColor: mvView.style.backgroundColor
    };
  });

  // --- Helpers ---
  const isHex = (v) => /^#([0-9A-F]{3}|[0-9A-F]{6})$/i.test(v);

  function bindColorPair(picker, hex, target) {
    if (!picker || !hex || !target) return;
    picker.addEventListener('input', () => {
      hex.value = picker.value.toUpperCase();
      target.style.color = picker.value;
    });
    hex.addEventListener('input', () => {
      if (isHex(hex.value)) {
        picker.value = hex.value.toUpperCase();
        target.style.color = hex.value;
      }
    });
  }

  function bindText(input, target) {
    if (!input || !target) return;
    input.addEventListener('input', () => {
      target.textContent = input.value;
    });
  }

  function bindBgColor(picker, hex, target) {
    if (!picker || !hex || !target) return;
    picker.addEventListener('input', () => {
      hex.value = picker.value.toUpperCase();
      target.style.backgroundColor = picker.value;
    });
    hex.addEventListener('input', () => {
      if (isHex(hex.value)) {
        picker.value = hex.value.toUpperCase();
        target.style.backgroundColor = hex.value;
      }
    });
  }

  // --- Bind everything ---
  bindColorPair(missionFontColor, missionFontHex, missionContentEl);
  bindColorPair(visionFontColor,  visionFontHex,  visionContentEl);
  bindBgColor(bgColor, bgHex, mvView);

  // --- Reset on modal close ---
  modal.addEventListener('hidden.bs.modal', () => {
    form.reset();

    // restore original preview
    if (missionContentEl) {
      missionContentEl.style.color = original.missionColor;
    }
    if (visionContentEl) {
      visionContentEl.style.color = original.visionColor;
    }
    if (mvView) {
      mvView.style.backgroundColor = original.bgColor;
    }
  });
});

</script>
