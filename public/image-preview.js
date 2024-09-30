function getImagePreview(uploadedImage, imagePreviewId) {
    const reader = new FileReader();

    reader.onload = function(e) {
        //const imgTag = document.getElementById('image-preview');
        if (imagePreviewId) {
            const previewId = document.getElementById(imagePreviewId);
            previewId.innerHTML = '<img src="' + e.target.result + '" alt="Uploaded image" />';
        }
    }

    if (uploadedImage) {
        reader.readAsDataURL(uploadedImage);
    }
}
