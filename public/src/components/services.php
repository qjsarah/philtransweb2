<?php
include 'backend/config.php'; 

$keys = ['service_title', 'services_bg_color', 'service_text', 'service_image', 'services_desc_color', 'services_title_color', 'card_title_color', 'card_desc_color'];
$placeholders = implode(',', array_fill(0, count($keys), '?'));

$sql = "SELECT key_name, content FROM services WHERE key_name IN ($placeholders)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($keys)), ...$keys);
$stmt->execute();
$result = $stmt->get_result();

$card_query = "SELECT * FROM card_table ORDER BY id DESC";
$card_result = $conn->query($card_query);
$cards = [];

if ($card_result && $card_result->num_rows > 0) {
    while ($row = $card_result->fetch_assoc()) {
        $cards[] = $row;
    }
}

$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}
?>

<style>
    /* Make sure service_edit modal always appears above other modals */
#editCardModal {
  z-index: 1060 !important;
}

#editCardModal .modal-dialog {
  z-index: 1061 !important;
}

</style>

<section class="pt-5" id="services-container" >
    
        <div class="mt-5 position-relative">
            <img src="../../public/main/images/services_section/<?php echo htmlspecialchars($content['service_image'] ?? 'services_image.png'); ?>" 
                 alt="Services Image" 
                 class="service-img img-fluid"  
                 data-aos="fade-right" 
                 data-aos-duration="1500">
            
            <div class="h-auto text-md-end text-center p-5 service " style="background-color: <?php echo htmlspecialchars($content['services_bg_color'] ?? '#000000'); ?>;">

                <h4 class="" data-aos="fade-up" data-aos-duration="1500" style="color: <?php echo htmlspecialchars($content['services_desc_color'] ?? '#FFFFFF'); ?>;">
                    <?php echo htmlspecialchars($content['service_text'] ?? "How it Works"); ?>
                </h4>

                <h4 class="display-4 fw-bold" data-aos="fade-up" data-aos-duration="1500" style="color: <?php echo htmlspecialchars($content['services_title_color'] ?? '#000000'); ?>;">
                    <?php echo htmlspecialchars($content['service_title'] ?? "SERVICES"); ?>
                </h4>
            </div>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Edit Button -->
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center mt-5 mb-5 px-5">
                    <button type="button" class="contact_button w-100 w-sm-50 px-3 py-2 mt-2 rounded text-dark border-dark" data-bs-toggle="modal" data-bs-target=".edit-services-image">
                        Change Image
                    </button>
                    <button type="button" class="contact_button w-100 w-sm-50 px-3 py-2 mt-2 rounded text-dark border-dark" data-bs-toggle="modal" data-bs-target="#editServiceModal">
                        Edit Service header
                    </button>
                </div>
            <?php endif; ?>

            <!-- Logged-in user card display -->
            <div class="container mt-5">
                <?php foreach ($cards as $card): ?>
                    <div class="service-card border border-primary p-5 mb-3 rounded-5 text-primary" 
                        data-aos="fade-right" 
                        data-aos-duration="1500">
                        <h4 class="fw-bold service-head my-auto" style="color: <?php echo htmlspecialchars($content['card_title_color'] ?? '#FFFFFF'); ?>;"><?php echo htmlspecialchars($card['title']); ?></h4>

                        <p class="service-body mt-2" style="color: <?php echo htmlspecialchars($content['card_desc_color'] ?? '#FFFFFF'); ?>;"><?php echo nl2br(htmlspecialchars($card['content'])); ?></p> 
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="text-center">
                    <button type="button" class="contact_button w-50 px-3 py-2 mt-2 rounded text-dark border-dark" data-bs-toggle="modal" data-bs-target="#editServiceCard">
                        Manage Services Cards
                    </button>
                </div>
            <?php endif; ?>

        </div>
</section>
<!-- Image Modal -->
<div class="modal fade edit-services-image" tabindex="-1">
   <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
        <div class="modal-header">
            <h3 class="modal-title fw-bold fs-4">Edit Content</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <hr>
            <form id="all-form" method="POST" action="backend/savecms.php" class="text-center">
                <img src="../main/images/services_section/<?php echo htmlspecialchars($content['service_image'] ?? 'services_image.png')?>" alt="" class="current-cms-img img-fluid w-50 mb-4" data-cms-key="service_image">
                <div class="upload-box uploadBox">
                    <input type="file" class="form-control mb-2 cms-image-input fileInput" data-cms-key="service_image" accept="image/*">
                    <p>Click or drag a file here to upload</p>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>

<!-- Edit Service Modal -->            
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
            <div class="modal-header">
                <h5 class="modal-title fw-bold fs-4">Edit Service Section & Cards</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Edit Service Section -->
                <form method="POST" action="backend/savecms.php" enctype="multipart/form-data" >

                <hr>
                <div style="max-height: calc(100vh - 150px); overflow-y: auto;">

                    <!-- Background color -->
                    <label for="services_bg_color" class="form-label fw-bold text-secondary">Background Color:</label>
                    <div class="d-flex flex-column flex-md-row align-items-center gap-3 mb-2">
                        <!-- Hex Input -->
                        <input type="text"
                            id="services_bg_hex"
                            name="services_bg_color" 
                            class="form-control text-uppercase mb-1 mb-md-0"
                            maxlength="7"
                            style="border-color: black; flex: 0 0 27%;"
                            value="<?php echo htmlspecialchars($content['services_bg_color'] ?? '#1a1a1a'); ?>">

                        <!-- Color Picker -->
                        <input type="color"
                            class="form-control form-control-color w-100 w-md-auto"
                            id="services_bg_color"
                            style="height: 38px; padding: 5px; border-color: black; flex: 1 1 auto;"
                            value="<?php echo htmlspecialchars($content['services_bg_color'] ?? '#1a1a1a'); ?>">
                    </div>

                    <!-- Services title color & text -->
                    <div class="d-flex flex-column flex-md-row align-items-start gap-4 mt-3">
                        <div style="min-width: 200px; width: 100%; max-width: 200px;">
                             <label for="services_desc_color" class="form-label fw-bold text-secondary mt-3">Description Font Color:</label>
                                <input type="text" id="services_desc_hex" class="form-control text-uppercase mb-2" maxlength="10" style="border-color: black; width: 100%;" value="<?php echo htmlspecialchars($content['services_desc_color'] ?? '#1a1a1a'); ?>">
                                <input type="color" class="form-control form-control-color mb-4" id="services_desc_color" name="services_desc_color" style="height: 40px; padding: 5px; border-color: black; width: 100%;" value="<?php echo htmlspecialchars($content['services_desc_color'] ?? '#1a1a1a'); ?>">

                            <label for="services_bg_color_hex" class="form-label fw-bold text-secondary">Services Title Color:</label>
                            <input type="text"
                                id="services_title_hex"
                                class="form-control text-uppercase mb-2"
                                maxlength="10"
                                style="height: 38px; padding: 5px; border-color: black; flex: 1 1 auto;"
                                value="<?php echo htmlspecialchars($content['services_title_color'] ?? '#1a1a1a'); ?>">
                            <input type="color"
                                class="form-control form-control-color w-100 w-md-auto"
                                id="services_title_color"
                                name="services_title_color"
                                style="height: 38px; padding: 5px; border-color: black; flex: 1 1 auto;"
                                value="<?php echo htmlspecialchars($content['services_title_color'] ?? '#1a1a1a'); ?>">
                        </div>


                    <div class="flex-grow-1 w-100">
                        <label class="form-label fw-bold text-secondary mt-3">Services Description:</label>
                        <textarea name="service_text" class="form-control mb-2 border-dark" rows="3"><?php echo htmlspecialchars($content['service_text'] ?? "How it Works"); ?></textarea>
                
                        <label class="form-label fw-bold text-secondary mt-3 mb-0">Services Title:</label>
                        <input type="text" name="service_title" class="form-control border-dark" style="margin-top: 6px;" value="<?php echo htmlspecialchars($content['service_title'] ?? "SERVICES"); ?>">
                    </div>
                    </div>
                    <!-- Card Title Color -->
                    <label for="card_title_color_hex" class="form-label fw-bold text-secondary mb-1 mt-3">Card Title Font Color:</label>
                    <div class="d-flex flex-column flex-md-row align-items-center gap-3 mb-2">
                        <input type="text"
                            id="card_title_hex"
                            name="card_title_color"
                            class="form-control text-uppercase "
                            maxlength="10"
                            style="border-color: black; flex: 0 0 27%;"
                            value="<?php echo htmlspecialchars($content['card_title_color'] ?? '#1a1a1a'); ?>">
                        <input type="color"
                            class="form-control form-control-color"
                            id="card_title_color"
                            name="card_title_color"
                            style="height: 38px; padding: 5px; border-color: black; width: 100%;"
                            value="<?php echo htmlspecialchars($content['card_title_color'] ?? '#1a1a1a'); ?>">
                    </div>

                    <!-- Card Description Color -->
                    <label for="card_desc_color_hex" class="form-label fw-bold text-secondary">Card Description Font Color:</label>
                    <div class="d-flex flex-column flex-md-row align-items-center gap-3 mb">
                        <input type="text"
                            id="card_desc_color_hex"
                            name="card_desc_color"
                            class="form-control text-uppercase"
                            maxlength="10"
                            style="border-color: black; flex: 0 0 27%;"
                            value="<?php echo htmlspecialchars($content['card_desc_color'] ?? '#1a1a1a'); ?>">
                        <input type="color"
                            class="form-control form-control-color"
                            id="card_desc_color"
                            name="card_desc_color"
                            style="height: 38px; padding: 5px; border-color: black; width: 100%;"
                            value="<?php echo htmlspecialchars($content['card_desc_color'] ?? '#1a1a1a'); ?>">
                    </div>
                   <!-- Footer -->
                <div class="modal-footer text-center d-flex flex-column flex-md-row justify-content-center gap-3">
                    <button type="button" class="contact_button px-5 py-2 rounded text-dark save-button w-100 w-md-auto save-button" style="border-color: black;">Save</button>
                    <button type="button" class="contact_button px-5 py-2 rounded text-dark w-100 w-md-auto" style="border-color: black;" data-bs-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Service Card Modal -->      
<div class="modal fade" id="editServiceCard" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 1rem;">
            <div class="modal-header">
                <h5 class="modal-title fw-bold fs-4">Edit Service Section & Cards</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
                <div class="modal-body">
                <div class="text-center">
                        <button id="showAddCardForm" class="services-card w-75 p-3 mx-auto d-block rounded my-3 text-dark fw-bold" style="box-shadow: 0 2px 10px rgba(0, 0, 0, 0.27); transition: transform 0.2s ease, box-shadow 0.2s ease; background: none; border: 2px dashed #aaa;">Add New Card</button>
                    </div>
                <div id="addCardForm" style="display: none;">
                    <hr>
                    <form action="backend/add_card.php" method="POST" class="w-75 mx-auto">

                        <label for="Card Title" class="form-label fw-bold text-secondary ">Card Title:</label>
                        <input type="text" name="title" class="form-control mb-2 border-dark" placeholder="Card Title" required>

                        <label for="Card Description" class="form-label fw-bold text-secondary ">Card Description:</label>
                        <textarea name="content" class="form-control mb-2 border-dark" rows="3" placeholder="Card Description" required></textarea>

                        <button class="contact_button w-25 px-3 py-2 mt-3 rounded text-dark border border-dark d-block mx-auto" type="submit">Add Card</button>
                    </form>
                </div>
                        <?php foreach ($cards as $index => $card): ?>
                                <div class="services-card w-75 p-3 mx-auto d-block rounded my-3 text-dark  "
                            style="box-shadow: 0 2px 10px rgba(0, 0, 0, 0.27); transition: transform 0.2s ease, box-shadow 0.2s ease; background: none; border: none;">
                                <?php echo htmlspecialchars($card['title']); ?>
                                <?php echo nl2br(htmlspecialchars($card['content'])); ?>


<form action="backend/delete_card.php" method="POST" class="delete-form">
    <input type="hidden" name="id" value="<?php echo $card['id']; ?>">
    <div class="d-flex justify-content-center gap-2">
        <!-- Delete Button -->
        <button type="submit" class="contact_button w-25 px-3 py-2 mt-2 rounded text-dark border border-dark">
            Delete
        </button>

        <!-- Edit Button -->
        <button type="button" 
            class="contact_button w-25 px-3 py-2 mt-2 rounded text-dark border border-dark editCardBtn"
            data-id="<?php echo $card['id']; ?>"
            data-title="<?php echo htmlspecialchars($card['title'], ENT_QUOTES); ?>"
            data-content="<?php echo htmlspecialchars($card['content'], ENT_QUOTES); ?>">
            Edit Content
        </button>
    </div>
</form>

                        <?php endforeach; ?>
<?php include 'service_edit_modal.php';?>

            </div>
        </div>
    </div>
</div>





<script>
document.addEventListener("DOMContentLoaded", function () {
    function setupColorSync(hexInputId, pickerId, previewSelector, cssProperty) {
        const hexInput = document.getElementById(hexInputId);
        const picker = document.getElementById(pickerId);
        const previewEl = document.querySelector(previewSelector);

        if (!hexInput || !picker || !previewEl) return;

        // Store original value
        hexInput.dataset.original = hexInput.value;
        picker.dataset.original = picker.value;
        previewEl.dataset.originalStyle = previewEl.style[cssProperty];

        function updatePreview(val) {
            previewEl.style[cssProperty] = val;
        }

        // Picker → Hex
        picker.addEventListener("input", () => {
            hexInput.value = picker.value;
            updatePreview(picker.value);
        });

        // Hex → Picker
        hexInput.addEventListener("input", () => {
            if (/^#([0-9A-F]{3}){1,2}$/i.test(hexInput.value)) {
                picker.value = hexInput.value;
                updatePreview(hexInput.value);
            }
        });
    }

    setupColorSync("services_bg_hex", "services_bg_color", "#services-container .service", "backgroundColor");
    setupColorSync("services_desc_hex", "services_desc_color", "#services-container h4:nth-of-type(1)", "color");
    setupColorSync("services_title_hex", "services_title_color", "#services-container h4:nth-of-type(2)", "color");
    setupColorSync("card_title_hex", "card_title_color", "#services-container .service-card h4", "color");
    setupColorSync("card_desc_hex", "card_desc_color", "#services-container .service-card p", "color");

    const serviceModal = document.getElementById('editServiceModal'); 
    if (serviceModal) { 
        serviceModal.addEventListener('hidden.bs.modal', function () {
            // Reset all inputs
            document.querySelectorAll("#editServiceModal input, #editServiceModal textarea").forEach(input => { 
                if (input.dataset.original !== undefined) { 
                    input.value = input.dataset.original; 
                }
            }); 

            // Reset live previews
            document.querySelectorAll("#services-container .service, #services-container h4, #services-container .service-card h4, #services-container .service-card p").forEach(el => { 
                if (el.dataset.originalStyle !== undefined) { 
                    el.style.color = el.dataset.originalStyle; 
                }
            }); 

            document.querySelectorAll(".service").forEach(el => { 
                if (el.dataset.originalStyle !== undefined) { 
                    el.style.backgroundColor = el.dataset.originalStyle; 
                }
            }); 

            // ✅ Reset Services Description & Title specifically
            const serviceText = document.querySelector("#editServiceModal textarea[name='service_text']");
            const serviceTitle = document.querySelector("#editServiceModal input[name='service_title']");
            if (serviceText) serviceText.value = serviceText.defaultValue;
            if (serviceTitle) serviceTitle.value = serviceTitle.defaultValue;
        });
    }

    const toggleBtn = document.getElementById("showAddCardForm");
    const form = document.getElementById("addCardForm");

    if (toggleBtn && form) {
        toggleBtn.addEventListener("click", function () {
            if (form.style.display === "none" || form.style.display === "") {
                form.style.display = "block";
                toggleBtn.textContent = "Cancel";
                toggleBtn.style.border = "2px dashed #aaa"; 
            } else {
                form.style.display = "none";
                toggleBtn.textContent = "Add New Card";
                toggleBtn.style.border = "2px dashed #aaa"; 
            }
        });

        form.addEventListener("submit", function () {
            form.style.display = "none";
            toggleBtn.textContent = "Add New Card";
            toggleBtn.style.border = "2px dashed #aaa";
        });
    }

    // Edit Card Modal setup
    document.querySelectorAll('.editCardBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('editCardId').value = this.dataset.id;
            document.getElementById('editCardTitle').value = this.dataset.title;
            document.getElementById('editCardContent').value = this.dataset.content;
            new bootstrap.Modal(document.getElementById('editCardModal')).show();
        });
    });
});
</script>



