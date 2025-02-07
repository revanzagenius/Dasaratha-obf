<?php

namespace App\Http\Controllers;

class PasswordController extends Controller
{
    public function index()
    {
        // Path ke file dalam storage/app
        $filePath = storage_path('app/10_million_password_list_top_10000.txt');

        // Periksa apakah file ada
        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        // Baca isi file dan pecah menjadi array berdasarkan baris
        $passwords = explode("\n", file_get_contents($filePath));

        // Kirim data ke view dengan pagination manual
        $perPage = 10; // Tampilkan hanya 10 password per halaman
        $currentPage = request()->get('page', 1);
        $passwordsPage = array_slice($passwords, ($currentPage - 1) * $perPage, $perPage);
        $totalPages = ceil(count($passwords) / $perPage);

        return view('passwords.index', [
            'passwords' => $passwordsPage,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
        ]);
    }
}
