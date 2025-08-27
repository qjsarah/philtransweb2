<?php
include 'backend/config.php';

$keys = ['test_text', 'test_title', 'test_img', 'test_paragraph_color', 'test_title_color', 'test_border_color', 'test_quotation_color', 'test_bg_color'];
$placeholders = implode(',', array_fill(0, count($keys), '?'));
$sql = "SELECT key_name, content FROM testimonial WHERE key_name IN ($placeholders)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($keys)), ...$keys);
$stmt->execute();
$result = $stmt->get_result();

$content = [];
while ($row = $result->fetch_assoc()) {
    $content[$row['key_name']] = $row['content'];
}

$testimonial_stmt = $conn->prepare("SELECT * FROM testimonials_table ORDER BY id DESC");
$testimonial_stmt->execute();
$result = $testimonial_stmt->get_result();

$testimonials = [];
while ($row = $result->fetch_assoc()) {
    $testimonials[] = $row;
}

?>
<div class="vh-100" data-aos="fade-right" data-aos-duration="1500">
    <div id="testimonial" class=""></div>
</div>
<script >
    const testimonialDiv = document.getElementById('testimonial');
    testimonialDiv.innerHTML = `
    <section class="pt-5"> 

        <div class="mt-5 position-relative" data-aos="fade-right" data-aos-duration="1500">
        
            <div class="h-auto text-lg-start  testimonial-header p-5" style="background-color:<?php echo htmlspecialchars($content['test_bg_color'] ?? '#1a1a1a'); ?>">
                

                <h4 class="" style="color:<?php echo htmlspecialchars($content['test_paragraph_color'] ?? '#1a1a1a'); ?>" data-aos="fade-right" data-aos-duration="1500"><?php echo htmlspecialchars($content['test_text'] ?? 'What our Client Says'); ?></h4>

                <h4 class="display-4 fw-bold"  style="color:<?php echo htmlspecialchars($content['test_title_color'] ?? '#ffffffff'); ?>" data-aos="fade-right" data-aos-duration="1500"><?php echo htmlspecialchars($content['test_title'] ?? 'TESTIMONIAL'); ?></h4>     
            <div>
            
            <img src="../../public/main/images/testimonial_section/<?php echo htmlspecialchars($content['test_img'] ?? 'testimonial_image.png'); ?>" alt="" class="testimonial-img img-fluid" data-aos="fade-up" data-aos-duration="1000">
        </div>
        
    </section>
    <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="d-flex flex-wrap flex-md-nowrap gap-3 mt-5 pt-1 mx-5">
                    
                    <button type="button" class="btn  contact_button px-5 py-2 rounded text-dark w-100 w-md-25 border-dark " onclick="toggleEditAll(this)" data-modal-target=".testimonialContent">Edit Testimonial Header</button>
            
                    <button type="button" class="btn  contact_button px-5 py-2 rounded text-dark w-100 w-md-25 border-dark" onclick="toggleEditAll(this)" data-modal-target=".edit-testimonial-image">Edit Image</button>
                    </div>
                <?php endif; ?>
    <div class="mt-5">
        <div class="cardtest owl-carousel owl-theme justify-content-center mt-5 my-auto container">
        <?php foreach ($testimonials as $index => $test): ?>
            <div class="item text-center p-4 d-flex flex-column mt-5">
                <div class="img-area bg-light">
                    <p class="fw-bolder display-1 my-auto" style="color:<?php echo htmlspecialchars($content['test_quotation_color'] ?? '#1a1a1a'); ?>">"</p>
                </div>
                <p class="mb-3" >"<?php echo htmlspecialchars($test['test_content']); ?>"</p>
                
                <div class="text-warning">
                    <?php
                        $stars = (int) $test['stars'];
                        echo str_repeat('★', $stars) . str_repeat('☆', 5 - $stars);
                    ?>
                </div><br>

                <div>
                    <strong><?php echo htmlspecialchars($test['test_name']); ?></strong><br>
                    <small class="text-muted"><?php echo htmlspecialchars($test['roles']); ?></small><br>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>

     <?php if (isset($_SESSION['user_id'])): ?>
        <div class="text-center mt-5">
        <button type="button" class=" btn contact_button px-5 py-2 rounded text-dark border-dark w-50" onclick="toggleEditAll(this)" data-modal-target=".testimonialCardContent">Edit Testimonial Cards</button>
    <?php endif;?>
    <section id="modal-section"></section>
        `;
    // Image modal
    const modalSection = document.getElementById('modal-section');
    modalSection.innerHTML = `
    <div class="modal fade edit-testimonial-image" tabindex="-1">
         <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
            <div class="modal-header">
                <h3 class="modal-title fw-bold fs-4">Edit Testimonial Image</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="all-form" method="POST" action="backend/savecms.php" class="text-center">
                    <img src="../main/images/testimonial_section/<?php echo htmlspecialchars($content['test_img'] ?? 'testimonial_image.png')?>" alt="" class="current-cms-img img-fluid w-50 mb-4" data-cms-key="test_img">
                    <div class="upload-box uploadBox">
                        <input type="file" class="form-control mb-2 cms-image-input fileInput" data-cms-key="test_img" accept="image/*">
                        <p>Click or drag a file here to upload</p>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>


    <div class="modal fade testimonialContent">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
                <div class="modal-header">
                    <h3 class="modal-title fw-bold fs-4">Testimonial Header Content</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <hr >
                    <form action="backend/savecms.php" method="POST" enctype="multipart/form-data" class="form">

                    <!-- Background color -->
                    <label for="services_bg_color" class="form-label fw-bold text-secondary">Background Color:</label>
                    <div class="d-flex flex-column flex-md-row align-items-center gap-3 mb-2">
                        <input type="text"
                            id="test_bg_hex"
                            class="form-control text-uppercase mb-1 mb-md-0"
                            maxlength="10"
                            style="border-color: black; flex: 0 0 27%;"
                            value="<?php echo htmlspecialchars($content['test_bg_color'] ?? '#1a1a1a'); ?>">
                        <input type="color"
                            class="form-control form-control-color w-100 w-md-auto"
                            id="test_bg_color"
                            name="test_bg_color"
                            style="height: 38px; padding: 5px; border-color: black; flex: 1 1 auto;"
                            value="<?php echo htmlspecialchars($content['test_bg_color'] ?? '#1a1a1a'); ?>">
                    </div>
                    <div class="d-flex flex-column flex-md-row align-items-start gap-4">
                        <div style="min-width: 200px; width: 100%; max-width: 200px;">
                            <!-- Paragraph Color -->
                            <label class="form-label fw-bold text-secondary mb-3">Paragraph Font Color:</label>
                            <input type="text" id="test_paragraph_hex" 
                                class="form-control text-uppercase mb-2" 
                                maxlength="7" style="border-color: black;" 
                                value="<?= htmlspecialchars($content['test_paragraph_color'] ?? '#1a1a1a'); ?>">

                            <input type="color" id="test_paragraph_color" 
                                class="form-control form-control-color mb-4" 
                                style="height: 64px; border-color: black; width: 100%;" 
                                value="<?= htmlspecialchars($content['test_paragraph_color'] ?? '#1a1a1a'); ?>">

                            <input type="hidden" name="test_paragraph_color" id="test_paragraph_hidden"
                                value="<?= htmlspecialchars($content['test_paragraph_color'] ?? '#1a1a1a'); ?>">
                            <!-- Title Font Color -->
                            <label class="form-label fw-bold text-secondary">Title Font Color:</label>
                            <input type="text" id="test_title_hex" 
                                class="form-control text-uppercase mb-2" 
                                maxlength="7" style="border-color: black;" 
                                value="<?= htmlspecialchars($content['test_title_color'] ?? '#1a1a1a'); ?>">

                            <input type="color" id="test_title_color" 
                                class="form-control form-control-color mb-5" 
                                style="height: 40px; border-color: black; width: 100%;" 
                                value="<?= htmlspecialchars($content['test_title_color'] ?? '#1a1a1a'); ?>">

                            <input type="hidden" name="test_title_color" id="test_title_hidden"
                                value="<?= htmlspecialchars($content['test_title_color'] ?? '#1a1a1a'); ?>">
                                                        </div>

                        <div class="flex-grow-1 w-100 ">
                         <label class="form-label fw-bold text-secondary mb-3">Testimonials Paragraph:</label>
                            <textarea name="test_text" id="test_text" class="form-control mb-4 border-dark" rows="4"><?php echo htmlspecialchars($content['test_text'] ?? "What our Client Says"); ?></textarea>

                            <label class="form-label fw-bold text-secondary">Testimonials Title:</label>
                            <textarea name="test_title" id="test_title" class="form-control border-dark" rows="3"><?php echo htmlspecialchars($content['test_title'] ?? "Testimonial"); ?></textarea>
                        </div>

                        </div>

                        <label class="form-label fw-bold text-secondary">Testimonials Border Color:</label>
                        <div class="d-flex flex-column flex-md-row align-items-center gap-3 mb-2">
                            <input type="text" id="test_border_hex" 
                                class="form-control text-uppercase" 
                                maxlength="7" style="border-color: black; flex: 0 0 27%;" 
                                value="<?= htmlspecialchars($content['test_border_color'] ?? '#1a1a1a'); ?>">

                            <input type="color" id="test_border_color" 
                                class="form-control form-control-color" 
                                style="height: 38px; border-color: black; width: 100%;" 
                                value="<?= htmlspecialchars($content['test_border_color'] ?? '#1a1a1a'); ?>">

                            <input type="hidden" name="test_border_color" id="test_border_hidden"
                                value="<?= htmlspecialchars($content['test_border_color'] ?? '#1a1a1a'); ?>">
                        </div>



                        <!-- Testimonials Quotation Color -->
                        <label class="form-label fw-bold text-secondary mt-2">Testimonials Quotation Font Color:</label>
                        <div class="d-flex flex-column flex-md-row align-items-center gap-3 mb-2">
                            <input type="text" id="test_quotation_hex" 
                                class="form-control text-uppercase" 
                                maxlength="7" style="border-color: black; flex: 0 0 27%;" 
                                value="<?= htmlspecialchars($content['test_quotation_color'] ?? '#1a1a1a'); ?>">

                            <input type="color" id="test_quotation_color" 
                                class="form-control form-control-color" 
                                style="height: 38px; border-color: black; width: 100%;" 
                                value="<?= htmlspecialchars($content['test_quotation_color'] ?? '#1a1a1a'); ?>">

                            <input type="hidden" name="test_quotation_color" id="test_quotation_hidden"
                                value="<?= htmlspecialchars($content['test_quotation_color'] ?? '#1a1a1a'); ?>">
                        </div>
                            

                        <div class="text-center modal-footer d-flex flex-column flex-md-row justify-content-center gap-3">
                                <button type="button" class="contact_button px-5 py-2 rounded text-dark save-button w-100 w-md-auto" style="border-color: black;">Save</button>
                                <button type="button" class="contact_button px-5 py-2 rounded text-dark w-100 w-md-auto" style="border-color: black;" data-bs-dismiss="modal">Cancel</button>
                            </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade testimonialCardContent">
     <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="backdrop-filter: blur(10px); background-color: rgba(255,255,255,0.85); border-radius: 8px; border: 2px solid black;">
                <div class="modal-header">
                    <h3 class="modal-title fw-bold fs-4">Edit Testimonial Cards</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                
                    <div class="text-center w-100">

                        <button id="showAddTestimonialForm" class="btn services-card w-100 p-3 mx-auto d-block rounded my-3 text-dark fw-bold" style="box-shadow: 0 2px 10px rgba(0, 0, 0, 0.27); transition: transform 0.2s ease, box-shadow 0.2s ease; background: none; border: 2px dashed #aaa;">
                            Add New Card
                        </button>
                    </div>
                    <hr>
                    <div id="addTestimonialForm" class="mb-5" style="display: none;">
                        <h5 class="text-center mb-3">Add new testimonial</h5>

                <?php include 'testimonials_edit_modal.php'; ?>

                        <form action="backend/add_testimonial.php" method="POST" class="w-75 mx-auto">

                            <label class="form-label fw-bold text-secondary mt-2">Testimonial Content:</label>
                            <textarea name="test_content" class="form-control mb-2 border-dark" rows="3" placeholder="Testimonial Content" required></textarea>

                            <label class="form-label fw-bold text-secondary mt-2">Testimonial Name:</label>
                            <input type="text" name="test_name" class="form-control mb-2 border-dark" placeholder="Name" required>

                            <label class="form-label fw-bold text-secondary mt-2">Testimonial Role:</label>
                            <select name="roles" class="form-control mb-2" style="border-color: black;" required>
                                <option value="">-- Select Role --</option>
                                <option value="Driver">Driver</option>
                                <option value="User">User</option>
                            </select>

                            <label class="form-label fw-bold text-secondary mt-2">Testimonial Rating:</label>
                            <input type="number" max="5" class="form-control mb-2 border-dark" name="stars" placeholder="5">
                            <br>
                            
                            <button class="btn contact_button px-5 py-2 rounded text-dark w-100 w-md-auto mt-3 border-dark add-button" type="submit">Add Testimonial</button>
                        </form>
                    </div>
                
                     <div class="container">
  <div class="row g-4 justify-content-center">
    <?php foreach ($testimonials as $test): ?>
      <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="border border-dark text-center p-4 h-100 rounded" style="border-radius: 8px; display: flex; flex-direction: column; justify-content: space-between;">
          
          <!-- Testimonial Content -->
          <p class="fst-italic mb-3" style="max-height: auto; overflow: hidden; text-overflow: ellipsis; word-wrap: break-word;">
            "<?php echo htmlspecialchars($test['test_content']); ?>"
          </p>

          <!-- Stars -->
          <p class="text-warning fs-5 mb-2">
            <?php echo str_repeat('★', (int)$test['stars']) . str_repeat('☆', 5 - (int)$test['stars']); ?>
          </p>

          <!-- Name + Role -->
          <p class="fw-bold mb-0"  style="max-height: auto; overflow: hidden; text-overflow: ellipsis; word-wrap: break-word;"><?php echo htmlspecialchars($test['test_name']); ?></p>
          <p class="text-muted small mb-3"><?php echo htmlspecialchars($test['roles']); ?></p>

          <!-- Buttons -->
          <button class="contact_button px-4 py-2 rounded text-dark w-100 mb-2 edit-btn-testimonial" style="border-color: black;"
              data-id="<?php echo $test['id']; ?>"
              data-content="<?php echo htmlspecialchars($test['test_content'], ENT_QUOTES); ?>"
              data-name="<?php echo htmlspecialchars($test['test_name'], ENT_QUOTES); ?>"
              data-role="<?php echo htmlspecialchars($test['roles'], ENT_QUOTES); ?>"
              data-stars="<?php echo htmlspecialchars($test['stars'], ENT_QUOTES); ?>">
            Edit
          </button>

          <form action="backend/delete_testimonial.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $test['id']; ?>">
            <button type="button" class="contact_button px-4 py-2 rounded text-dark w-100 delete-button" style="border-color: black;">
              Delete
            </button>
          </form>

        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>   
                </div>
            </div>
        </div>
    </div>
    `;
$(document).ready(function () {
    // ====== Carousel Initialization ======
    let borderColor = $("#test_border_color").val() || "#ffffffff";

    $('.owl-carousel').owlCarousel({
        rtl: false,
        loop: true,
        margin: 50,
        center: true,
        autoplay: true,
        autoplayTimeout: 1500,
        autoplayHoverPause: true,
        responsive: {
            0: { items: 1 },
            600: { items: 2 },
            960: { items: 3 }
        }
    });

    function updateCarouselBorder() {
        $(".owl-carousel").find(".owl-item").css({
            "border": "5px solid transparent",
            "box-shadow": `0 4px 10px ${borderColor}`,
            "transform": "scale(1)",
            "transition": "none"
        });
        void $(".owl-carousel")[0].offsetWidth; // Force reflow
        $(".owl-carousel").find(".owl-item.center").css({
            "border-width": "20px",
            "border-color": borderColor,
            "box-shadow": `0 4px 20px ${borderColor}`,
            "transform": "scale(1.05)",
            "transition": "border-width 0.3s ease, border-color 0.3s ease, transform 0.2s ease"
        });
    }

    $(".owl-carousel").on("translated.owl.carousel", updateCarouselBorder);
    updateCarouselBorder(); // Initial call

    // ====== Add Testimonial Form Toggle ======
    const showAddBtn = $('#showAddTestimonialForm');
    showAddBtn.on('click', function () {
        const addForm = $('#addTestimonialForm');
        if (!addForm.length) return;
        if (addForm.is(':hidden')) {
            addForm.show();
            $(this).text('Cancel');
        } else {
            addForm.hide();
            $(this).text('Add New Card');
        }
    });

    // ====== Edit Testimonial Button ======
    $('.edit-btn-testimonial').each(function () {
        $(this).on('click', function () {
            const btn = $(this);
            const originalValues = {
                text: $('#test_text').val(),
                title: $('#test_title').val(),
                paragraphColor: $('#test_paragraph_color').val(),
                titleColor: $('#test_title_color').val(),
                borderColor: $('#test_border_color').val(),
                bgColor: $('#test_bg_color').val()
            };
            $('#editTestimonial').data('original', originalValues);

            $('#edit-id-testimonial').val(btn.data('id'));
            $('#edit-content-testimonial').val(btn.data('content'));
            $('#edit-name').val(btn.data('name'));
            $('#edit-roles').val(btn.data('role'));
            $('#edit-rating').val(btn.data('stars'));

            new bootstrap.Modal(document.getElementById('editTestimonial')).show();
        });
    });

    // ====== Reset Add Form on Modal Close ======
    $('#testimonialManageModal').on('hidden.bs.modal', function () {
        const addFormWrapper = $('#addTestimonialForm');
        const form = addFormWrapper.find('form');
        form.trigger('reset');
        addFormWrapper.hide();
        showAddBtn.text('Add New Card');
    });

    // ====== Delete Confirmation ======
    $('.delete-testimonial-btn').on('click', function () {
        const form = $(this).closest('form');
        Swal.fire({
            title: 'Are you sure?',
            text: 'This testimonial will be deleted permanently!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });

    // ====== Reset all forms inside modals ======
    $('.modal').on('hidden.bs.modal', function () {
        const forms = $(this).find('form');
        forms.trigger('reset');

        if ($(this).attr('id') === 'editTestimonial') {
            const original = $(this).data('original');
            if (original) {
                $('#test_text').val(original.text);
                $('#test_title').val(original.title);
                $('#test_paragraph_color').val(original.paragraphColor);
                $('#test_title_color').val(original.titleColor);
                $('#test_border_color').val(original.borderColor);
                $('#test_bg_color').val(original.bgColor);
                borderColor = original.borderColor;
                updateTestimonialPreview();
                updateCarouselBorder();
            }
        }
    });

    // ====== HEX <-> COLOR SYNC (6 or 8 digits) with live preview ======
    function syncColorInputs(hexId, colorId, hiddenId, targetElement, cssProperty, extraCallback) {
        const hexInput = document.getElementById(hexId);
        const colorInput = document.getElementById(colorId);
        const hiddenInput = document.getElementById(hiddenId);
        const targetEl = targetElement ? document.querySelector(targetElement) : null;

        if (!hexInput || !colorInput || !hiddenInput) return;

        function applyColor(val) {
            hiddenInput.value = val;
            if (targetEl && cssProperty) {
                targetEl.style[cssProperty] = val;
            }
            if (extraCallback) extraCallback(val);
        }

        hexInput.addEventListener('input', () => {
            let val = hexInput.value.trim();
            if (!val.startsWith('#')) val = '#' + val;
            if (/^#[0-9A-Fa-f]{6}([0-9A-Fa-f]{2})?$/.test(val)) { // 6 or 8 digits
                colorInput.value = val;
                applyColor(val);
            }
        });

        colorInput.addEventListener('input', () => {
            const val = colorInput.value;
            hexInput.value = val.toUpperCase();
            applyColor(val);
        });
    }

    // Paragraph, title, border, quotation, background (header div)
    syncColorInputs("test_paragraph_hex", "test_paragraph_color", "test_paragraph_hidden", null, null, updateTestimonialPreview);
    syncColorInputs("test_title_hex", "test_title_color", "test_title_hidden", null, null, updateTestimonialPreview);
    syncColorInputs("test_border_hex", "test_border_color", "test_border_hidden", null, null, (val) => {
        borderColor = val;
        updateCarouselBorder();
    });
    syncColorInputs("test_quotation_hex", "test_quotation_color", "test_quotation_hidden");
    syncColorInputs("test_bg_hex", "test_bg_color", "test_bg_hidden", "#testimonial .testimonial-header", "backgroundColor");

    // ====== Live Preview for Header & Paragraph ======
    const testTextInput = document.getElementById('test_text');
    const testTitleInput = document.getElementById('test_title');

    function updateTestimonialPreview() {
        const headerDiv = document.querySelector('#testimonial .testimonial-header'); // whole header
        if (headerDiv) {
            headerDiv.style.backgroundColor = document.getElementById('test_bg_color').value;
        }

        const paragraphEl = document.querySelector('#testimonial h4:not(.display-4)');
        const titleEl = document.querySelector('#testimonial h4.display-4');
        if (paragraphEl) paragraphEl.style.color = document.getElementById('test_paragraph_color').value;
        if (titleEl) titleEl.style.color = document.getElementById('test_title_color').value;
    }

    testTextInput.addEventListener('input', updateTestimonialPreview);
    testTitleInput.addEventListener('input', updateTestimonialPreview);
    document.getElementById('test_bg_color').addEventListener('input', updateTestimonialPreview);

    updateTestimonialPreview(); // Initial call
});

// ====== Store original testimonial header & paragraph before editing ======
$('.btn[data-modal-target=".testimonialContent"]').on('click', function () {
    const testimonialDiv = document.getElementById('testimonial');
    const paragraphEl = testimonialDiv.querySelector('h4:not(.display-4)');
    const titleEl = testimonialDiv.querySelector('h4.display-4');

    const modal = document.querySelector('.testimonialContent');
    modal.dataset.originalText = paragraphEl.textContent;
    modal.dataset.originalTitle = titleEl.textContent;
    modal.dataset.originalParagraphColor = paragraphEl.style.color;
    modal.dataset.originalTitleColor = titleEl.style.color;
    modal.dataset.originalBgColor = document.querySelector('#testimonial .testimonial-header').style.backgroundColor; // whole header
});

// ====== Reset testimonial header & paragraph if modal is closed without saving ======
$('.testimonialContent').on('hidden.bs.modal', function () {
    const paragraphEl = document.querySelector('#testimonial h4:not(.display-4)');
    const titleEl = document.querySelector('#testimonial h4.display-4');
    const headerDiv = document.querySelector('#testimonial .testimonial-header');

    if (!paragraphEl || !titleEl || !headerDiv) return;

    paragraphEl.textContent = this.dataset.originalText;
    titleEl.textContent = this.dataset.originalTitle;
    paragraphEl.style.color = this.dataset.originalParagraphColor;
    titleEl.style.color = this.dataset.originalTitleColor;
    headerDiv.style.backgroundColor = this.dataset.originalBgColor; // whole header
});

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
