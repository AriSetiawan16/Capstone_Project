function previewImage(input) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile-display-image').src = e.target.result;
            // Show delete button when new image is selected
            document.getElementById('delete-photo-btn').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

function deletePhoto() {
    if (confirm("Yakin ingin menghapus foto profil?")) {
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        // Show loading state
        const deleteBtn = document.getElementById('delete-photo-btn');
        const originalText = deleteBtn.innerHTML;
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';
        deleteBtn.disabled = true;

        fetch(window.deletePhotoUrl, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Accept": "application/json",
                "Content-Type": "application/json"
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Gagal menghapus foto.");
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update image to default avatar
                document.getElementById('profile-display-image').src = window.defaultAvatar;

                // Hide delete button
                deleteBtn.style.display = 'none';

                // Reset file input
                document.getElementById('profile_photo').value = '';

                alert(data.message);
            } else {
                throw new Error(data.message);
            }
        })
        .catch(error => {
            alert("Terjadi kesalahan saat menghapus foto: " + error.message);
            console.error(error);
        })
        .finally(() => {
            // Reset button state
            deleteBtn.innerHTML = originalText;
            deleteBtn.disabled = false;
        });
    }
}
