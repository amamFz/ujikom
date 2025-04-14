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
                    <div class="mb-4 w-full flex flex-col">
                        <label for="no_kontrol" class="mb-2 text-gray-600">No Kontrol</label>
                        <input type="text" name="no_kontrol" id="name" class="rounded-md " readonly
                            value="{{ $pelanggan->no_kontrol }}" required disabled>
                    </div>
                    <div class="mb-4 w-full flex flex-col">
                        <label for="name" class="mb-2 text-gray-600">Nama</label>
                        <input type="text" name="name" id="name"
                            class="rounded-md @error('name') border-red-500 @enderror" value="{{ $pelanggan->name }}"
                            required disabled readonly>
                    </div>

                    <div class="mb-4 w-full flex flex-col">
                        <label for="alamat" class="mb-2 text-gray-600">Alamat</label>
                        <textarea name="alamat" id="alamat" class="rounded-md" disabled readonly>{{ $pelanggan->alamat }}</textarea>
                    </div>

                    <div class="mb-4 w-full flex flex-col">
                        <label for="telepon" class="mb-2 text-gray-600">Telepon</label>
                        <input type="number" name="telepon" id="telepon"
                            class="rounded-md @error('telepon') border-red-500 @enderror" readonly
                            value="{{ $pelanggan->telepon }}" required disabled min="10000000" max="9999999999999999">
                    </div>

                    <div class="mb-4 w-full flex flex-col">
                        <label for="jenis_plg" class="mb-2 text-gray-600">Jenis Pelanggan</label>
                        <input type="text" name="jenis_plg" id="jenis_plg"
                            class="rounded-md @error('jenis_plg') border-red-500 @enderror"
                            value="{{ $pelanggan->tarif->jenis_plg }}" required disabled readonly>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('pelanggan.index') }}"
                            class="bg-gray-500 px-4 py-2 rounded-lg text-white hover:bg-gray-600 transition-colors">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
