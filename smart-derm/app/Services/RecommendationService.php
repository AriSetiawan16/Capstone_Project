<?php

namespace App\Services;

class RecommendationService
{
    /**
     * Menyimpan daftar rekomendasi untuk berbagai penyakit kulit.
     * @var array
     */
    private $recommendations = [
        'Atopic Dermatitis' => 'Gunakan pelembap secara rutin, hindari pemicu alergi, dan gunakan krim kortikosteroid sesuai resep.',
        'Basal Cell Carcinoma (BCC)' => 'Segera konsultasikan ke dokter kulit. Penanganan bisa melibatkan operasi kecil atau terapi cahaya.',
        'Benign Keratosis-like Lesions (BKL)' => 'Biasanya tidak berbahaya, namun jika berubah bentuk atau tidak kunjung sembuh, periksakan ke dokter.',
        'Eczema' => 'Gunakan pelembap tanpa parfum, hindari mandi air panas, dan gunakan krim anti-inflamasi jika perlu.',
        'Melanocytic Nevi (NV)' => 'Ini adalah tahi lalat biasa. Awasi perubahan bentuk, ukuran, atau warna dan konsultasikan jika ada yang mencurigakan.',
        'Melanoma' => 'Ini adalah jenis kanker kulit yang berpotensi bahaya. Segera periksakan ke dokter spesialis kulit untuk diagnosis dan tindakan medis secepatnya.',
        'Psoriasis pictures Lichen Planus and related diseases' => 'Gunakan salep kortikosteroid sesuai anjuran dokter, jaga kelembapan kulit dengan baik, dan kelola stres.',
        'Seborrheic Keratoses and other Benign Tumors' => 'Biasanya tidak memerlukan perawatan kecuali jika terasa mengganggu secara kosmetik. Bisa diangkat oleh dokter jika diperlukan.',
        'Tinea Ringworm Candidiasis and other Fungal Infections' => 'Gunakan krim atau salep antijamur, jaga area yang terinfeksi agar tetap bersih dan kering, serta hindari pakaian yang terlalu ketat.',
        'Warts Molluscum and other Viral Infections' => 'Gunakan salep antivirus topikal sesuai resep, dan hindari menyentuh atau menggaruk area kulit yang terinfeksi untuk mencegah penyebaran.',
    ];

    /**
     * Mengambil teks rekomendasi berdasarkan nama penyakit yang dideteksi.
     *
     * @param string $diseaseName Nama penyakit.
     * @return string Teks rekomendasi.
     */
    public function getRecommendation(string $diseaseName): string
    {
        // Mencari rekomendasi yang cocok dari array.
        // Jika tidak ditemukan, berikan pesan default.
        return $this->recommendations[$diseaseName] ?? 'Konsultasikan dengan dokter spesialis kulit untuk diagnosis dan penanganan lebih lanjut.';
    }
}
