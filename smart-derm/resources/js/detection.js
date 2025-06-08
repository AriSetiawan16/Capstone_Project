document.addEventListener('DOMContentLoaded', function () {
    // --- Elemen-elemen ---
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const removeImageBtn = document.getElementById('removeImage');

    const resultContainer = document.getElementById('resultContainer');
    const closeResultBtn = document.getElementById('closeResultBtn');
    const newAnalysisBtn = document.getElementById('newAnalysisBtn');
    const body = document.body;

    // --- Fungsi Bantuan ---
    const openPopup = () => {
        if (!resultContainer) return; // Jika tidak ada elemen, jangan lakukan apa-apa
        body.classList.add('modal-open');
        resultContainer.style.display = 'flex';
        setTimeout(() => {
            resultContainer.classList.add('is-visible');
        }, 10);
    };

    const closePopup = () => {
        if (!resultContainer) return;
        body.classList.remove('modal-open');
        resultContainer.classList.remove('is-visible');
        setTimeout(() => {
            resultContainer.style.display = 'none';
        }, 300); // Disesuaikan dengan durasi transisi CSS
    };

    // --- Logika Utama ---

    // 1. Cek saat halaman dimuat, jika hasil ada, tampilkan pop-up
    if (resultContainer && window.getComputedStyle(resultContainer).display === 'flex') {
        openPopup();
    }

    // 2. Event listener untuk tombol close
    if (closeResultBtn) {
        closeResultBtn.addEventListener('click', closePopup);
    }

    // 3. Event listener untuk tombol Analisis Baru
// KODE BARU (TANPA RELOAD)
if (newAnalysisBtn) {
    newAnalysisBtn.addEventListener('click', function() {
        // 1. Panggil fungsi untuk menutup pop-up secara halus
        closePopup();

        // 2. Reset input file gambar agar formulir bersih
        if (imageInput) {
            imageInput.value = ''; // Menghapus file yang dipilih
        }
        if (previewImg) {
            previewImg.src = ''; // Menghapus sumber gambar preview
        }
        if (imagePreview) {
            imagePreview.style.display = 'none'; // Menyembunyikan area preview
        }

        // Opsional: Anda juga bisa mereset input nama dan usia jika mau
        // const nameInput = document.getElementById('name');
        // const ageInput = document.getElementById('age');
        // if(nameInput) nameInput.value = '';
        // if(ageInput) ageInput.value = '';
    });
}

    // 4. Logika untuk preview gambar
    if (imageInput) {
        imageInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    if (previewImg) previewImg.src = e.target.result;
                    if (imagePreview) imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    if (removeImageBtn) {
        removeImageBtn.addEventListener('click', function () {
            if (imageInput) imageInput.value = '';
            if (previewImg) previewImg.src = '';
            if (imagePreview) imagePreview.style.display = 'none';
        });
    }
});
