<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<?php session_start(); ?>
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
  <script>
    document.querySelectorAll('.save-button').forEach(button => {
        button.addEventListener('click', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to save your changes?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, save it!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                  swal.fire({
                    title: 'Saved!',
                    text: 'Your changes have been saved successfully.',
                    icon: 'success',  
                    timer: 500,
                    showConfirmButton: false,
                  }).then(() => {
                    const form = button.closest('form'); // find the form this button belongs to
                    if (form) {
                        form.submit();
                    }
                  })
                }
            });
        });
    });

    const uploadBoxes = document.querySelectorAll(".uploadBox");
    const fileInputs = document.querySelectorAll(".fileInput");

    uploadBoxes.forEach((box, index) => {
      const input = fileInputs[index]; // Link each box to its file input

      // Click to open file dialog
      box.addEventListener("click", () => input.click());

      // Highlight on drag
      box.addEventListener("dragover", (e) => {
        e.preventDefault();
        box.classList.add("dragover");
      });

      box.addEventListener("dragleave", () => {
        box.classList.remove("dragover");
      });

      // Handle dropped files
      box.addEventListener("drop", (e) => {
        e.preventDefault();
        box.classList.remove("dragover");

        if (e.dataTransfer.files.length) {
          input.files = e.dataTransfer.files;
        }
      });

      // Handle normal file selection
      input.addEventListener("change", () => {
        // No alert — just keeps the file in the input
      });
    });
  </script>
</body>
</html>
