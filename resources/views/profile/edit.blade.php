@extends('layouts.app')

@section('title', 'IP Vulnerability Scanner')

@section('content')
<form method="POST" action="{{ route('profile.update') }}"
      class="max-w-2xl mx-auto bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-xl space-y-8 transition">
    @csrf

    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Profil & Password</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Perbarui informasi akun dan ubah password jika diperlukan.</p>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Data Profil --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 px-4 py-2 transition" required>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 px-4 py-2 transition" required>
        </div>
    </div>

    <hr class="border-gray-200 dark:border-gray-700">

    {{-- Ganti Password --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Ganti Password (Opsional)</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Isi password hanya jika ingin mengganti.</p>

        <div class="space-y-4">
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password Saat Ini</label>
                <input type="password" name="current_password" id="current_password"
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white px-4 py-2 focus:ring-2 focus:ring-blue-500 transition">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password Baru</label>
                    <input type="password" name="password" id="password"
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white px-4 py-2 focus:ring-2 focus:ring-blue-500 transition">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white px-4 py-2 focus:ring-2 focus:ring-blue-500 transition">
                </div>
            </div>
        </div>
    </div>

    <div class="pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-end">
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            Simpan Perubahan
        </button>
    </div>
</form>
@endsection
