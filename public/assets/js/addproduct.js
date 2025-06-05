document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.form-tambah-produk');
    const submitBtn = form.querySelector('button[type="submit"]');

    // Create notification container if not exist
    let notification = document.querySelector('.notification');
    if (!notification) {
        notification = document.createElement('div');
        notification.className = 'notification';
        document.body.appendChild(notification);
    }

    function showNotification(message, type = 'success') {
        notification.textContent = message;
        notification.className = 'notification ' + type;
        notification.style.display = 'block';

        setTimeout(() => {
            notification.style.display = 'none';
        }, 3500);
    }

    const successMessage = document.querySelector('#flash-success');
    const errorMessage = document.querySelector('#flash-error');

    const previewContainer = document.getElementById('foto-preview');
    const previewImage = previewContainer ? previewContainer.querySelector('img') : null;

    // Jika sukses dan bukan mode edit, baru reset form
    if (successMessage) {
        showNotification(successMessage.textContent.trim(), 'success');

        const isEditMode = form.action.includes('product/update'); // Cek dari route action
        if (!isEditMode && previewContainer && previewImage) {
            form.reset();
            previewImage.src = '';
            previewContainer.style.display = 'none';
        }
    }

    if (errorMessage) {
        showNotification(errorMessage.textContent.trim(), 'error');
    }

    // Preview gambar saat user pilih file baru
    const fotoInput = document.getElementById('foto');
    if (fotoInput && previewImage) {
        fotoInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewImage.src = '';
                previewContainer.style.display = 'none';
            }
        });
    }
});