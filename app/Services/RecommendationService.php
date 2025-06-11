<?php

namespace App\Services;

class RecommendationService
{
    /**
     * Menyimpan data detail (deskripsi dan rekomendasi) untuk penyakit kulit.
     * "Ringkasan:" telah dihapus dari semua deskripsi untuk tampilan yang lebih bersih.
     * @var array
     */
    private $diseaseData = [
        'Atopic Dermatitis' => [
            'description' => 'Kondisi peradangan kulit kronis yang umum terjadi, menyebabkan kulit menjadi sangat kering, gatal, dan mudah meradang atau kemerahan.',
            'recommendation' => '
                <strong>Perawatan Mandiri & Pencegahan:</strong>
                <ul>
                    <li><strong>Gunakan Pelembap (Moisturizer):</strong> Oleskan pelembap hipoalergenik tanpa parfum beberapa kali sehari untuk mengunci kelembapan.</li>
                    <li><strong>Hindari Pemicu:</strong> Kenali dan hindari faktor seperti sabun keras, deterjen, keringat, stres, dan alergen (debu, bulu hewan).</li>
                    <li><strong>Mandi dengan Benar:</strong> Mandi dengan air suam-suam kuku (bukan air panas) dan batasi durasinya (5-10 menit).</li>
                </ul>
                <strong>Saran Medis:</strong>
                <ul>
                    <li>Jika gatal tidak terkendali atau kulit menunjukkan tanda infeksi, segera konsultasikan ke dokter untuk mendapatkan krim kortikosteroid.</li>
                </ul>'
        ],
        'Basal Cell Carcinoma (BCC)' => [
            'description' => 'Jenis kanker kulit yang paling umum. Biasanya tumbuh lambat dan jarang menyebar, namun penanganan dini oleh dokter sangat penting untuk mencegah kerusakan jaringan.',
            'recommendation' => '
                <strong>PENTING: KONSULTASI MEDIS SEGERA DIPERLUKAN.</strong>
                <br><br>
                <strong>Langkah yang Harus Diambil:</strong>
                <ul>
                    <li><strong>Jangan Tunda:</strong> Segera buat janji dengan dokter kulit untuk pemeriksaan profesional dan biopsi jika diperlukan.</li>
                    <li><strong>Hindari Paparan Sinar Matahari:</strong> Lindungi area yang mencurigakan dari sinar matahari lebih lanjut.</li>
                </ul>
                <strong>Prosedur Medis Umum:</strong>
                <ul>
                    <li>Penanganan bergantung pada ukuran dan lokasi tumor. Opsi umum termasuk eksisi bedah, bedah Mohs, kuretase, atau terapi lainnya.</li>
                </ul>'
        ],
        'Benign Keratosis-like Lesions (BKL)' => [
            'description' => 'Pertumbuhan kulit non-kanker yang umum terjadi seiring bertambahnya usia. Lesi ini biasanya tampak seperti benjolan kasar berwarna coklat, hitam, atau cokelat muda.',
            'recommendation' => '
                <strong>Perawatan & Pengawasan:</strong>
                <ul>
                    <li><strong>Umumnya Tidak Berbahaya:</strong> Lesi ini tidak memerlukan pengobatan dari segi medis.</li>
                    <li><strong>Observasi Mandiri:</strong> Awasi setiap perubahan pada kulit Anda menggunakan metode ABCDE (Asymmetry, Border, Color, Diameter, Evolving).</li>
                </ul>
                <strong>Saran Medis:</strong>
                <ul>
                    <li>Konsultasikan ke dokter jika lesi tiba-tiba berubah ukuran, bentuk, atau warna, untuk memastikan itu bukan kondisi yang lebih serius.</li>
                    <li>Jika terasa mengganggu secara kosmetik, dokter dapat mengangkatnya melalui prosedur seperti cryotherapy (pembekuan).</li>
                </ul>'
        ],
        'Eczema' => [
            'description' => 'Istilah umum untuk sekelompok kondisi yang menyebabkan kulit meradang, gatal, dan kering. Dermatitis Atopik adalah bentuk eksim yang paling umum.',
            'recommendation' => '
                <strong>Perawatan Mandiri & Gaya Hidup:</strong>
                <ul>
                    <li><strong>Hidrasi Kulit:</strong> Gunakan pelembap kental (krim atau salep) tanpa parfum setiap hari.</li>
                    <li><strong>Pilih Produk yang Tepat:</strong> Gunakan pembersih yang lembut, bebas sabun, dan hipoalergenik.</li>
                    <li><strong>Kelola Gatal:</strong> Gunakan kompres dingin untuk meredakan gatal dan hindari menggaruk.</li>
                </ul>
                <strong>Saran Medis:</strong>
                <ul>
                    <li>Jika perawatan mandiri tidak cukup atau eksim mengganggu aktivitas harian, temui dokter untuk mendapatkan krim anti-inflamasi atau perawatan lainnya.</li>
                </ul>'
        ],
        'Melanocytic Nevi (NV)' => [
            'description' => 'Ini adalah tahi lalat biasa, yang merupakan kumpulan sel penghasil pigmen (melanosit). Sebagian besar tahi lalat tidak berbahaya.',
            'recommendation' => '
                <strong>Pengawasan Mandiri adalah Kunci:</strong>
                <ul>
                    <li><strong>Lakukan Pemeriksaan Kulit Rutin:</strong> Periksa seluruh tubuh Anda sebulan sekali untuk memantau tahi lalat yang ada dan mencari yang baru.</li>
                    <li><strong>Gunakan Aturan ABCDE:</strong> Awasi perubahan pada Asymmetry (bentuk), Border (pinggiran), Color (warna), Diameter (ukuran > 6mm), dan Evolving (perkembangan).</li>
                </ul>
                <strong>Saran Medis:</strong>
                <ul>
                    <li>Jika Anda melihat salah satu dari tanda-tanda ABCDE atau ada tahi lalat yang tampak berbeda dari yang lain, segera periksakan ke dokter kulit.</li>
                </ul>'
        ],
        'Melanoma' => [
            'description' => 'Jenis kanker kulit yang paling berbahaya karena berpotensi menyebar (metastasis) ke bagian tubuh lain jika tidak diobati sejak dini.',
            'recommendation' => '
                <strong>PERINGATAN: INI ADALAH KONDISI MEDIS SERIUS. SEGERA TEMUI DOKTER.</strong>
                <br><br>
                <strong>Tindakan Darurat:</strong>
                <ul>
                    <li><strong>Hubungi Dokter Kulit Segera:</strong> Jangan menunda. Diagnosis dan pengobatan dini sangat meningkatkan peluang kesembuhan.</li>
                </ul>
                <strong>Proses Diagnosis dan Perawatan:</strong>
                <ul>
                    <li>Dokter akan melakukan biopsi. Perawatan bergantung pada stadium kanker dan bisa meliputi operasi, imunoterapi, atau terapi target.</li>
                </ul>'
        ],
        'Psoriasis pictures Lichen Planus and related diseases' => [
            'description' => 'Kelompok penyakit autoimun yang menyebabkan peradangan pada kulit. Psoriasis ditandai dengan bercak tebal, merah, dan bersisik.',
            'recommendation' => '
                <strong>Manajemen Gaya Hidup & Perawatan Mandiri:</strong>
                <ul>
                    <li><strong>Jaga Kelembapan Kulit:</strong> Gunakan pelembap secara teratur untuk mengurangi kekeringan dan sisik.</li>
                    <li><strong>Kelola Stres:</strong> Stres adalah pemicu umum. Coba teknik relaksasi seperti meditasi atau yoga.</li>
                    <li><strong>Hindari Cedera Kulit:</strong> Cedera pada kulit (goresan) dapat memicu munculnya lesi baru.</li>
                </ul>
                <strong>Saran Medis:</strong>
                <ul>
                    <li>Kondisi ini memerlukan diagnosis dan rencana perawatan dari dokter, yang bisa berupa salep, fototerapi, hingga obat-obatan sistemik.</li>
                </ul>'
        ],
        'Seborrheic Keratoses and other Benign Tumors' => [
            'description' => 'Keratosis Seboroik adalah salah satu tumor kulit jinak yang paling umum, sering digambarkan sebagai pertumbuhan yang "menempel" pada kulit dan memiliki tekstur seperti lilin.',
            'recommendation' => '
                <strong>Perawatan & Pengawasan:</strong>
                <ul>
                    <li><strong>Tidak Memerlukan Perawatan Medis:</strong> Kondisi ini tidak berbahaya dan tidak perlu diobati kecuali jika ada alasan kosmetik atau iritasi.</li>
                    <li><strong>Pembedaan dari Melanoma:</strong> Setiap lesi baru atau yang berubah harus dievaluasi oleh dokter untuk diagnosis yang akurat.</li>
                </ul>
                <strong>Saran Medis:</strong>
                <ul>
                    <li>Jika Anda ingin menghilangkannya karena alasan kosmetik, dokter dapat melakukannya dengan aman melalui prosedur seperti cryosurgery.</li>
                </ul>'
        ],
        'Tinea Ringworm Candidiasis and other Fungal Infections' => [
            'description' => 'Infeksi kulit yang disebabkan oleh jamur. Tinea (kurap) sering muncul sebagai ruam melingkar yang gatal, sedangkan Kandidiasis sering terjadi di lipatan kulit.',
            'recommendation' => '
                <strong>Perawatan Mandiri & Kebersihan:</strong>
                <ul>
                    <li><strong>Gunakan Krim Antijamur:</strong> Banyak infeksi jamur ringan dapat diobati dengan krim atau salep antijamur yang dijual bebas.</li>
                    <li><strong>Jaga Area Tetap Bersih dan Kering:</strong> Jamur tumbuh subur di lingkungan yang lembap.</li>
                    <li><strong>Hindari Berbagi Barang Pribadi:</strong> Jangan berbagi handuk, pakaian, atau sisir.</li>
                </ul>
                <strong>Saran Medis:</strong>
                <ul>
                    <li>Jika infeksi tidak membaik setelah 2 minggu perawatan mandiri, atau terjadi pada kuku/kulit kepala, segera temui dokter.</li>
                </ul>'
        ],
        'Warts Molluscum and other Viral Infections' => [
            'description' => 'Kutil dan Moluskum Kontagiosum adalah pertumbuhan kulit jinak yang disebabkan oleh virus dan menular melalui kontak langsung.',
            'recommendation' => '
                <strong>Pencegahan Penyebaran & Perawatan Mandiri:</strong>
                <ul>
                    <li><strong>Jangan Digaruk atau Dicungkil:</strong> Ini adalah cara utama penyebaran virus ke bagian lain dari tubuh Anda atau ke orang lain.</li>
                    <li><strong>Jaga Kebersihan Tangan:</strong> Cuci tangan Anda secara teratur setelah menyentuh area yang terinfeksi.</li>
                </ul>
                <strong>Saran Medis:</strong>
                <ul>
                    <li>Konsultasikan dengan dokter jika lesi menyebar dengan cepat, terasa sakit, atau berada di area sensitif.</li>
                </ul>'
        ],
    ];

    /**
     * Mengambil data deskripsi dan rekomendasi berdasarkan nama penyakit.
     * Versi ini lebih 'pintar' dan tidak sensitif terhadap spasi atau huruf besar/kecil.
     *
     * @param string $diseaseName Nama penyakit.
     * @return array Data penyakit atau data default jika tidak ditemukan.
     */
    public function getDiseaseInfo(string $diseaseName): array
    {
        $defaultInfo = [
            'description' => 'Deskripsi untuk penyakit ini tidak tersedia dalam basis data kami. Sangat disarankan untuk berkonsultasi dengan dokter spesialis kulit untuk informasi lebih lanjut.',
            'recommendation' => 'Rekomendasi spesifik tidak tersedia. Mohon konsultasikan dengan dokter spesialis kulit (dermatologis) untuk mendapatkan diagnosis yang akurat dan rencana penanganan yang tepat.'
        ];

        // Normalisasi input dari AI: ubah ke huruf kecil, ganti _ dengan spasi, hapus spasi berlebih
        $normalizedInput = str_replace('_', ' ', strtolower(trim($diseaseName)));

        // Cari di dalam data dengan cara yang dinormalisasi juga
        foreach ($this->diseaseData as $key => $data) {
            $normalizedKey = str_replace('_', ' ', strtolower(trim($key)));
            if ($normalizedInput === $normalizedKey) {
                return $data; // Jika cocok, kembalikan datanya
            }
        }

        // Jika setelah dicari tetap tidak ada yang cocok, kembalikan data default
        return $defaultInfo;
    }
}
