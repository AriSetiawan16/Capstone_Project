function previewImage(input) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile-display-image').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}


    function deletePhoto() {
        if (confirm("Yakin ingin menghapus foto profil?")) {
            fetch("{{ route('profile.delete-photo') }}", {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').getAttribute("content"),
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
                alert(data.message);
                location.reload(); // reload agar foto preview hilang
            })
            .catch(error => {
                alert("Terjadi kesalahan saat menghapus foto.");
                console.error(error);
            });
        }
    }
