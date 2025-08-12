function toggleEditAll(button) {
  const targetSelector = button.getAttribute('data-modal-target');
  const modalElement = document.querySelector(targetSelector);

  if (!modalElement) {
    console.error('Modal not found:', targetSelector);
    return;
  }

  const modalInstance = new bootstrap.Modal(modalElement);
  modalInstance.show();
}

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