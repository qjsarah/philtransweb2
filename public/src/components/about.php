<?php
include 'backend/config.php';

$keys = ['header3', 'paragraph3', 'paragraph3_1', 'tricycle_img', 'header3_1'];
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
?>
<section class="container py-4" style="color: #000066;">
    <?php if (isset($_SESSION['user_id'])): ?>
    <h3 class="text-center fs-1 w-100 px-3 mx-auto py-3" data-aos="fade-down" data-aos-duration="1000"><?php echo htmlspecialchars($content['header3']  ?? 'PTAS: REVOLUTIONIZING RIDES AND REDEFINING THE TRICYCLE INDUSTRY'); ?></h3>

    <div class="d-flex flex-column flex-lg-row align-items-center gap-4 px-3">
        <!-- Left Text -->
        <div class="col-12 col-lg-4">
            <p class="mt-3 mt-lg-5" data-aos="fade-right" data-aos-duration="1500"><?php echo htmlspecialchars($content['paragraph3']  ?? 'In the ever-evolving landscape of transportation, PTAS emerges as more than just another app. It shatters the mold of traditional ride-hailing services, offering a revolutionary approach centered around the very people who keep the tricycle industry moving – the drivers.'); ?></p>
        </div>

        <!-- Image -->
        <div class="col-12 col-lg-4 text-center">
            <img src="../../public/main/images/about_section/<?php echo htmlspecialchars($content['tricycle_img'] ?? 'desktop_trycicle.png')?>" alt="About Image" class="img-fluid mb-3 mt-5 current-cms-img" style="max-width: 100%;" data-aos="zoom-in-down" data-aos-duration="2000" data-cms-key="tricycle_img">
        </div>

        <!-- Right Text -->
        <div class="col-12 col-lg-4 text-lg-end text-center">
            <h4 class="fs-2" data-aos="fade-right" data-aos-duration="2000"><?php echo htmlspecialchars($content['header3_1']  ?? 'ABOUT US'); ?></h4>
            <p class="mt-3 mt-lg-5" data-aos="fade-right" data-aos-duration="2000">
                <?php echo htmlspecialchars($content['paragraph3_1']  ?? `PTAS transcends the mere act of getting you from point A to point B; it's a catalyst for positive change, empowering drivers, enhancing passenger experiences.`); ?>
            </p>
        </div>
        

        <!-- Modal -->
         <div class="modal fade aboutContent" tabindex="-1">
              <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3 class="modal-title">Edit Content</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form class="form" method="POST" action="backend/savecms.php">

                      <!-- Editable Fields -->
                      <textarea name="header3" class="form-control mb-3" rows="2"><?php echo htmlspecialchars($content['header3'] ?? ""); ?></textarea>
                      <textarea name="paragraph3" class="form-control mb-3" rows="5"><?php echo htmlspecialchars($content['paragraph3'] ?? ""); ?></textarea>
                      <textarea name="header3_1" class="form-control mb-3" rows="2"><?php echo htmlspecialchars($content['header3_1'] ?? "ABOUT US"); ?></textarea>
                      <textarea name="paragraph3_1" class="form-control mb-3" rows="5"><?php echo htmlspecialchars($content['paragraph3_1'] ?? ""); ?></textarea>
                      <div class="text-center modal-footer">
                        <button type="button" class="btn btn-success mb-2 save-button">Save</button>                        <button type="button" class="btn btn-secondary mb-2 ms-2" data-bs-dismiss="modal">Cancel</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
    </div>
    <div class="text-center py-5">
                <div class="text-center mb-5">
                <button type="button" class="btn btn-warning mt-3" onclick="toggleEditAll(this)" data-modal-target=".aboutContent">Edit</button>
                </div>
            </div>
    <?php else: ?>
            <h3 class="text-center fs-1 w-100 px-3 mx-auto py-3" data-aos="fade-down" data-aos-duration="1000"><?php echo htmlspecialchars($content['header3']  ?? 'PTAS: REVOLUTIONIZING RIDES AND REDEFINING THE TRICYCLE INDUSTRY'); ?></h3>
            <div class="d-flex flex-column flex-lg-row align-items-center gap-4 px-3">
        <!-- Left Text -->
        <div class="col-12 col-lg-4">
            <p class="mt-3 mt-lg-5" data-aos="fade-right" data-aos-duration="1500"><?php echo htmlspecialchars($content['paragraph3']  ?? 'In the ever-evolving landscape of transportation, PTAS emerges as more than just another app. It shatters the mold of traditional ride-hailing services, offering a revolutionary approach centered around the very people who keep the tricycle industry moving – the drivers.'); ?></p>
        </div>

        <!-- Image -->
        <div class="col-12 col-lg-4 text-center">
            <img src="../../public/main/images/about_section/<?php echo htmlspecialchars($content['tricycle_img'] ?? 'desktop_trycicle.png')?>" alt="About Image" class="img-fluid mb-3 mt-5 current-cms-img" style="max-width: 100%;" data-aos="zoom-in-down" data-aos-duration="2000" data-cms-key="tricycle_img">
        </div>

        <!-- Right Text -->
        <div class="col-12 col-lg-4 text-lg-end text-center">
            <h4 class="fs-2" data-aos="fade-right" data-aos-duration="2000"><?php echo htmlspecialchars($content['header3_1']  ?? 'ABOUT US'); ?></h4>
            <p class="mt-3 mt-lg-5" data-aos="fade-right" data-aos-duration="2000">
                <?php echo htmlspecialchars($content['paragraph3_1']  ?? `PTAS transcends the mere act of getting you from point A to point B; it's a catalyst for positive change, empowering drivers, enhancing passenger experiences.`); ?>
            </p>
        </div>
        <?php endif; ?>
</section>
