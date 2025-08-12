const imageBase64 = sessionStorage.getItem('tempImage');
  const cmsKey = sessionStorage.getItem('cmsKey');
  console.log(cmsKey ?? 'no cmskey');

  const cropSizes = {
    phone_img: { width: 1110, height: 902 },  
    phone2_img: {width: 531, height: 653},
    tricycle_img: {width: 872, height: 649},
    phone3_img: {width: 493, height: 968},
    mission_img: {width: 494, height: 155},
    vision_img: {width: 494, height: 155},

  };
  if (!imageBase64 || !cmsKey || !cropSizes[cmsKey]) {
    alert("Missing image or CMS key.");
    window.location.href = "../index.php";
  }

  const cropSize = cropSizes[cmsKey];
  const cropperTarget = document.getElementById('cropperTarget');
  let cropper;

  cropperTarget.src = imageBase64;

  cropperTarget.onload = () => {
    cropper = new Cropper(cropperTarget, {
      aspectRatio: cropSize.width / cropSize.height,
      viewMode: 1,
      autoCropArea: 1
    });
  };

  function cropAndUpload() {
    const { width, height } = cropSize;
    const canvas = cropper.getCroppedCanvas({ width, height });

    canvas.toBlob(blob => {
      const formData = new FormData();
      formData.append("cms_key", cmsKey);
      formData.append("cms_image", blob, "cropped.png");

      fetch("../backend/savecms.php", {
        method: "POST",
        body: formData
      })
      .then(res => {
        if (res.ok) {
          alert("Upload success!");
          sessionStorage.removeItem("tempImage");
          sessionStorage.removeItem("cmsKey");
          window.history.back();
        } else {
          alert("Upload failed.");
        }
      })
      .catch(err => {
        console.error("Upload error", err);
        alert("Something went wrong.");
      });
    }, "image/png");
  }