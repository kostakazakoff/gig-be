export function initDragDropImage({
  dropZoneId = 'dropZone',
  inputId = 'imageInput',
  previewId = 'imagePreview',
  textId = 'dropText',
} = {}) {
  const dropZone = document.getElementById(dropZoneId);
  const imageInput = document.getElementById(inputId);
  const imagePreview = document.getElementById(previewId);
  const dropText = document.getElementById(textId);

  if (!dropZone || !imageInput || !imagePreview || !dropText) return;

  const handleImageSelect = () => {
    if (imageInput.files && imageInput.files.length > 0) {
      const reader = new FileReader();
      reader.onload = (e) => {
        imagePreview.src = e.target.result;
        imagePreview.classList.remove('hidden');
        dropText.classList.add('hidden');
      };
      reader.readAsDataURL(imageInput.files[0]);
    }
  };

  dropZone.addEventListener('click', () => imageInput.click());

  dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('border-blue-500');
  });

  dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('border-blue-500');
  });

  dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-blue-500');
    imageInput.files = e.dataTransfer.files;
    handleImageSelect();
  });

  imageInput.addEventListener('change', handleImageSelect);
}
