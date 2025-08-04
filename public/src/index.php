<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../node_modules/owl.carousel/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="../node_modules/owl.carousel/dist/assets/owl.theme.default.min.css">
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
  <script src="../main/scripts/bootstrap.bundle.min.js"></script>
  <script src="../main/scripts/data.js"></script>
  <link rel="stylesheet" href="../main/style/main.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body class="">
  <div class="sticky-top z-3">
    <?php include 'components/navbar.php'; ?>
    </div>
    <section id="services">
      <?php include 'components/services.php'; ?>
    </section>
    <section id="testimonials">
      <?php include 'components/testimonials.php'; ?>
    </section>

    
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>
</html>