<div class=" mx-5 position-relative mb-3 desktop">
    <nav class="navbar navbar-expand-lg justify-content-center fw-bold rounded-pill w-100 bg-light">
      <ul class="navbar-nav d-flex flex-row jsutify-content-center align-items-center gap-5" id="navBar">
        <?php if (isset($_SESSION['user_id'])): ?>
          <li style="z-index: 1000;" class="nav-item"><a href="#" class="nav-link text-secondary">Dashboard</a></li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link  text-primary" href="#about">About</a></li>
        <li class="nav-item"><a class="nav-link  text-primary" href="#services">Services</a></li>
        <li class="nav-item px-3 w-100 d-flex justify-content-center align-items-center">
            <a class="navbar-brand" href="#" id="logoWrapper">
                <img src="../../public/main/images/nav_section/logo.png" class="logo mx-auto d-block" alt="logo">
            </a>
        </li>
        <li class="nav-item"><a class="nav-link  text-primary" href="#testimonial">Testimonial</a></li>
        <li class="nav-item"><a class="nav-link  text-primary" href="#contact">Contact</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
          <li style="z-index: 1000;" class="nav-item"><a href="backend/logout.php" class="nav-link text-secondary logoutBtn">Logout</a></li>
        <?php endif; ?>
      </ul>
    </nav>
</div>
<div class="mb-2 mobile">
  <nav class="navbar navbar-expand-lg justify-content-between fw-bold sticky-top bg-light px-3">
    <a class="navbar-brand" href="#">
      <img src="../../public/main/images/nav_section/logo.png" class="logo mx-auto d-block" alt="logo">
    </a>
    <button class="navbar-toggler collapsed custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <div class="bar1 bg-primary"></div>
        <div class="bar2 bg-primary"></div>
        <div class="bar3 bg-primary"></div>
    </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav text-end" id="navBar">
          <li class="nav-item"><a class="nav-link  text-primary" href="#about">About</a></li>
          <li class="nav-item"><a class="nav-link  text-primary" href="#services">Services</a></li>
          <li class="nav-item"><a class="nav-link  text-primary" href="#testimonial">Testimonial</a></li>
          <li class="nav-item"><a class="nav-link  text-primary" href="#contact">Contact</a></li>
          <?php if (isset($_SESSION['user_id'])): ?>
            <li style="z-index: 1000;" class="nav-item"><a href="#" class="nav-link text-secondary">Dashboard</a></li>
            <li style="z-index: 1000;" class="nav-item"><a href="#" class="nav-link  text-secondary logoutBtn">Logout</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </nav>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const logoutButtons = document.querySelectorAll(".logoutBtn");

    logoutButtons.forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();

            Swal.fire({
              html: `
                  <h2 class="swal-modern-title">Are you sure?</h2>
                  <p class="swal-modern-text">You will be logged out of your account.</p>
              `,
              icon: null,
              showCancelButton: true,
              confirmButtonText: 'LOGOUT',
              cancelButtonText: 'CANCEL',
              background: '#ffffff',
              color: '#000066',
              buttonsStyling: false,
              imageUrl: '../main/images/nav_section/navtrycicle.png', 
              imageHeight: 200,
              imageAlt: 'Top Image',
              customClass: {
                  popup: 'swal-custom-popup',
                  title: 'swal-modern-title',
                  content: 'swal-modern-text',
                  confirmButton: 'swal-button-btn ok-btn',
                  cancelButton: 'swal-button-btn cancel-btn'
              },
              didOpen: () => {
                  const img = Swal.getImage();
                  img.style.marginTop = '-110px'; 
                  const separator = document.createElement('div');
                  separator.style.height = '2px';
                  separator.style.width = '100%';
                  separator.style.backgroundColor = '#000066';
                  separator.style.borderRadius = '5px';
                  const popup = Swal.getPopup();
                  popup.insertBefore(separator, popup.querySelector('.swal2-title'));
              }
          }).then((result) => {
    if (result.isConfirmed) {
        Swal.fire({
           html: `
                  <h2 class="swal-modern-title">Logged Out!</h2>
                  <p class="swal-modern-text">You have successfully logged out.</p>
              `,
            icon: null,
            showConfirmButton: false,
            timer: 1500,
            background: '#ffffff',
            color: '#000066',
            imageUrl: '../main/images/nav_section/navtrycicle.png', 
            imageHeight: 200,
            imageAlt: 'Top Image',
            customClass: {
                popup: 'swal-custom-popup',
                title: 'swal-modern-title',
                content: 'swal-modern-text',
            },
             didOpen: () => {
                  const img = Swal.getImage();
                  img.style.marginTop = '-110px'; 
                  const separator = document.createElement('div');
                  separator.style.height = '2px';
                  separator.style.width = '100%';
                  separator.style.backgroundColor = '#000066';
                  separator.style.borderRadius = '5px';
                  const popup = Swal.getPopup();
                  popup.insertBefore(separator, popup.querySelector('.swal2-title'));
             }
        }).then(() => {
            // Redirect after the user clicks OK
            window.location.href = "backend/logout.php";
        });
    }
});

        });
    });
});

</script>

<script>
    const logo = document.getElementById('logoWrapper');
    const navBar = document.getElementById('navBar');

    logo.addEventListener('mouseenter', () => {
        navBar.classList.add('show-nav');
    });

    navBar.addEventListener('mouseleave', () => {
        navBar.classList.remove('show-nav');
    });
</script>