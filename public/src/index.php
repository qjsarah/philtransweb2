<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS Files -->
  <link rel="stylesheet" href="../node_modules/owl.carousel/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="../node_modules/owl.carousel/dist/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="../../public/main/style/main.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

  <!-- JS Files -->
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
  <script src="../main/scripts/bootstrap.bundle.min.js"></script>
  <script src="../main/scripts/data.js"></script>
</head>
<body>

  <!-- Navbar -->
  <div class="sticky-top z-3">
    <?php include 'components/navbar.php'; ?>
  </div>

  <!-- Download Section -->
  <section id="download">
    <?php include 'components/download.php'; ?>
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

  <!-- Services Section -->
  <section id="services">
    <?php include 'components/services.php'; ?>
  </section>

  <!-- Testimonials Section -->
  <section id="testimonial">
    <?php include 'components/testimonials.php'; ?>
  </section>

  <!-- Contact Section -->
  <section id="contact">
    <?php include 'components/contact.php'; ?>
  </section>

  <!-- Footer Section -->
  <section id="footer">
    <?php include 'components/footer.php'; ?>
  </section>
<!-- SCRIPTS DO NOT REMOVE TO HEAD PLEASE -->
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>
</html>
