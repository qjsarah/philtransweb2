<?php
include 'backend/config.php'; 

$keys = ['service_title', 'services_bgcolor', 'service_text', 'service_image'];
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

<section class="pt-5" id="services-container">
        <div class="mt-5 position-relative">
            <img src="../../public/main/images/services_section/<?php echo htmlspecialchars($content['service_image'] ?? 'services_image.png'); ?>" 
                 alt="Services Image" 
                 class="service-img img-fluid"  
                 data-aos="fade-right" 
                 data-aos-duration="1500">
            
            <div class="bg-primary h-auto text-md-end text-center p-5 service">
                <h4 class="text-light" data-aos="fade-up" data-aos-duration="1500">
                    <?php echo htmlspecialchars($content['service_text'] ?? "How it Works"); ?>
                </h4>
                <h4 class="text-warning display-4 fw-bold" data-aos="fade-up" data-aos-duration="1500">
                    <?php echo htmlspecialchars($content['service_title'] ?? "SERVICES"); ?>
                </h4>
            </div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Edit Button -->
                <div class="position-absolute top-0 end-0 m-3">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editServiceModal">
                        Edit Service header
                    </button>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editServiceCard">
                        Edit Service Cards
                    </button>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target=".edit-services-image">
                        Edit Image
                    </button>
                </div>
            <?php endif; ?>
            <!-- Logged-in user card display -->
            <div class="container mt-5">
                <?php foreach ($cards as $card): ?>
                    <div class="service-card border border-primary p-5 mb-3 rounded-5 text-primary" 
                        data-aos="fade-right" 
                        data-aos-duration="1500">
                        <h4 class="fw-bold service-head my-auto"><?php echo htmlspecialchars($card['title']); ?></h4>
                        <p class="service-body mt-2"><?php echo nl2br(htmlspecialchars($card['content'])); ?></p> 
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
</section>
<!-- Modal -->
<div class="modal fade edit-services-image" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Edit Content</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="all-form" method="POST" action="backend/savecms.php" class="text-center">
                <img src="../main/images/services_section/<?php echo htmlspecialchars($content['service_image'] ?? 'services_image.png')?>" alt="" class="current-cms-img img-fluid w-50" data-cms-key="service_image">
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
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Service Section & Cards</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Edit Service Section -->
                <form method="POST" action="backend/savecms.php" enctype="multipart/form-data" class="mb-4">
                    <div class="mb-3">
                        <label class="form-label">Service Text</label>
                        <textarea name="service_text" class="form-control" rows="2"><?php echo htmlspecialchars($content['service_text'] ?? "How it Works"); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Service Title</label>
                        <input type="text" name="service_title" class="form-control" value="<?php echo htmlspecialchars($content['service_title'] ?? "SERVICES"); ?>">
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-success save-button">Save Section</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Service  Card Modal -->      
<div class="modal fade" id="editServiceCard" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Service Section & Cards</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Cards CRUD -->
                <h5 class="mb-3">Manage Service Cards</h5>
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cards as $index => $card): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($card['title']); ?></td>
                                <td><?php echo nl2br(htmlspecialchars($card['content'])); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-warning editCardBtn" 
                                        data-id="<?php echo $card['id']; ?>"
                                        data-title="<?php echo htmlspecialchars($card['title']); ?>"
                                        data-content="<?php echo htmlspecialchars($card['content']); ?>">
                                        Edit
                                    </button>
                                    <form method="POST" action="backend/delete_card.php" class="d-inline">
                                        <input type="hidden" name="id" value="<?php echo $card['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <div class="text-center">
                    <button id="showAddCardForm" class="btn btn-success">
                        Add New Card
                    </button>
                </div>
                <div id="addCardForm" style="display: none;">
                    <hr>
                    <h5>Add New Card</h5>
                    <form action="backend/add_card.php" method="POST">
                        <input type="text" name="title" class="form-control mb-2" placeholder="Card Title" required>
                        <textarea name="content" class="form-control mb-2" rows="3" placeholder="Card Description" required></textarea>
                        <button class="btn btn-primary" type="submit">Add Card</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Card Editing Modal -->
<div class="modal fade" id="editCardModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="backend/update_card.php" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="editCardId">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" id="editCardTitle" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" id="editCardContent" class="form-control" rows="3" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Save Changes</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelectorAll('.editCardBtn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('editCardId').value = this.dataset.id;
        document.getElementById('editCardTitle').value = this.dataset.title;
        document.getElementById('editCardContent').value = this.dataset.content;
        new bootstrap.Modal(document.getElementById('editCardModal')).show();
    });
});
document.getElementById('showAddCardForm').addEventListener('click', function () {
    const form = document.getElementById('addCardForm');
    form.style.display = (form.style.display === 'none') ? 'block' : 'none';
});
</script>
