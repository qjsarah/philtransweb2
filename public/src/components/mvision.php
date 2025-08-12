<?php
include 'backend/config.php';

$keys = ['mission_img', 'vision_img', 'mission_con', 'vision_con', 'phone3_img'];
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
<section class="text-white" style="background-color:#000066;">
  <?php if (isset($_SESSION['user_id'])): ?>
    <div class="text-center mb-5">
          <button type="button" class="btn btn-warning mt-3" onclick="toggleEditAll(this)" data-modal-target=".mvisionContent">Edit</button>
    </div>
  <!-- Desktop Layout (No Change) -->
  <div class="container d-none d-lg-block">
    <div class="row justify-content-between">
      <!-- Mission -->
      <div class="col-lg-4 d-flex flex-column justify-content-start text-start">
        <div class="mb-5">
          <img src="../../public/main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['mission_img'] ?? 'mission2.png')?>" alt="Mission Image" class="img-fluid current-cms-img" data-aos="fade-left" data-aos-duration="1000" data-cms-key="mission_img">
          <div class="text-start fs-5 mt-2">
            <p data-aos="fade-left" data-aos-duration="1500">
              <?php echo htmlspecialchars($content['mission_con'] ?? "Our mission is to empower every tricycle driver in the Philippines with cutting-edge technology, transforming their profession and boosting their income.
              By embracing innovation, we aim to elevate the national transportation system while preserving the iconic tricycle experience.
              Our commitment extends to passenger comfort, ensuring a smoother and more enjoyable journey for all Filipinos."); ?>
            </p>
          </div>
        </div>
      </div>

      <!-- Middle Image -->
      <div class="col-lg-4 d-flex justify-content-center align-items-center">
        <img src="../../public/main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['phone3_img'] ?? 'about_image.png')?>" alt="Middle Image" class="img-fluid" style="max-width:100%" data-aos="fade-up" data-aos-duration="500">
      </div>

      <!-- Vision -->
      <div class="col-lg-4 d-flex flex-column justify-content-end text-end">
        <div class="mt-5">
          <img src="../../public/main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['vision_img'] ?? 'vision2.png')?>" alt="Vision Image" class="img-fluid current-cms-image" data-aos="fade-right" data-aos-duration="1000" data-cms-key="vision_img">
          <div class="text-end fs-5 mt-2">
            <p data-aos="fade-right" data-aos-duration="1500">
              <?php echo htmlspecialchars($content['vision_con'] ?? "In a future powered by our app, tricycle rides become effortless. Passengers tap their way to their destination, matched efficiently with nearby drivers for prompt service.
              We ensure fair fares through transparent calculations, benefitting both riders (confident pricing) and drivers (consistent income).
              Our commitment extends to the community, partnering with locals to improve the tricycle system and elevate overall well-being.
              This future of tricycles is not just tech-driven, but deeply rooted in the communities it serves."); ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade mvisionContent" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Edit Content</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="mvision-form" method="POST" action="backend/savecms.php">
            <textarea name="mission_con" class="form-control mb-3" rows="5"><?php echo htmlspecialchars($content['mission_con'] ?? ""); ?></textarea>
            <textarea name="vision_con" class="form-control mb-3" rows="5"><?php echo htmlspecialchars($content['vision_con'] ?? ""); ?></textarea>
            <div class="text-center mb-3">
              <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['mission_img'] ?? 'mission2.png')?>" alt="" class="current-cms-img img-fluid" data-cms-key="mission_img">
              <?php if (isset($_SESSION['user_id'])): ?>
                <input type="file" class="form-control mb-2 cms-image-input" data-cms-key="mission_img" accept="image/*">
              <?php endif; ?>
              <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['vision_img'] ?? 'vision2.png')?>" alt="" class="current-cms-img img-fluid" data-cms-key="vision_img">
              <?php if (isset($_SESSION['user_id'])): ?>
                <input type="file" class="form-control mb-2 cms-image-input" data-cms-key="vision_img" accept="image/*">
              <?php endif; ?>
            </div>
            <div class="text-center mb-3">
              <img src="../main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['phone3_img'] ?? 'about_image.png')?>" alt="" class="current-cms-img img-fluid" data-cms-key="phone3_img">
              <?php if (isset($_SESSION['user_id'])): ?>
                <input type="file" class="form-control mb-2 cms-image-input" data-cms-key="phone3_img" accept="image/*">
              <?php endif; ?>
            </div>
            <div id="edit-buttons" class="text-center modal-footer">
              <button type="submit" form="mvision-form" class="btn btn-success mb-2">Save</button>
              <button type="button" class="btn btn-secondary mb-2 ms-2" data-bs-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    </div>
    <?php else: ?>
        <section class="text-white" style="background-color:#000066;">
        <!-- Desktop Layout (No Change) -->
        <div class="container d-none d-lg-block py-5">
          <div class="row justify-content-between">
            <!-- Mission -->
            <div class="col-lg-4 d-flex flex-column justify-content-start text-start">
              <div class="mb-5">
                <img src="../../public/main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['mission_img'] ?? 'mission2.png')?>" alt="Mission Image" class="img-fluid current-cms-img" data-aos="fade-left" data-aos-duration="1000" data-cms-key="mission_img">
                <div class="text-start fs-5 mt-2">
                  <p data-aos="fade-left" data-aos-duration="1500">
                    <?php echo htmlspecialchars($content['mission_con'] ?? "Our mission is to empower every tricycle driver in the Philippines with cutting-edge technology, transforming their profession and boosting their income.
                    By embracing innovation, we aim to elevate the national transportation system while preserving the iconic tricycle experience.
                    Our commitment extends to passenger comfort, ensuring a smoother and more enjoyable journey for all Filipinos."); ?>
                  </p>
                </div>
              </div>
            </div>

            <!-- Middle Image -->
            <div class="col-lg-4 d-flex justify-content-center align-items-center">
              <img src="../../public/main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['phone3_img'] ?? 'about_image.png')?>" alt="Middle Image" class="img-fluid" style="max-width:100%" data-aos="fade-up" data-aos-duration="500">
            </div>

            <!-- Vision -->
            <div class="col-lg-4 d-flex flex-column justify-content-end text-end">
              <div class="mt-5">
                <img src="../../public/main/images/mission_and_vission_section/<?php echo htmlspecialchars($content['vision_img'] ?? 'vision2.png')?>" alt="Vision Image" class="img-fluid current-cms-image" data-aos="fade-right" data-aos-duration="1000" data-cms-key="vision_img">
                <div class="text-end fs-5 mt-2">
                  <p data-aos="fade-right" data-aos-duration="1500">
                    <?php echo htmlspecialchars($content['vision_con'] ?? "In a future powered by our app, tricycle rides become effortless. Passengers tap their way to their destination, matched efficiently with nearby drivers for prompt service.
                    We ensure fair fares through transparent calculations, benefitting both riders (confident pricing) and drivers (consistent income).
                    Our commitment extends to the community, partnering with locals to improve the tricycle system and elevate overall well-being.
                    This future of tricycles is not just tech-driven, but deeply rooted in the communities it serves."); ?>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php endif?>

  <!-- Mobile Layout -->
  <div class="container d-block d-lg-none py-5">
    <!-- Mission -->
    <div class="mb-5 text-start">
      <img src="../../public/main/images/mission_and_vission_section/mission2.png" alt="Mission Image" class="img-fluid mb-3" data-aos="fade-left" data-aos-duration="1000">
      <div class="fs-6">
        <p data-aos="fade-left" data-aos-duration="1500">
          Our mission is to empower every tricycle driver in the Philippines with cutting-edge technology, transforming their profession and boosting their income.
          By embracing innovation, we aim to elevate the national transportation system while preserving the iconic tricycle experience.
          Our commitment extends to passenger comfort, ensuring a smoother and more enjoyable journey for all Filipinos.
        </p>
      </div>
    </div>

    <!-- Middle Image -->
    <div class="mb-5 text-center">
      <img src="../../public/main/images/mission_and_vission_section/about_image.png" alt="Middle Image" class="img-fluid" style="max-width: 100%;" data-aos="fade-up" data-aos-duration="500">
    </div>

    <!-- Vision -->
    <div class="text-start">
      <img src="../../public/main/images/mission_and_vission_section/vision2.png" alt="Vision Image" class="img-fluid mb-3" data-aos="fade-right" data-aos-duration="1000">
      <div class="fs-6">
        <p data-aos="fade-right" data-aos-duration="1500">
          In a future powered by our app, tricycle rides become effortless. Passengers tap their way to their destination, matched efficiently with nearby drivers for prompt service.
          We ensure fair fares through transparent calculations, benefitting both riders (confident pricing) and drivers (consistent income).
          Our commitment extends to the community, partnering with locals to improve the tricycle system and elevate overall well-being.
          This future of tricycles is not just tech-driven, but deeply rooted in the communities it serves.
        </p>
      </div>
    </div>
  </div>

</section>
