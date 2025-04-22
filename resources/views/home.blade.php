<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Pembayaran Listrik</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Hero Section -->
        <div class="bg-blue-600 text-white">
            <div class="container mx-auto px-6 py-16">
                <h1 class="text-4xl font-bold mb-4">Cek Tagihan Listrik Anda</h1>
                <p class="text-xl mb-8">Masukkan nomor kontrol untuk melihat riwayat pembayaran</p>

                <div class="max-w-md bg-white rounded-lg shadow-lg p-6">
                    @if (session('error') || isset($error))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <p>{{ session('error') ?? $error }}</p>
                        </div>
                    @endif

                    @if (isset($warning))
                        <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                            <p>{{ $warning }}</p>
                        </div>
                    @endif

                    <form action="{{ route('public.history') }}" method="GET">
                        <div class="mb-4">
                            <label for="no_kontrol" class="block text-gray-700 text-sm font-bold mb-2">
                                Nomor Kontrol
                            </label>
                            <input type="text" name="no_kontrol" id="no_kontrol"
                                class="w-full px-3 py-2 border text-gray-600 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('no_kontrol') border-red-500 @enderror"
                                placeholder="Masukkan nomor kontrol Anda"
                                value="{{ old('no_kontrol', request('no_kontrol')) }}"
                                required>
                        </div>
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Cek Tagihan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        @if (isset($pelanggan))
            <div class="container mx-auto px-6 py-8">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="border-b border-gray-200 pb-4 mb-4">
                        <h2 class="text-2xl font-bold text-gray-800">Informasi Pelanggan</h2>
                        <p class="text-gray-600">Nomor Kontrol: {{ $pelanggan->no_kontrol }}</p>
                        <p class="text-gray-600">Nama: {{ $pelanggan->name }}</p>
                        <p class="text-gray-600">Alamat: {{ $pelanggan->alamat }}</p>
                    </div>

                    @if (isset($pemakaians) && $pemakaians->isNotEmpty())
                        <h3 class="text-xl font-semibold mb-4">Riwayat Pembayaran</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pemakaian</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Tagihan</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pemakaians as $pemakaian)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ date('F', mktime(0, 0, 0, $pemakaian->bulan, 1)) }}
                                                {{ $pemakaian->tahun }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ number_format($pemakaian->jumlah_pakai) }} kWh
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                                Rp {{ number_format($pemakaian->total_bayar, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if ($pemakaian->is_status)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Lunas
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Belum Lunas
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100 mb-4">
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-medium text-gray-900 mb-2">Belum Ada Data</h3>
                            <p class="text-gray-500">
                                Belum ada data pemakaian untuk nomor kontrol ini.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Footer -->
        <footer class="bg-white border-t mt-auto">
            <div class="container mx-auto px-6 py-4">
                <p class="text-center text-gray-600 text-sm">
                    © {{ date('Y') }} Sistem Pembayaran Listrik. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</body>
</html>
