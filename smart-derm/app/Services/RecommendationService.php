<?php

namespace App\Services;

class RecommendationService
{
    /**
     * Menyimpan daftar rekomendasi yang detail untuk berbagai penyakit kulit.
     * @var array
     */
    private $recommendations = [
        'Atopic Dermatitis' => "
            <strong>Ringkasan:</strong> Kondisi peradangan kulit kronis yang menyebabkan kulit kering, gatal, dan kemerahan.
            <br><br>
            <strong>Perawatan Mandiri & Pencegahan:</strong>
            <ul>
                <li><strong>Gunakan Pelembap (Moisturizer):</strong> Oleskan pelembap hipoalergenik tanpa parfum beberapa kali sehari, terutama setelah mandi, untuk mengunci kelembapan kulit.</li>
                <li><strong>Hindari Pemicu:</strong> Kenali dan hindari faktor yang memperburuk gejala, seperti sabun yang keras, deterjen, keringat berlebih, stres, dan alergen (debu, bulu hewan).</li>
                <li><strong>Mandi dengan Benar:</strong> Mandi dengan air suam-suam kuku (bukan air panas) dan batasi durasinya (5-10 menit). Gunakan sabun yang lembut.</li>
                <li><strong>Jangan Menggaruk:</strong> Menggaruk dapat merusak kulit dan menyebabkan infeksi. Gunting kuku Anda tetap pendek dan pertimbangkan untuk memakai sarung tangan di malam hari jika perlu.</li>
            </ul>
            <strong>Saran Medis:</strong>
            <ul>
                <li>Jika gatal tidak terkendali atau kulit menunjukkan tanda-tanda infeksi (seperti nanah, bengkak, atau kerak kuning), segera konsultasikan ke dokter.</li>
                <li>Dokter mungkin akan meresepkan krim kortikosteroid untuk mengurangi peradangan atau obat lain sesuai tingkat keparahan.</li>
            </ul>
        ",

        'Basal Cell Carcinoma (BCC)' => "
            <strong>PENTING: KONSULTASI MEDIS SEGERA DIPERLUKAN.</strong>
            <br><br>
            <strong>Ringkasan:</strong> Ini adalah jenis kanker kulit yang paling umum dan paling tidak berbahaya, namun diagnosis dan penanganan oleh dokter spesialis kulit adalah mutlak.
            <br><br>
            <strong>Langkah yang Harus Diambil:</strong>
            <ul>
                <li><strong>Jangan Tunda:</strong> Segera buat janji dengan dokter kulit untuk pemeriksaan profesional dan biopsi jika diperlukan. Deteksi dini adalah kunci keberhasilan pengobatan.</li>
                <li><strong>Hindari Paparan Sinar Matahari:</strong> Lindungi area yang mencurigakan dari sinar matahari lebih lanjut dengan pakaian pelindung atau tabir surya.</li>
            </ul>
            <strong>Prosedur Medis Umum:</strong>
            <ul>
                <li>Penanganan sangat bergantung pada ukuran dan lokasi tumor. Opsi umum termasuk eksisi bedah (operasi kecil), bedah Mohs (untuk area sensitif), kuretase, atau terapi topikal dan radiasi untuk kasus tertentu.</li>
            </ul>
            <strong>Pencegahan di Masa Depan:</strong>
            <ul>
                <li>Gunakan tabir surya spektrum luas setiap hari, kenakan pakaian pelindung, dan hindari paparan matahari puncak (jam 10 pagi - 4 sore).</li>
            </ul>
        ",

        'Benign Keratosis-like Lesions (BKL)' => "
            <strong>Ringkasan:</strong> Ini adalah pertumbuhan kulit non-kanker yang umum terjadi seiring bertambahnya usia. Lesi ini biasanya tampak seperti benjolan kasar berwarna coklat, hitam, atau cokelat muda.
            <br><br>
            <strong>Perawatan & Pengawasan:</strong>
            <ul>
                <li><strong>Umumnya Tidak Berbahaya:</strong> Lesi ini tidak memerlukan pengobatan dari segi medis.</li>
                <li><strong>Observasi Mandiri:</strong> Meskipun jinak, penting untuk mengawasi setiap perubahan pada kulit Anda. Gunakan metode ABCDE (Asymmetry, Border, Color, Diameter, Evolving) untuk memantau lesi kulit.</li>
                <li><strong>Jangan Mengelupas:</strong> Hindari menggaruk atau mencoba mengelupas lesi karena dapat menyebabkan iritasi atau infeksi.</li>
            </ul>
            <strong>Saran Medis:</strong>
            <ul>
                <li>Konsultasikan ke dokter jika lesi tiba-tiba berubah ukuran, bentuk, atau warna, terasa gatal, atau berdarah, untuk memastikan itu bukan kondisi yang lebih serius.</li>
                <li>Jika lesi terasa mengganggu secara kosmetik atau menyebabkan iritasi karena gesekan dengan pakaian, dokter dapat mengangkatnya melalui prosedur seperti cryotherapy (pembekuan) atau elektrokauter.</li>
            </ul>
        ",

        'Eczema' => "
            <strong>Ringkasan:</strong> Eksim adalah istilah umum untuk sekelompok kondisi yang menyebabkan kulit meradang, gatal, dan kering. Dermatitis Atopik adalah bentuk eksim yang paling umum.
            <br><br>
            <strong>Perawatan Mandiri & Gaya Hidup:</strong>
            <ul>
                <li><strong>Hidrasi Kulit:</strong> Gunakan pelembap kental (krim atau salep) tanpa parfum setiap hari, terutama pada kulit yang masih lembap setelah mandi.</li>
                <li><strong>Pilih Produk yang Tepat:</strong> Gunakan pembersih yang lembut, bebas sabun, dan hipoalergenik. Hindari produk dengan pewangi atau alkohol.</li>
                <li><strong>Kelola Gatal:</strong> Gunakan kompres dingin untuk meredakan gatal. Hindari menggaruk untuk mencegah kerusakan kulit lebih lanjut.</li>
                <li><strong>Kenali Pemicu:</strong> Perhatikan makanan, bahan pakaian (seperti wol), atau faktor lingkungan (cuaca panas/kering) yang dapat memicu eksim Anda.</li>
            </ul>
            <strong>Saran Medis:</strong>
            <ul>
                <li>Jika perawatan mandiri tidak cukup atau eksim mengganggu tidur dan aktivitas harian, temui dokter.</li>
                <li>Dokter mungkin meresepkan krim anti-inflamasi (kortikosteroid), obat antihistamin untuk mengurangi gatal, atau perawatan lain untuk mengendalikan gejala.</li>
            </ul>
        ",

        'Melanocytic Nevi (NV)' => "
            <strong>Ringkasan:</strong> Ini adalah tahi lalat biasa, yang merupakan kumpulan sel penghasil pigmen (melanosit). Sebagian besar tahi lalat tidak berbahaya.
            <br><br>
            <strong>Pengawasan Mandiri adalah Kunci:</strong>
            <ul>
                <li><strong>Lakukan Pemeriksaan Kulit Rutin:</strong> Periksa seluruh tubuh Anda sebulan sekali untuk memantau tahi lalat yang ada dan mencari tahi lalat baru.</li>
                <li><strong>Gunakan Aturan ABCDE:</strong>
                    <ul>
                        <li><strong>A (Asymmetry):</strong> Bentuknya tidak simetris.</li>
                        <li><strong>B (Border):</strong> Pinggirannya tidak rata atau bergerigi.</li>
                        <li><strong>C (Color):</strong> Warnanya tidak seragam (memiliki corak coklat, hitam, merah, atau biru).</li>
                        <li><strong>D (Diameter):</strong> Diameternya lebih besar dari 6mm (seukuran penghapus pensil).</li>
                        <li><strong>E (Evolving):</strong> Tahi lalat berubah ukuran, bentuk, warna, atau mulai terasa gatal atau berdarah.</li>
                    </ul>
                </li>
            </ul>
            <strong>Saran Medis:</strong>
            <ul>
                <li>Jika Anda melihat salah satu dari tanda-tanda ABCDE atau memiliki tahi lalat yang tampak berbeda dari yang lain ('ugly duckling sign'), segera periksakan ke dokter kulit untuk evaluasi lebih lanjut.</li>
            </ul>
        ",

        'Melanoma' => "
            <strong>PERINGATAN: INI ADALAH KONDISI MEDIS SERIUS. SEGERA TEMUI DOKTER.</strong>
            <br><br>
            <strong>Ringkasan:</strong> Melanoma adalah jenis kanker kulit yang paling berbahaya karena dapat menyebar (metastasis) ke bagian tubuh lain jika tidak diobati sejak dini.
            <br><br>
            <strong>Tindakan Darurat:</strong>
            <ul>
                <li><strong>Hubungi Dokter Kulit Segera:</strong> Jangan menunda. Diagnosis dan pengobatan dini secara signifikan meningkatkan prognosis dan peluang kesembuhan.</li>
                <li><strong>Jangan Menyentuh atau Mencoba Mengobati Sendiri:</strong> Biarkan dokter yang melakukan pemeriksaan dan diagnosis.</li>
            </ul>
            <strong>Proses Diagnosis dan Perawatan:</strong>
            <ul>
                <li>Dokter akan melakukan pemeriksaan fisik dan kemungkinan besar akan melakukan biopsi (pengambilan sampel kecil kulit) untuk dianalisis di laboratorium.</li>
                <li>Jika terkonfirmasi melanoma, perawatan akan bergantung pada stadium kanker dan bisa meliputi operasi pengangkatan, imunoterapi, terapi target, atau kemoterapi.</li>
            </ul>
        ",

        'Psoriasis pictures Lichen Planus and related diseases' => "
            <strong>Ringkasan:</strong> Ini adalah kelompok penyakit autoimun yang menyebabkan peradangan pada kulit. Psoriasis ditandai dengan bercak tebal, merah, dan bersisik, sedangkan Lichen Planus biasanya muncul sebagai benjolan ungu yang gatal.
            <br><br>
            <strong>Manajemen Gaya Hidup & Perawatan Mandiri:</strong>
            <ul>
                <li><strong>Jaga Kelembapan Kulit:</strong> Gunakan pelembap secara teratur untuk mengurangi kekeringan dan sisik.</li>
                <li><strong>Kelola Stres:</strong> Stres adalah pemicu umum. Coba teknik relaksasi seperti meditasi, yoga, atau pernapasan dalam.</li>
                <li><strong>Hindari Cedera Kulit:</strong> Cedera pada kulit (goresan, gigitan serangga) dapat memicu munculnya lesi baru (fenomena Koebner).</li>
                <li><strong>Mandi Oatmeal:</strong> Mandi dengan air hangat yang dicampur oatmeal koloid dapat membantu menenangkan kulit yang gatal dan meradang.</li>
            </ul>
            <strong>Saran Medis:</strong>
            <ul>
                <li>Kondisi ini memerlukan diagnosis dan rencana perawatan dari dokter.</li>
                <li>Perawatan medis dapat berupa salep kortikosteroid, analog vitamin D, fototerapi (terapi cahaya), hingga obat-obatan sistemik atau biologis untuk kasus yang parah.</li>
            </ul>
        ",

        'Seborrheic Keratoses and other Benign Tumors' => "
            <strong>Ringkasan:</strong> Keratosis Seboroik adalah salah satu tumor kulit jinak yang paling umum. Mereka sering digambarkan sebagai pertumbuhan yang 'menempel' pada kulit, bisa berwarna cokelat, hitam, atau terang, dan memiliki tekstur seperti lilin atau kasar.
            <br><br>
            <strong>Perawatan & Pengawasan:</strong>
            <ul>
                <li><strong>Tidak Memerlukan Perawatan Medis:</strong> Karena jinak, kondisi ini tidak berbahaya dan tidak perlu diobati kecuali jika ada alasan kosmetik atau iritasi.</li>
                <li><strong>Pembedaan dari Melanoma:</strong> Meskipun jinak, terkadang sulit bagi orang awam untuk membedakannya dari melanoma. Setiap lesi baru atau yang berubah harus dievaluasi oleh dokter.</li>
                <li><strong>Hindari Menggaruk:</strong> Menggaruk atau mencungkilnya dapat menyebabkan pendarahan, bengkak, dan kemungkinan infeksi.</li>
            </ul>
            <strong>Saran Medis:</strong>
            <ul>
                <li>Konsultasikan ke dokter untuk diagnosis yang akurat.</li>
                <li>Jika Anda ingin menghilangkannya karena alasan kosmetik atau karena sering tergesek pakaian dan mengalami iritasi, dokter dapat melakukannya dengan aman melalui prosedur seperti cryosurgery (pembekuan dengan nitrogen cair) atau elektrokauter.</li>
            </ul>
        ",

        'Tinea Ringworm Candidiasis and other Fungal Infections' => "
            <strong>Ringkasan:</strong> Ini adalah infeksi kulit yang disebabkan oleh jamur. Tinea (kurap) sering muncul sebagai ruam melingkar yang gatal, sedangkan Kandidiasis sering terjadi di area lipatan kulit yang lembap.
            <br><br>
            <strong>Perawatan Mandiri & Kebersihan:</strong>
            <ul>
                <li><strong>Gunakan Krim Antijamur:</strong> Banyak infeksi jamur ringan dapat diobati dengan krim atau salep antijamur yang dijual bebas. Ikuti petunjuk penggunaan dengan saksama dan lanjutkan pengobatan bahkan setelah gejala hilang untuk memastikan jamur benar-benar mati.</li>
                <li><strong>Jaga Area Tetap Bersih dan Kering:</strong> Jamur tumbuh subur di lingkungan yang lembap. Keringkan kulit Anda secara menyeluruh setelah mandi, terutama di area lipatan seperti selangkangan, ketiak, dan sela-sela jari kaki.</li>
                <li><strong>Hindari Berbagi Barang Pribadi:</strong> Jangan berbagi handuk, pakaian, atau sisir untuk mencegah penyebaran infeksi.</li>
                <li><strong>Kenakan Pakaian Longgar:</strong> Pilih pakaian yang terbuat dari bahan yang menyerap keringat seperti katun untuk mengurangi kelembapan.</li>
            </ul>
            <strong>Saran Medis:</strong>
            <ul>
                <li>Jika infeksi tidak membaik setelah 2 minggu perawatan mandiri, menyebar luas, atau terjadi pada kuku atau kulit kepala, segera temui dokter.</li>
                <li>Dokter mungkin akan meresepkan obat antijamur topikal yang lebih kuat atau obat oral (minum).</li>
            </ul>
        ",

        'Warts Molluscum and other Viral Infections' => "
            <strong>Ringkasan:</strong> Kutil dan Moluskum Kontagiosum adalah pertumbuhan kulit jinak yang disebabkan oleh virus. Keduanya menular melalui kontak langsung atau berbagi barang pribadi.
            <br><br>
            <strong>Pencegahan Penyebaran & Perawatan Mandiri:</strong>
            <ul>
                <li><strong>Jangan Digaruk atau Dicungkil:</strong> Ini adalah cara utama penyebaran virus ke bagian lain dari tubuh Anda atau ke orang lain.</li>
                <li><strong>Tutup Lesi:</strong> Pertimbangkan untuk menutupi lesi dengan perban tahan air, terutama sebelum berenang atau melakukan olahraga kontak.</li>
                <li><strong>Jaga Kebersihan Tangan:</strong> Cuci tangan Anda secara teratur, terutama setelah menyentuh area yang terinfeksi.</li>
                <li><strong>Perawatan Asam Salisilat (untuk kutil):</strong> Produk yang dijual bebas yang mengandung asam salisilat dapat membantu menghilangkan kutil secara bertahap.</li>
            </ul>
            <strong>Saran Medis:</strong>
            <ul>
                <li>Meskipun dapat hilang dengan sendirinya, ini bisa memakan waktu berbulan-bulan atau bahkan bertahun-tahun.</li>
                <li>Konsultasikan dengan dokter jika lesi menyebar dengan cepat, terasa sakit, atau berada di area sensitif (seperti wajah atau alat kelamin).</li>
                <li>Pilihan perawatan medis termasuk cryotherapy (pembekuan), krim resep, atau prosedur pengangkatan kecil lainnya.</li>
            </ul>
        ",
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
        // Jika tidak ditemukan, berikan pesan default yang informatif.
        return $this->recommendations[$diseaseName] ?? '
            <strong>Diagnosis Tidak Ditemukan.</strong>
            <br><br>
            Rekomendasi spesifik untuk kondisi ini tidak tersedia dalam basis data kami.
            <br><br>
            <strong>Saran Umum:</strong>
            <ul>
                <li>Hindari menggaruk atau memanipulasi area kulit yang terpengaruh.</li>
                <li>Jaga kebersihan area tersebut dengan pembersih yang lembut.</li>
                <li>Perhatikan setiap perubahan pada lesi kulit (ukuran, warna, bentuk).</li>
            </ul>
            <strong>Sangat disarankan untuk berkonsultasi dengan dokter spesialis kulit (dermatologis) untuk mendapatkan diagnosis yang akurat dan rencana penanganan yang tepat.</strong>
        ';
    }
}
