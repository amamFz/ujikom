<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Membuat Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('pelanggan.store') }}" method="POST">
                        @csrf
                        <div class="mb-4 w-full flex flex-col">
                            <label for="no_kontrol" class="mb-2 text-gray-600">No Kontrol</label>
                            <input type="text" name="no_kontrol" id="no_kontrol" class="rounded-md bg-gray-100"
                                value="{{ $no_kontrol }}" readonly>
                        </div>

                        <div class="mb-4 w-full flex flex-col">
                            <label for="name" class="mb-2 text-gray-600">Nama</label>
                            <input type="text" name="name" id="name"
                                class="rounded-md @error('name') border-red-500 @enderror" value="{{ old('name') }}"
                                required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4 w-full flex flex-col">
                            <label for="alamat" class="mb-2 text-gray-600">Alamat</label>
                            <textarea name="alamat" id="alamat" class="rounded-md @error('alamat') border-red-500 @enderror" rows="3">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4 w-full flex flex-col">
                            <label for="telepon" class="mb-2 text-gray-600">Telepon</label>
                            <input type="number" name="telepon" id="telepon"
                                class="rounded-md @error('telepon') border-red-500 @enderror"
                                value="{{ old('telepon') }}" required pattern="[0-9]{8,16}">
                            @error('telepon')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4 w-full flex flex-col">
                            <label for="jenis_plg_id" class="mb-2 text-gray-600">Jenis Pelanggan</label>

                            <select name="jenis_plg_id" id="jenis_plg_id" class="form-control"
                                class="rounded-md @error('jenis_plg_id') border-red-500 @enderror">
                                <option value="">Pilih Jenis Pelanggan</option>
                                @foreach ($jenis_pelanggans as $jenis)
                                    <option value="{{ $jenis->id }}"
                                        {{ old('jenis_plg_id', $pelanggan->jenis_plg_id ?? '') == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_plg_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="submit"
                                class="bg-blue-500 px-4 py-2 rounded-lg text-white hover:bg-blue-600 transition-colors">
                                Simpan
                            </button>
                            <a href="{{ route('pelanggan.index') }}"
                                class="bg-gray-500 px-4 py-2 rounded-lg text-white hover:bg-gray-600 transition-colors">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
