<?php
include 'backend/config.php';

$keys = ['header2', 'paragraph2', 'paragraph2_1', 'phone2_img'];
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
  <?php if (isset($_SESSION['user_id'])): ?>
  <div class="container d-none d-lg-block py-5">
    <div class="row align-items-center justify-content-between" style="color:#000066">
      
      <!-- Left Column -->
      <div class="col-lg-7 text-start fs-5">
        <h3 class="fw-bold display-5" data-aos="fade-right" data-aos-duration="1000"><?php echo htmlspecialchars($content['header2']  ?? 'Welcome to Philippines Transportation App System!'); ?></h3><br>
        <p data-aos="fade-right" data-aos-duration="1500">
          <?php echo htmlspecialchars($content['paragraph2'] ?? "PTAS breaks the mold of traditional transportation apps. They're not just about getting you from point A to point B; they're shaking up the transportation industry with a people-centric approach. 
          PTAS goes beyond offering rides. 
          They empower drivers by increasing their earning potential and fostering positive changes in their lives. But the impact doesn't stop there. 
          PTAS is dedicated to creating a smoother and more enjoyable experience for passengers as well."); ?>
        </p><br>
        <p data-aos="fade-right" data-aos-duration="1700">
          <?php echo htmlspecialchars($content['paragraph2_1'] ?? "In essence, PTAS represents a paradigm shift in transportation, where the focus lies not only on the journey's endpoint but also on enhancing the journey itself.
          It's about fostering empowerment, enriching experiences, and prioritizing the well-being of both drivers and passengers in every aspect of their transportation needs."); ?>
        </p>
        <div class="text-center mb-5">
          <button type="button" class="btn btn-warning mt-3" onclick="toggleEditAll(this)" data-modal-target=".introContent">Edit</button>
        </div>
      </div>

      <!-- Right Column -->
      <div class="col-lg-4 text-end" data-aos="fade-left" data-aos-duration="2000"> 
        <img src="../../public/main/images/intro_section/<?php echo htmlspecialchars($content['phone2_img'] ?? 'intro_img.png')?>" alt="phone2" class="img-fluid current-cms-img" data-cms-key="phone2_img">
      </div>

      <!-- Modal -->
       <div class="modal fade introContent" tabindex="-1">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Edit Content</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    <div class="modal-body">
                        <form id="all-form" method="POST" action="backend/savecms.php">
                            <textarea name="header2" class="form-control mb-3" rows="2"><?php echo htmlspecialchars($content['header2'] ?? "Welcome to Philippine Transportation App System"); ?></textarea>
                            <textarea name="paragraph2" class="form-control mb-3" rows="4"><?php echo htmlspecialchars($content['paragraph2'] ?? "PTAS breaks the mold of traditional transportation apps. They're not just about getting you from point A to point B; they're shaking up the transportation industry with a people-centric approach. PTAS goes beyond offering rides. They empower drivers by increasing their earning potential and fostering positive changes in their lives. But the impact doesn't stop there. PTAS is dedicated to creating a smoother and more enjoyable experience for passengers as well."); ?></textarea>
                            <textarea name="paragraph2_1" class="form-control mb-3" rows="4"><?php echo htmlspecialchars($content['paragraph2_1'] ?? "In essence, PTAS represents a paradigm shift in transportation, where the focus lies not only on the journey's endpoint but also on enhancing the journey itself. It's about fostering empowerment, enriching experiences, and prioritizing the well-being of both drivers and passengers in every aspect of their transportation needs."); ?></textarea>
                            <div>
                                <img src="../main/images/intro_section/<?php echo htmlspecialchars($content['phone2_image'] ?? 'intro_image.png')?>" class="current-cms-img img-fluid" data-cms-key="phone2_image" alt="">
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <input type="file" class="form-control mb-2 cms-image-input" data-cms-key="phone2_image" accept="image/*">
                                <?php endif; ?>
                            </div>
                            <div class="text-center modal-footer">
                                <button type="submit" class="btn btn-success mb-2">Save</button>
                                <button type="button" class="btn btn-secondary mb-2 ms-2" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
          </div>

      <?php else: ?>
      <div class="container d-none d-lg-block py-5">
    <div class="row align-items-center justify-content-between" style="color:#000066">
      
      <!-- Left Column -->
      <div class="col-lg-7 text-start fs-5">
        <h3 class="fw-bold display-5" data-aos="fade-right" data-aos-duration="1000"><?php echo htmlspecialchars($content['header2']  ?? 'Welcome to Philippines Transportation App System!'); ?></h3><br>
        <p data-aos="fade-right" data-aos-duration="1500">
          <?php echo htmlspecialchars($content['paragraph2'] ?? "PTAS breaks the mold of traditional transportation apps. They're not just about getting you from point A to point B; they're shaking up the transportation industry with a people-centric approach. 
          PTAS goes beyond offering rides. 
          They empower drivers by increasing their earning potential and fostering positive changes in their lives. But the impact doesn't stop there. 
          PTAS is dedicated to creating a smoother and more enjoyable experience for passengers as well."); ?>
        </p><br>
        <p data-aos="fade-right" data-aos-duration="1700">
          <?php echo htmlspecialchars($content['paragraph2_1'] ?? "In essence, PTAS represents a paradigm shift in transportation, where the focus lies not only on the journey's endpoint but also on enhancing the journey itself.
          It's about fostering empowerment, enriching experiences, and prioritizing the well-being of both drivers and passengers in every aspect of their transportation needs."); ?>
        </p>
      </div>

      <!-- Right Column -->
      <div class="col-lg-4 text-end" data-aos="fade-left" data-aos-duration="2000"> 
        <img src="../../public/main/images/intro_section/<?php echo htmlspecialchars($content['phone2_img'] ?? 'intro_img.png')?>" alt="phone2" class="img-fluid current-cms-img" data-cms-key="phone2_img">
      </div>
        <?php endif; ?>

    </div>
  </div>

  <!-- Mobile & Tablet Layout -->
  <div class="container d-lg-none text-center py-5">
    <!-- Image -->
    <div class="row">
      <div class="col-12">
        <img src="../../public/main/images/intro_section/intro_image.png" 
             alt="Tricycle" 
             class="img-fluid"
             style="max-width: 300px;" data-aos="fade-right" data-aos-duration="1000">
      </div>
    </div>

    <!-- Text -->
    <div class="row mt-4">
      <div class="col-12 fs-5" style="color:#000066">
        <h3 class="fw-bold display-5" data-aos="fade-right" data-aos-duration="1000">Welcome to Philippines Transportation App System</h3><br>
        <p data-aos="fade-right" data-aos-duration="1000">
          PTAS breaks the mold of traditional transportation apps. They're not just about getting you from point A to point B; they're shaking up the transportation industry with a people-centric approach. 
          PTAS goes beyond offering rides. 
          They empower drivers by increasing their earning potential and fostering positive changes in their lives. But the impact doesn't stop there. 
          PTAS is dedicated to creating a smoother and more enjoyable experience for passengers as well.
        </p><br>
        <p data-aos="fade-right" data-aos-duration="1000">
          In essence, PTAS represents a paradigm shift in transportation, where the focus lies not only on the journey's endpoint but also on enhancing the journey itself.
          It's about fostering empowerment, enriching experiences, and prioritizing the well-being of both drivers and passengers in every aspect of their transportation needs.
        </p>
      </div>
    </div>
  </div>

</section>

