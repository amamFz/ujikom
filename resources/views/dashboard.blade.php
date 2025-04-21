<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Pesan Selamat Datang -->
            <div class="mb-6 rounded-lg bg-blue-100 p-6 shadow-md">
                <h3 class="text-lg font-semibold text-blue-800">Selamat Datang, {{ Auth::user()->name }}!</h3>
                <p class="mt-2 text-blue-700">Semoga harimu menyenangkan. Berikut adalah ringkasan data Anda.</p>
            </div>

            <!-- Statistik -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="rounded-lg bg-blue-500 p-6 text-white shadow-md">
                    <h3 class="text-lg font-semibold">Total Pengguna</h3>
                    <p class="mt-2 text-2xl">{{ $totalUsers }}</p>
                </div>
                <div class="rounded-lg bg-green-500 p-6 text-white shadow-md">
                    <h3 class="text-lg font-semibold">Total Pelanggan</h3>
                    <p class="mt-2 text-2xl">{{ $totalPelanggan }}</p>
                </div>
                <div class="rounded-lg bg-yellow-500 p-6 text-white shadow-md">
                    <h3 class="text-lg font-semibold">Total Pemakaian</h3>
                    <p class="mt-2 text-2xl">{{ $totalPemakaian }}</p>
                </div>
            </div>

            <!-- Aktivitas Terbaru -->
            <div class="mt-6 rounded-lg bg-white p-6 shadow-md">
                <h3 class="mb-4 text-lg font-semibold">Aktivitas Terbaru</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">No</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Nama</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Tanggal</th>
                            {{-- <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($aktivitas as $index => $item)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-3 text-sm">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-sm">{{ $item->name }}</td>
                                <td class="px-4 py-3 text-sm">{{ $item->created_at->format('d M Y') }}</td>
                                {{-- <td class="px-4 py-3 text-sm">
                  <a href="#" class="text-blue-500 hover:underline">Detail</a>
                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
