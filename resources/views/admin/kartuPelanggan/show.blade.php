<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- No Kontrol -->
                    <div class="mb-4 w-full flex flex-col">
                        <label class="mb-2 text-gray-600">No Kontrol</label>
                        <p class="rounded-md bg-gray-100 p-2">{{ $pelanggan->no_kontrol }}</p>
                    </div>

                    <!-- Nama -->
                    <div class="mb-4 w-full flex flex-col">
                        <label class="mb-2 text-gray-600">Nama</label>
                        <p class="rounded-md bg-gray-100 p-2">{{ $pelanggan->name }}</p>
                    </div>

                    <!-- Alamat -->
                    <div class="mb-4 w-full flex flex-col">
                        <label class="mb-2 text-gray-600">Alamat</label>
                        <p class="rounded-md bg-gray-100 p-2">{{ $pelanggan->alamat }}</p>
                    </div>

                    <!-- Telepon -->
                    <div class="mb-4 w-full flex flex-col">
                        <label class="mb-2 text-gray-600">Telepon</label>
                        <p class="rounded-md bg-gray-100 p-2">{{ $pelanggan->telepon }}</p>
                    </div>

                    <!-- Jenis Pelanggan -->
                    <div class="mb-4 w-full flex flex-col">
                        <label class="mb-2 text-gray-600">Jenis Pelanggan</label>
                        <p class="rounded-md bg-gray-100 p-2">
                            {{ $pelanggan->jenis_pelanggan->name ?? 'Jenis pelanggan tidak ditemukan' }}
                        </p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center gap-2">
                        <a href="{{ route('pelanggan.index') }}"
                            class="bg-gray-500 px-4 py-2 rounded-lg text-white hover:bg-gray-600 transition-colors">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
