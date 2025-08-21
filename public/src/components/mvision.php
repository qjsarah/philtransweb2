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
<section class="text-white py-5" style="background-color:#000066;">


  <div class="container">
    <div class="row  text-center text-lg-start">
      <!-- Mission -->
      <div class="col-12 col-lg-4 mb-4 mb-lg-0 d-flex flex-column justify-content-start text-start">
        <img src="../../public/main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['mission_img'] ?? 'mission2.png')?>"
             alt="Mission Image"
             class="img-fluid current-cms-img mb-3"
             data-aos="fade-left" data-aos-duration="1000" data-cms-key="mission_img">
        <p class="fs-5" data-aos="fade-left" data-aos-duration="1500">
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
      <div class="col-12 col-lg-4 d-flex flex-column justify-content-end text-end">
        <img src="../../public/main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['vision_img'] ?? 'vision2.png')?>"
             alt="Vision Image"
             class="img-fluid current-cms-image mb-3"
             data-aos="fade-right" data-aos-duration="1000" data-cms-key="vision_img">
        <p class="fs-5 text-lg-end" data-aos="fade-right" data-aos-duration="1500">
          <?php echo htmlspecialchars($content['vision_con'] ?? "In a future powered by our app, tricycle rides become effortless..."); ?>
        </p>
      </div>
    </div>
  </div>

    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="text-center mb-4">
      <button type="button" class="btn btn-warning mt-2" onclick="toggleEditAll(this)" data-modal-target=".mvisionContent">Edit</button>
      <button type="button" class="btn btn-warning mt-2" onclick="toggleEditAll(this)" data-modal-target=".edit-mv-images">Edit Image</button>
    </div>
  <?php endif; ?>

</section>

<!-- Modal -->
<div class="modal fade mvisionContent" tabindex="-1">
   <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
      <div class="modal-header">
        <h3 class="modal-title">Edit Mission & Vision Content</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="mvision-form" method="POST" action="backend/savecms.php">
          <textarea name="mission_con" class="form-control mb-3" rows="5"><?php echo htmlspecialchars($content['mission_con'] ?? ""); ?></textarea>
          <textarea name="vision_con" class="form-control mb-3" rows="5"><?php echo htmlspecialchars($content['vision_con'] ?? ""); ?></textarea>
          <div id="edit-buttons" class="text-center modal-footer">
            <button type="button" form="mvision-form" class="save-button btn btn-success mb-2">Save</button>
            <button type="button" class="btn btn-secondary mb-2 ms-2" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>
  <div class="modal fade edit-mv-images" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Edit Content</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="mvision-form" method="POST" action="backend/savecms.php" class="text-center">
        <div class="d-flex align-items-center">
          <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['mission_img'] ?? 'mission2.png')?>" alt="" class="current-cms-img img-fluid w-50" data-cms-key="mission_img">
          <div class="upload-box uploadBox">
                <input type="file" class="form-control mb-2 cms-image-input fileInput" data-cms-key="mission_img" accept="image/*">
                <p>Click or drag a file here to upload</p>
          </div>
        </div>
        <div class="d-flex align-items-center">
          <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['vision_img'] ?? 'vision2.png')?>" alt="" class="current-cms-img img-fluid w-50" data-cms-key="vision_img">
          <div class="upload-box uploadBox">
                <input type="file" class="form-control mb-2 cms-image-input fileInput" data-cms-key="vision_img" accept="image/*">
                <p>Click or drag a file here to upload</p>
          </div>
        </div>
        <div class="d-flex align-items-center">
          <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['phone3_img'] ?? 'about_image.png')?>" alt="" class="current-cms-img img-fluid w-25" data-cms-key="phone3_img">
          <div class="upload-box uploadBox">
                <input type="file" class="form-control mb-2 cms-image-input fileInput" data-cms-key="phone3_img" accept="image/*">
                <p>Click or drag a file here to upload</p>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
