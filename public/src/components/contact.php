<?php
include 'backend/config.php'; 

$keys = ['contact_title', 'email', 'number', 'loc', 'phone4_img', 'location_img', 'contact_img', 'web_img'];
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
<section class="contact text-white">
  <?php if (isset($_SESSION['user_id'])): ?>
    <div class="text-center mb-5">
      <button type="button" class="btn btn-warning mt-3" onclick="toggleEditAll(this)" data-modal-target=".contactContent">Edit</button>
      <button type="button" class="btn btn-warning mt-3" onclick="toggleEditAll(this)" data-modal-target=".edit-contact-image">Edit Image</button>
    </div>
  <?php endif; ?>

  <div class="container py-5">
    <div class="row align-items-center g-4">
      <!-- Form Column -->
      <div class="col-lg-6">
        <h5 class="display-5 fw-bold" data-aos="fade-right" data-aos-duration="500"><?php echo htmlspecialchars($content['contact_title'] ?? "Get in Touch."); ?></h5>

        <form class="mt-4" >
          <!-- Name Field -->
          <div class="mb-3" data-aos="fade-right" data-aos-duration="1000">
            <input type="text" class="form-control" id="inputName" placeholder="Enter your name">
          </div>

          <!-- Email Field -->
          <div class="mb-3" data-aos="fade-right" data-aos-duration="1000">
            <input type="email" class="form-control" id="inputEmail" placeholder="Enter your email">
          </div>

          <!-- Message Field -->
          <div class="mb-4" data-aos="fade-right" data-aos-duration="1000">
            <textarea class="form-control" id="inputMessage" rows="7" placeholder="Type your message here..."></textarea>
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
          <!-- Main Contact Image -->
          <div class="position-relative d-inline-block w-100">
            <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['phone4_img'] ?? 'contact_img.png')?>" class="img-fluid rounded current-cms-img" alt="Phone Image" data-cms-key="phone_img4">
              <!-- Icon 1: Message -->
              <div class="position-absolute d-flex align-items-center gap-3" style="top: 20%; left: 12%;" data-aos="fade-up" data-aos-duration="500">
                <div class="icon-circle">
                  <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['contact_img'] ?? 'message_imgs.png')?>" class="icon-img current-cms-img" alt="Mail Icon" data-cms-key="contact_img">
                </div>
                <div class="contact_nav d-flex flex-column text-start small text-white">
                  <a href="" ><?php echo htmlspecialchars($content['email'] ?? "info@philtransinc.com"); ?></a>
                  <a href=""><?php echo htmlspecialchars($content['number'] ?? "+63 917 501 0018"); ?></a>
                </div>
              </div>
              <!-- Icon 2: Website -->
              <div class="position-absolute d-flex align-items-center gap-3 mb-4" style="top: 38%; left: 12%;" data-aos="fade-up" data-aos-duration="1000">
                <div class="icon-circle">
                  <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['web_img'] ?? 'web.png')?>" class="icon-img current-cms-img" alt="Web Icon" data-cms-key="web_img">
                </div>
                <div class="contact_nav d-flex flex-column text-start small text-white">
                          <a href="#about">About us</a>
                          <a href="">Copyright</a>
                          <a href="">Privacy Policy</a>
                          <a href="">Terms and Condition</a>
                          <a href="">FAQs</a>
                </div>
              </div>
              <!-- Icon 3: Location -->
              <div class="position-absolute d-flex align-items-center gap-3" style="top: 62%; left: 12%;" data-aos="fade-up" data-aos-duration="2000">
              <!-- Icon -->
              <div class="icon-circle">
                <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['location_img'] ?? 'location.png')?>" class="icon-img w-75 current-cms-img" alt="Location Icon" data-cms-key="location_img">
              </div>
              <!-- Text aligned to icon center -->
              <div class="contact_nav text-start small text-white d-flex align-items-center">
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
<!-- Content Edit Modal -->
<div class="modal fade contactContent" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Edit Contact Content</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="contact-content-form" method="POST" action="backend/savecms.php">
          <!-- Contact Title -->
          <label class="fw-bold">Contact Title</label>
          <textarea name="contact_title" class="form-control mb-3" rows="2"><?php echo htmlspecialchars($content['contact_title'] ?? 'Get in Touch.'); ?></textarea>

          <!-- Email -->
          <label class="fw-bold">Email</label>
          <input type="email" name="email" class="form-control mb-3" value="<?php echo htmlspecialchars($content['email'] ?? 'info@philtransinc.com'); ?>">

          <!-- Number -->
          <label class="fw-bold">Phone Number</label>
          <input type="text" name="number" class="form-control mb-3" value="<?php echo htmlspecialchars($content['number'] ?? '+63 917 501 0018'); ?>">

          <!-- Location -->
          <label class="fw-bold">Location</label>
          <textarea name="location" class="form-control mb-3" rows="3"><?php echo htmlspecialchars($content['loc'] ?? 'Your location address here...'); ?></textarea>
          <div class="modal-footer">
            <button type="button" form="contact-content-form" class="save-button btn btn-success">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Image Edit Modal -->
<div class="modal fade edit-contact-image" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Edit Contact Images</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="contact-image-form" method="POST" action="backend/savecms.php" enctype="multipart/form-data">
          <div class="row g-4">
            <!-- Phone Image -->
            <div class="col-md-6 text-center">
              <label class="fw-bold">Phone Image</label>
              <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['phone4_img'] ?? 'contact_img.png')?>" class="img-fluid w-50 mb-3">
              <div class="upload-box uploadBox">
                <input type="file" class="fileInput" name="phone4_img" accept="image/*">
                <p>Click or drag a file here to upload</p>
              </div>
            </div>

            <!-- Contact Icon -->
            <div class="col-md-6 text-center">
              <label class="fw-bold">Contact Icon</label>
              <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['contact_img'] ?? 'message_imgs.png')?>" class="img-fluid w-25 mb-3">
              <div class="upload-box uploadBox">
                <input type="file" class="fileInput" name="contact_img" accept="image/*">
                <p>Click or drag a file here to upload</p>
              </div>
            </div>

            <!-- Web Icon -->
            <div class="col-md-6 text-center">
              <label class="fw-bold">Web Icon</label>
              <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['web_img'] ?? 'web.png')?>" class="img-fluid w-25 mb-3">
              <div class="upload-box uploadBox">
                <input type="file" class="fileInput" name="web_img" accept="image/*">
                <p>Click or drag a file here to upload</p>
              </div>
            </div>

            <!-- Location Icon -->
            <div class="col-md-6 text-center">
              <label class="fw-bold">Location Icon</label>
              <img src="../../public/main/images/contact_section/<?php echo htmlspecialchars($content['location_img'] ?? 'location.png')?>" class="img-fluid w-25 mb-3">
              <div class="upload-box uploadBox">
                <input type="file" class="fileInput" name="location_img" accept="image/*">
                <p>Click or drag a file here to upload</p>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>