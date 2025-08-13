<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header('Location: download.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../../main/style/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!--Include these links -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="text-white" style="background-color: #000066;">
  <div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="row w-100 justify-content-center"
      style="max-width: 1000px; height: 620px; background-color: #ffffff; border-radius: 20px; box-shadow: 0 0 20px #000000 ">

      <!-- Left: Logo/Image -->
      <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center p-4">
        <div class="d-flex flex-column align-items-center">
          <img src="../../main/images/register_section/registerphiltranslogo.png" alt="Philtrans Logo"
            class="img-fluid rounded-4 mb-3" style="max-height: 80px;">
          <img src="../../main/images/register_section/registerphiltrans.png" alt="Philtrans Image"
            class="img-fluid rounded-4" style="max-height: 300px;">
        </div>
      </div>

      <!-- Right: Register Form -->
      <div class="col-md-6 d-flex flex-column justify-content-center px-4 py-5">
        <h2 class="text-center mb-4 fw-semibold" style="color:#000066;">REGISTER</h2>
        <form id="registerForm" class="w-100">
          <div class="mb-4">
            <label for="name" class="form-label" style="color: #000066;">FULL NAME</label>
            <input type="text" name="name" class="form-control"
              style="background-color: #ffffff; border: none; border: 3px solid #000066;"
              id="name" placeholder="Enter your full name">
          </div>

          <div class="mb-4">
            <label for="email" class="form-label" style="color: #000066;">EMAIL</label>
            <input type="email" name="email" class="form-control"
              style="background-color: #ffffff; border: none; border: 3px solid #000066;"
              id="email" placeholder="Enter your email">
          </div>

          <div class="mb-4">
  <label for="password" class="form-label" style="color: #000066;">PASSWORD</label>
  <div style="position: relative;">
    <input type="password"
      id="password"
      class="form-control"
      placeholder="Enter your password"
      style="background-color: #ffffff; border: none; border: 3px solid #000066; padding-right: 50px;">
    <i class="bi bi-eye-fill"
      id="togglePassword"
      onclick="
        const pwd = document.getElementById('password');
        const icon = this;
        if (pwd.type === 'password') {
          pwd.type = 'text';
          icon.classList.remove('bi-eye-fill');
          icon.classList.add('bi-eye-slash-fill');
        } else {
          pwd.type = 'password';
          icon.classList.remove('bi-eye-slash-fill');
          icon.classList.add('bi-eye-fill');
        }"
      style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%);
        font-size: 1.3rem; color: #000066; cursor: pointer;"></i>
  </div>
</div>

         <div class="mb-4">
  <label for="confirmPassword" class="form-label" style="color: #000066;">CONFIRM PASSWORD</label>
  <div style="position: relative;">
    <input type="password"
      id="confirmPassword"
      class="form-control"
      placeholder="Confirm your password"
      style="background-color: #ffffff; border: none; border: 3px solid #000066; padding-right: 50px;">
    <i class="bi bi-eye-fill"
      id="toggleConfirmPassword"
      onclick="
        const confirmPwd = document.getElementById('confirmPassword');
        const icon = this;
        if (confirmPwd.type === 'password') {
          confirmPwd.type = 'text';
          icon.classList.remove('bi-eye-fill');
          icon.classList.add('bi-eye-slash-fill');
        } else {
          confirmPwd.type = 'password';
          icon.classList.remove('bi-eye-slash-fill');
          icon.classList.add('bi-eye-fill');
        }"
      style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%);
        font-size: 1.3rem; color: #000066; cursor: pointer;"></i>
  </div>
</div>

          <button type="submit" class="btn border-3 rounded-2 w-100 py-2"
            style="background-color: #ffffff; font-weight: bold; border: solid #000066; transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;"
            onmouseover="this.style.backgroundColor='#ffffff'; this.style.color='#000066'; this.style.boxShadow='5px 5px';"
            onmouseout="this.style.backgroundColor='#ffffff'; this.style.color='#000066'; this.style.boxShadow='none'">
            REGISTER
          </button>
        </form>

        <div class="text-center mt-3">
          <small style="color: #464646ff;">Already have an account? <a href="login.php"
              style="color: #000066; font-weight: 600;">Login</a></small>
        </div>
      </div>
    </div>
  </div>

    <script>
       document.getElementById('registerForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (password !== confirmPassword) {
        Swal.fire({
            icon: 'error',
            title: 'Incorrect Password!',
            html: '<p style="color: #868686ff;">Passwords do not match!</p>',
            background: "#000066",
            color: "#ffffff",
            showConfirmButton: true,
            customClass: {
                popup: 'swal-custom-popup',   
                title: 'swal-custom-title',   
                confirmButton: 'swal-custom-button' 
                    }
        });
        return;
    }

    $.ajax({
        url: '../backend/checkregister.php',
        method: 'POST',
        data: {
            name: name,
            email: email,
            password: password,
        },
        success: function (response) {
            if (response.status === 'success') {
                Swal.fire({
                    title: "Registration Successful!",
                    html: `<p style="color: #868686ff;">${response.message}</p>`,
                    //imageUrl: '../../main/images/register_section/jose.png', 
                    //imageWidth: 200, 
                    //imageHeight: 200, 
                    icon: "success",
                    background: "#000066",
                    color: "#ffffff",
                    text: response.message,
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        popup: 'swal-custom-popup',   
                        title: 'swal-custom-title',   
                        confirmButton: 'swal-custom-button' 
                    }
                }).then(() => {
                    window.location.href =  'success.php';
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: response.message,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error:", xhr.responseText);
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong, please try again later.",
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
});

    </script>
    <script>
  function togglePassword(id, icon) {
    const input = document.getElementById(id);
    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove("bi-eye-slash");
      icon.classList.add("bi-eye");
    } else {
      input.type = "password";
      icon.classList.remove("bi-eye");
      icon.classList.add("bi-eye-slash");
    }
  }
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>