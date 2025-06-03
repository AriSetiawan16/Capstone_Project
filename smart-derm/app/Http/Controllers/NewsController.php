<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

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
            $item['thumbnail'] = str_replace('http://', 'https://', $item['thumbnail'] ?? '');
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
                $item['thumbnail'] = str_replace('http://', 'https://', $item['thumbnail'] ?? '');
                return $item;
            });

            $article = $news->first(function ($item) use ($decodedUrl) {
                return $item['link'] === $decodedUrl;
            });

            if ($article) {
                return view('dashboard.news-detail', ['newsItem' => $article]);
            }

            abort(404, 'Artikel tidak ditemukan.');
        }

        abort(500, 'Gagal mengambil data dari API');
    }


}
