<link rel="stylesheet" href="../../../main/style/main.css">
<?php
include __DIR__ . '/../../backend/config.php';

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);

    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    if (!$stmt) {
        die("Delete SQL Error: " . $conn->error);
    }

    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch all messages
$stmt = $conn->prepare("SELECT id, name, email, message FROM messages ORDER BY id DESC");
if (!$stmt) {
    die("Fetch SQL Error: " . $conn->error);
}
$stmt->execute();
$result = $stmt->get_result();
?>
    <div class="container">
        <h1 class="my-3 text-primary">Messages Management</h1>
    <div class="table-responsive-sm rounded-3 overflow-hidden border shadow">
        <table class="table table-hover rounded-5">
            <thead class="table-primary">   
                <tr>
                    <th width="50" class="text-light py-3">ID</th>
                    <th width="150" class="py-3 text-primary">Name</th>
                    <th width="200" class="py-3 text-primary">Email</th>
                    <th class="py-3 text-primary">Message</th>
                    <th width="120" class="py-3 text-center text-primary">Action</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="text-primary"><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td style="max-width: 400px; white-space: pre-wrap;" class="w-auto"><?php echo htmlspecialchars($row['message']); ?></td>
                            <td class="text-center">
                                <form method="POST" class="my-auto">
                                    <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                <button class="btn"><img src="../../../main/images/trash.svg" alt="" class="delete-button img-fluid mx-auto"></button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-primary">No messages found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    </div>
<script src="../../../main/scripts/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
<script>
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
      text = 'This file will be restored back to active section!';
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
      imageUrl: '../../../main/images/index_section/indextrycicle.png',
      imageHeight: 200,
      customClass: {
        popup: 'swal-custom-popup',
        title: 'swal-custom-title',
        content: 'swal-custom-text',
        confirmButton: 'swal-button-btn ok-btn',
        cancelButton: 'swal-button-btn cancel-btn',
      },
      didOpen: () => {
        const img = Swal.getImage();
        img.style.marginTop = '-110px';
        const separator = document.createElement('div');
        separator.style.height = '4px';
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
          imageUrl: '../../../main/images/index_section/indextrycicle.png',
          imageHeight: 200,
          customClass: {
            popup: 'swal-custom-popup',
            title: 'swal-custom-title',
            content: 'swal-custom-text',
          },
          didOpen: () => {
            const img = Swal.getImage();
            img.style.marginTop = '-110px';
            const separator = document.createElement('div');
            separator.style.height = '4px';
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

</script>