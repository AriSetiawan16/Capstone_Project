<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        // Simulate news data - in real app, fetch from database
        $news = [
            [
                'id' => 1,
                'title' => 'Teknologi AI Terbaru dalam Diagnosa Penyakit Kulit',
                'excerpt' => 'Perkembangan teknologi artificial intelligence membawa revolusi baru dalam dunia kesehatan kulit...',
                'image' => 'https://via.placeholder.com/400x200/4f46e5/ffffff?text=AI+Technology',
                'published_at' => '2025-05-30',
                'category' => 'Technology'
            ],
            [
                'id' => 2,
                'title' => 'Tips Merawat Kulit di Musim Hujan',
                'excerpt' => 'Musim hujan membawa tantangan tersendiri untuk kesehatan kulit. Berikut tips yang bisa diterapkan...',
                'image' => 'https://via.placeholder.com/400x200/059669/ffffff?text=Skin+Care',
                'published_at' => '2025-05-29',
                'category' => 'Health Tips'
            ],
            [
                'id' => 3,
                'title' => 'Mengenal Berbagai Jenis Penyakit Kulit yang Umum',
                'excerpt' => 'Ada banyak jenis penyakit kulit yang perlu kita ketahui untuk pencegahan dan penanganan yang tepat...',
                'image' => 'https://via.placeholder.com/400x200/dc2626/ffffff?text=Skin+Disease',
                'published_at' => '2025-05-28',
                'category' => 'Education'
            ],
            [
                'id' => 4,
                'title' => 'Pentingnya Sunscreen untuk Kesehatan Kulit',
                'excerpt' => 'Sunscreen bukan hanya untuk saat berlibur ke pantai, tapi penting untuk digunakan setiap hari...',
                'image' => 'https://via.placeholder.com/400x200/f59e0b/ffffff?text=Sunscreen',
                'published_at' => '2025-05-27',
                'category' => 'Prevention'
            ]
        ];

        return view('dashboard.news', compact('news'));
    }

    public function show($id)
    {
        // Simulate single news data
        $newsItem = [
            'id' => $id,
            'title' => 'Teknologi AI Terbaru dalam Diagnosa Penyakit Kulit',
            'content' => 'Perkembangan teknologi artificial intelligence (AI) telah membawa revolusi besar dalam berbagai bidang, termasuk dunia kesehatan. Khususnya dalam diagnosa penyakit kulit, AI telah menunjukkan kemampuan yang luar biasa dalam mengidentifikasi berbagai kondisi kulit dengan akurasi yang tinggi.

            Sistem AI modern dapat menganalisis gambar kulit dan memberikan prediksi tentang kemungkinan kondisi yang dialami pasien. Teknologi deep learning dan computer vision memungkinkan sistem untuk belajar dari ribuan gambar kulit yang telah didiagnosa oleh para ahli dermatologi.

            Keunggulan utama dari teknologi AI dalam diagnosa penyakit kulit adalah:

            1. Akurasi Tinggi: AI dapat mengidentifikasi pola dan karakteristik yang mungkin terlewat oleh mata manusia
            2. Konsistensi: Tidak terpengaruh oleh faktor subjektif seperti kelelahan atau mood
            3. Kecepatan: Dapat memberikan hasil analisis dalam hitungan detik
            4. Aksesibilitas: Memungkinkan diagnosa awal di daerah yang sulit dijangkau dokter spesialis

            Meskipun demikian, penting untuk diingat bahwa AI bukanlah pengganti konsultasi dengan dokter ahli. Teknologi ini sebaiknya digunakan sebagai alat bantu untuk skrining awal dan tetap memerlukan konfirmasi dari tenaga medis profesional.',
            'image' => 'https://via.placeholder.com/800x400/4f46e5/ffffff?text=AI+Technology+Detail',
            'published_at' => '2025-05-30',
            'category' => 'Technology',
            'author' => 'Dr. Sarah Medical'
        ];

        return view('dashboard.news-detail', compact('newsItem'));
    }
}
