<?php
include 'backend/config.php';

// Footer keys
$keys = ['footer_copyright', 'footer_credits', 'footer_bg_color', 'footer_font_color'];
$placeholders = implode(',', array_fill(0, count($keys), '?'));
$sql = "SELECT key_name, content FROM footer WHERE key_name IN ($placeholders)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($keys)), ...$keys);
$stmt->execute();
$result = $stmt->get_result();

$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}
?>
<footer class="text-center footer-section pb-3" 
        style="background-color: <?php echo htmlspecialchars($content['footer_bg_color'] ?? '#BF0D3D'); ?>; 
               color: <?php echo htmlspecialchars($content['footer_font_color'] ?? '#FFFFFF'); ?>;">
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="text-center mb-4">
            <button type="button" class="btn contact_button px-5 py-2 mt-3 border-white rounded text-white w-25 w-md-auto" 
                    onclick="toggleEditAll(this)" 
                    data-modal-target=".footerContent">Edit Footer Content</button>
        </div>
    <?php endif; ?>

    <div class="w-75 d-flex flex-column flex-md-row text-center justify-content-md-between mx-auto">
        <p><?php echo htmlspecialchars($content['footer_copyright'] ?? "© 2025 PhilTransInc. All Rights Reserved"); ?></p>
        <p>
            <?php echo htmlspecialchars($content['footer_credits'] ?? "Designed & Developed By "); ?>
            <a href="https://bb88advertising.com/" target="_blank" 
               style="text-decoration: none; color: inherit;" 
               onmouseover="this.style.color='#a1a1a1ff'" 
               onmouseout="this.style.color='inherit'">
               BB 88 Advertising and Digital Solutions Inc.
            </a>
        </p>
    </div>
</footer>

<!-- Modal -->
<div class="modal fade footerContent" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.95); border-radius: 8px; border: 2px solid black;">
            <div class="modal-header">
                <h3 class="modal-title fw-bold fs-4">Edit Footer Content</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="footer-form" method="POST" action="backend/savecms.php">
                    <hr>
                    <!-- Background Color -->
                    <label class="form-label fw-bold text-secondary">Background Color:</label>

                    <div class="d-flex flex-column flex-md-row align-items-center gap-3 mb-3">
                        <input type="text" id="footer_bg_hex" name="footer_bg_color"  
                               class="form-control text-uppercase mb-1 mb-md-0" maxlength="10"
                               style="border-color: black; flex: 0 0 27%;"
                               value="<?php echo htmlspecialchars($content['footer_bg_color'] ?? '#BF0D3D'); ?>">
                        <input type="color" id="footer_bg_picker" 
                               class="form-control form-control-color w-100 w-md-auto mb-2 mt-2"
                                style="height: 38px; padding: 5px; border-color: black; flex: 1 1 auto;" 
                               value="<?php echo htmlspecialchars($content['footer_bg_color'] ?? '#BF0D3D'); ?>">
                    </div>

                     <div class="d-flex flex-column flex-md-row align-items-start gap-4 mt-3">
                     <div style="min-width: 200px; width: 100%; max-width: 200px;">
                    <!-- Font Color -->
                    <label class="form-label fw-bold text-secondary">Font Color:</label>
                    
                        <input type="text" id="footer_font_hex" name="footer_font_color"  
                               class="form-control text-uppercase mb-4 mb-md-0 border-dark" maxlength="10"
                               value="<?php echo htmlspecialchars($content['footer_font_color'] ?? '#FFFFFF'); ?>">
                        <input type="color" id="footer_font_picker" 
                               class="form-control form-control-color w-100  border-dark w-md-auto mb-2 mt-2"
                               value="<?php echo htmlspecialchars($content['footer_font_color'] ?? '#FFFFFF'); ?>">
                    </div>

                    <!-- Copyright -->
                    <div class="flex-grow-1 w-100">

                        <label class="form-label fw-bold text-secondary">Copyright:</label>
                        <textarea name="footer_copyright" class="form-control mb-3 border-dark" rows="3"><?php echo htmlspecialchars($content['footer_copyright'] ?? "© 2025 PhilTransInc. All Rights Reserved"); ?></textarea>

                        <!-- Credits -->
                        <label class="form-label fw-bold text-secondary">Credits:</label>
                        <textarea name="footer_credits" class="form-control mb-3 border-dark" rows="3"><?php echo htmlspecialchars($content['footer_credits'] ?? "Designed & Developed By BB 88 Advertising and Digital Solutions Inc."); ?></textarea>
                    </div>
                    
                    </div>
                    <!-- Buttons -->
                    <div class="text-center modal-footer d-flex flex-column flex-md-row justify-content-center gap-3">
                        <button type="button" class="btn contact_button px-5 py-2 rounded text-dark border-dark save-button w-100 w-md-auto">Save</button>
                        <button type="button" class="btn contact_button px-5 py-2 rounded text-dark border-dark w-100 w-md-auto" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Sync hex <-> picker inputs
function syncColorInputs(hexId, pickerId) {
  const hexInput = document.getElementById(hexId);
  const picker = document.getElementById(pickerId);
  if (!hexInput || !picker) return;

  // Hex → Picker
  hexInput.addEventListener("input", () => {
    let val = hexInput.value.trim();
    if (!val.startsWith("#")) val = "#" + val;
    if (/^#([0-9A-Fa-f]{6})$/.test(val)) {
      picker.value = val.toUpperCase();
      hexInput.value = val.toUpperCase();
      picker.dispatchEvent(new Event("input")); 
    }
  });

  // Picker → Hex
  picker.addEventListener("input", () => {
    hexInput.value = picker.value.toUpperCase();
  });
}

document.addEventListener("DOMContentLoaded", function() {
  const footer = document.querySelector(".footer-section");
  const footerModal = document.querySelector(".footerContent");
  const bgHex = document.getElementById("footer_bg_hex");
  const bgPicker = document.getElementById("footer_bg_picker");
  const fontHex = document.getElementById("footer_font_hex");
  const fontPicker = document.getElementById("footer_font_picker");

  syncColorInputs("footer_bg_hex", "footer_bg_picker");
  syncColorInputs("footer_font_hex", "footer_font_picker");

  let originalBg = footer.style.backgroundColor;
  let originalFont = footer.style.color;

  // Save current styles when modal opens
  footerModal.addEventListener("show.bs.modal", () => {
    originalBg = footer.style.backgroundColor;
    originalFont = footer.style.color;
  });

  // Reset on close/cancel
  function resetFooter() {
    footer.style.backgroundColor = originalBg;
    setFooterFontColor(originalFont);
  }
  footerModal.addEventListener("hidden.bs.modal", resetFooter);

  // Live preview
  bgPicker.addEventListener("input", () => footer.style.backgroundColor = bgPicker.value);
  fontPicker.addEventListener("input", () => setFooterFontColor(fontPicker.value));

  function setFooterFontColor(color) {
    footer.style.color = color;
    footer.querySelectorAll("p, a, span, h5, h6").forEach(el => el.style.color = color);
  }
});
</script>
