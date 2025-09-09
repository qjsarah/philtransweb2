document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(
    '.save-button, .delete-button, .update-button, .add-button, .restore-button'
  ).forEach(button => {
    button.addEventListener('click', function (e) {
      e.preventDefault();
      const form = this.closest('form');

      // Determine the action type
      let action = '';
      if (this.classList.contains('save-button')) action = 'save';
      else if (this.classList.contains('delete-button')) action = 'delete';
      else if (this.classList.contains('update-button')) action = 'update';
      else if (this.classList.contains('add-button')) action = 'add';
      else if (this.classList.contains('restore-button')) action = 'restore';
    
      // Define texts based on action
      let title = 'Are you sure?';
      let text = '';
      let confirmText = '';
      let confirmedText = '';
      let successMsg = '';

      if (action === 'save') {
        text = 'Do you want to save your changes?';
        confirmText = 'Save';
        confirmedText = 'Saved';
        successMsg = 'Your changes have been saved successfully.';
      } else if (action === 'delete') {
        text = 'This item will be deleted!';
        confirmText = 'Delete';
        confirmedText = 'Deleted';
        successMsg = 'Item has been deleted!';
      } else if (action === 'update') {
        text = 'This item will be updated!';
        confirmText = 'Update';
        confirmedText = 'Updated';
        successMsg = 'Item has been updated!';
      } else if (action === 'add') {
        text = 'This item will be added!';
        confirmText = 'Add';
        confirmedText = 'Added';
        successMsg = 'Item has been added!';
      } else if (action === 'restore') {
        text = 'This file will be restored back to the active section!';
        confirmText = 'Restore';
        confirmedText = 'Restored';
        successMsg = 'File has been restored successfully.';
      }

      // Confirmation Swal
      Swal.fire({
        html: `
          <h2 class="swal-custom-title">${title}</h2>
          <p class="swal-custom-text">${text}</p>
        `,
        showCancelButton: true,
        confirmButtonText: confirmText,
        cancelButtonText: 'Cancel',
        background: '#ffffff',
        color: '#000066',
        buttonsStyling: false,
        imageUrl: '/philtrans/philtransweb/public/main/images/archive_section/archivetrycicle.png',
        imageHeight: 200,
        customClass: {
          popup: 'swal-custom-popup',
          confirmButton: 'swal-button-btn ok-btn',
          cancelButton: 'swal-button-btn cancel-btn',
        },
        didOpen: () => {
          const img = Swal.getImage();
          img.style.marginTop = '-110px';
          const separator = document.createElement('div');
          separator.style.height = '3px';
          separator.style.width = '100%';
          separator.style.backgroundColor = '#000066';
          separator.style.borderRadius = '5px';
          Swal.getPopup().insertBefore(separator, Swal.getPopup().querySelector('.swal2-title'));
        }
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            html: `
              <h2 class="swal-custom-title">${confirmedText} Successfully!</h2>
              <p class="swal-custom-text">${successMsg}</p>
            `,
            showConfirmButton: false,
            timer: 1500,
            background: '#ffffff',
            color: '#000066',
            imageUrl: '/philtrans/philtransweb/public/main/images/archive_section/archivetrycicle.png',
            imageHeight: 200,
            customClass: {
              popup: 'swal-custom-popup',
            },
            didOpen: () => {
              const img = Swal.getImage();
              img.style.marginTop = '-110px';
              const separator = document.createElement('div');
              separator.style.height = '3px';
              separator.style.width = '100%';
              separator.style.backgroundColor = '#000066';
              separator.style.borderRadius = '5px';
              Swal.getPopup().insertBefore(separator, Swal.getPopup().querySelector('.swal2-title'));
            }
          }).then(() => {
            if (form) form.submit();
          });
        }
      });
    });
  });
});
