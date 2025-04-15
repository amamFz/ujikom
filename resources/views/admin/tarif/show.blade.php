<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Tarif') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('tarif.update', $tarif->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4 w-full flex flex-col">
                            <label for="jenis_plg" class="mb-2 text-gray-600">Jenis Pelanggan</label>
                            <input type="text" name="jenis_plg" id="jenis_plg"
                                class="rounded-md @error('jenis_plg') border-red-500 @enderror"
                                value="{{ $tarif->jenis_pelanggan->name }}" required readonly disabled>
                            @error('jenis_plg')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4 w-full flex flex-col">
                            <label for="biaya_beban" class="mb-2 text-gray-600">Biaya Beban</label>
                            <input type="number" name="biaya_beban" id="biaya_beban" step="0.01"
                                class="rounded-md @error('biaya_beban') border-red-500 @enderror"
                                value="{{ $tarif->biaya_beban }}" required readonly disabled>

                            @error('biaya_beban')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4 w-full flex flex-col">
                            <label for="tarif_kwh" class="mb-2 text-gray-600">Tarif per KWH</label>
                            <input type="number" name="tarif_kwh" id="tarif_kwh" step="0.01"
                                class="rounded-md @error('tarif_kwh') border-red-500 @enderror"
                                value="{{ $tarif->tarif_kwh }}" required readonly disabled>
                            @error('tarif_kwh')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('tarif.index') }}"
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
