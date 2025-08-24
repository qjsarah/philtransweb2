<!-- Cropper Modal -->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../../../public/main/style/main.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
</head>
<div class="mt-3 container overflow-x-hidden justify-content-center">
  <h1 class="mb-3 fw-bold fs-4">Crop Image</h1>
    <img id="cropperTarget" class="img-fluid" style="max-width:100%; max-height:70vh;">
  <br>
  <div class="d-flex flex-column flex-md-row justify-content-center gap-2 gap-md-3">
    <button onclick="window.history.back()" class="btn contact_button px-4 py-2 rounded text-dark w-100 w-md-auto border-dark">Cancel</button>

    <button onclick="cropAndUpload()" id="cropUploadBtn" class="btn contact_button px-4 py-2 rounded text-dark w-100 w-md-auto border-dark">Crop & Upload</button>
  </div>
</div>
<script src="../../../public/main/scripts/bootstrap.bundle.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="../../main/scripts/adscropper.js"></script>