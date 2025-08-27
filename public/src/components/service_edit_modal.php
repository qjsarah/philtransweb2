<!-- Card Editing Modal -->
<div class="modal fade" id="editCardModal" tabindex="0" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content" 
         style="backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.57); border-radius: 1rem;">
         
      <form method="POST" action="backend/update_card.php" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-bold fs-4">Manage Service Cards Content</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="editCardId">
          
          <div class="mb-3">
            <label class="form-label fw-bold text-secondary">Card Title:</label>
            <input type="text" name="title" id="editCardTitle" class="form-control border-dark" required>
          </div>
          
          <div class="mb-3">
            <label class="form-label fw-bold text-secondary">Card Content:</label>
            <textarea name="content" id="editCardContent" class="form-control border-dark" rows="3" required></textarea>
          </div>
        </div>
        
        <div class="modal-footer">
         <button type="submit" class="contact_button w-100 px-3 py-2 mt-2 rounded text-dark update-button" style="border-color: black;">Update Card</button>
          <button type="button" class="contact_button w-100 px-3 py-2 mt-2 rounded text-dark" style="border-color: black;" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
      
    </div>
  </div>
</div>