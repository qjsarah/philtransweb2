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
    <?php if (isset($_SESSION['user_id'])): ?>
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

            <!-- Edit Button -->
            <div class="position-absolute top-0 end-0 m-3">
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editServiceModal">
                    Edit
                </button>
            </div>
        </div>

        <!-- Modal -->
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
                            <div class="mb-3">
                                <label class="form-label">Service Image</label>
                                <input type="file" name="service_image" class="form-control" accept="image/*">
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success">Save Section</button>
                            </div>
                        </form>

                        <hr>

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
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this card?');">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <!-- Add New Card -->
                        <h6>Add New Card</h6>
                        <form method="POST" action="backend/add_card.php">
                            <div class="mb-3">
                                <input type="text" name="title" class="form-control" placeholder="Card Title" required>
                            </div>
                            <div class="mb-3">
                                <textarea name="content" class="form-control" placeholder="Card Content" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Card</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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

    <?php else: ?>
        <!-- Guest card display -->
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
        </div>
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
    <?php endif; ?>
</section>

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
</script>
