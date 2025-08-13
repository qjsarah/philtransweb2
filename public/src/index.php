<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<?php session_start(); ?>
<?php if (isset($_SESSION['user_id'])): ?>
  <div style="position: fixed; top: 10px; left: 10px; z-index: 1000;">
    <a href="backend/logout.php" class="btn btn-primary">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>
  </div>
<?php endif; ?>
<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="../main/images/favicon.png"> 
  <!-- CSS Files -->
  <link rel="stylesheet" href="../node_modules/owl.carousel/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="../node_modules/owl.carousel/dist/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="../../public/main/style/main.css">
  <link rel="stylesheet" href="../node_modules/aos/dist/aos.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />

  <!-- JS Files -->
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
  <script src="../main/scripts/bootstrap.bundle.min.js"></script>
  <script src="../main/scripts/data.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
</head>
<body>

  <!-- Navbar -->
  <div class="sticky-top z-3">
    <?php include 'components/navbar.php'; ?>
  </div>
  
  <!-- Download Section -->
  <section class="download_section" id="download">
    <?php include 'components/download.php'; ?>
  </section>

  <!-- Ads Section -->
  <section class="ads" id="#">
    <?php include 'components/ads/ads_1.php'; ?>
  </section>

  <!-- Intro Section -->
  <section id="intro">
    <?php include 'components/intro.php'; ?>
  </section>

  <!-- About Section -->
  <section id="about">
    <?php include 'components/about.php'; ?>
  </section>

  <!-- Mission & Vision Section -->
  <section id="missionvission">
    <?php include 'components/mvision.php'; ?>
  </section>

  <!-- Ads 2 Section -->
  <section id="ads_2">
    <?php include 'components/ads/ads_2.php'; ?>
  </section>

  <!-- Services Section -->
  <section class="mt-5 pt-5" id="services">
    <?php include 'components/services.php'; ?>
  </section>

    <!-- Ads Section -->
  <section id="#">
    <?php include 'components/ads/ads_3.php'; ?>
  </section>

  <!-- Testimonials Section -->
  <section class="mt-5 pt-5 pb-5" id="testimonial">
    <?php include 'components/testimonials.php'; ?>
  </section>

  <!-- Contact Section -->
  <section class="mt-5 pt-5" id="contact">
    <?php include 'components/contact.php'; ?>
  </section>

  <!-- Footer Section -->
  <section id="footer">
    <?php include 'components/footer.php'; ?>
  </section>
  <!-- SCRIPT FOR AOS DO NOT REMOVE TO HEAD PLEASE -->
  <script src="../node_modules/aos/dist/aos.js"></script>
  <script>
    AOS.init();
      
  // For backdrop interference with modals
  $(document).on('show.bs.modal', '.modal', function () {
        $(this).appendTo('body');
  });

  // Cropper
  document.querySelectorAll('.cms-image-input').forEach(input => { //CROPPERRRR
    input.addEventListener('change', function (e) {
      const file = e.target.files[0];
      if (!file) return;

      const cmsKey = this.getAttribute('data-cms-key');

      const reader = new FileReader();
      reader.onload = () => {
        // Save base64 image and cmsKey to sessionStorage
        sessionStorage.setItem('tempImage', reader.result);
        sessionStorage.setItem('cmsKey', cmsKey);

        // Redirect to cropping page with cms_key in URL (optional, just for clarity)
        window.location.href = `components/imagecropper.php?cms_key=${cmsKey}`;
      };
      reader.readAsDataURL(file);
    });
  });
  document.body.appendChild(document.getElementById('editTestimonial'));
  </script>
  <script src="../main/scripts/script.js"></script>
</body>
</html>
