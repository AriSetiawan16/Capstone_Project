<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
class NewsController extends Controller
{
   
    public function index()
    {
        $response = Http::withOptions([
            'verify' => false, // hanya untuk testing
            'timeout' => 10,
        ])->get('https://api-berita-indonesia.vercel.app/merdeka/sehat/');

        if ($response->successful()) {
            $data = $response->json();
            $news = collect($data['data']['posts'] ?? [])->map(function ($item) {
                // Slugify judul untuk nama file gambar
                $slug = Str::slug($item['title'], '-');
                $filename = 'images/' . $slug . '.jpg';

                // Cek apakah file gambar lokal ada
                if (File::exists(public_path($filename))) {
                    $item['local_thumbnail'] = $filename;
                } else {
                    $item['local_thumbnail'] = 'images/placeholder-news.jpg';
                }

                return $item;
            })->toArray();
        } else {
            $news = [];
        }

        return view('dashboard.news', compact('news'));
    }

    public function show($id)
    {
        $decodedUrl = urldecode($id);

        $response = Http::get('https://api-berita-indonesia.vercel.app/merdeka/sehat/');

        if ($response->successful()) {
            $data = $response->json();
            $news = collect($data['data']['posts'] ?? [])->map(function ($item) {
                // Slugify untuk gambar detail
                $slug = Str::slug($item['title'], '-');
                $filename = 'images/' . $slug . '.jpg';

                if (File::exists(public_path($filename))) {
                    $item['local_thumbnail'] = $filename;
                } else {
                    $item['local_thumbnail'] = 'images/placeholder-news.jpg';
                }

                return $item;
            });

            $article = $news->first(function ($item) use ($decodedUrl) {
                return $item['link'] === $decodedUrl;
            });

            if ($article) {
                return view('dashboard', ['newsItem' => $article]);
            }

            abort(404, 'Artikel tidak ditemukan.');
        }

        abort(500, 'Gagal mengambil data dari API');
    }
}
