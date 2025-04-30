document.addEventListener('DOMContentLoaded', function () {
    // Configuración de Dropzone para el banner
    // Configuración de Dropzone para el banner
    const bannerDropzone = new Dropzone('#banner-dropzone', {
        url: '/fake-url',
        autoProcessQueue: false,
        uploadMultiple: false,
        maxFiles: 1,
        acceptedFiles: 'image/*',
        init: function () {
            this.on('addedfile', function (file) {
                if (this.files.length > 1) {
                    this.removeFile(this.files[0]);
                }
                const fileInput = document.getElementById('banner_image');
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;
            });
        }
    });

    // Configuración de Dropzone para la galería
    const galleryDropzone = new Dropzone('#gallery-dropzone', {
        url: '/fake-url',
        autoProcessQueue: false,
        uploadMultiple: true,
        acceptedFiles: 'image/*',
        init: function () {
            this.on('addedfile', function (file) {
                const fileInput = document.getElementById('gallery_images');
                const dataTransfer = new DataTransfer();

                // Agregar archivos existentes
                if (fileInput.files) {
                    for (let i = 0; i < fileInput.files.length; i++) {
                        dataTransfer.items.add(fileInput.files[i]);
                    }
                }

                // Agregar nuevo archivo
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;

                // Mostrar vista previa
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.getElementById('gallery-preview');
                    preview.innerHTML += `
                        <div class="relative">
                            <img src="${e.target.result}" class="w-full h-32 object-cover rounded">
                            <button type="button" class="absolute top-0 right-0 bg-red-500 text-white p-1" 
                                    onclick="removeGalleryImage(this, 'new')">×</button>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            });
        }
    });

    window.removeGalleryImage = function (button, imageId) {
        if (imageId === 'new') {
            // Eliminar imagen nueva (solo del DOM)
            button.closest('div').remove();
            return;
        }

        if (confirm('¿Estás seguro de eliminar esta imagen?')) {
            fetch(`/admin/gallery-images/${imageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            }).then(response => {
                if (response.ok) {
                    button.closest('div').remove();
                }
            });
        }
    };

    // Inicializar el editor si está disponible
    hugerte.init({
        selector: '#description',
        height: 300,
        // menubar: false,
        // toolbar: 'bold italic underline strike link image list',
        plugins: 'emoticons',
        entity_encoding: "raw",
        content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }',
        setup: function (editor) {
            editor.on('init change', function () {
                editor.save();
            });
        }
    });
});