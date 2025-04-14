<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Pemakaian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('pemakaian.store') }}" method="POST">
                        @csrf
                        <div class="mb-4 w-full flex flex-col">
                            <label for="tahun" class="mb-2 text-gray-600">Tahun</label>
                            <select name="tahun" id="tahun"
                                class="rounded-md @error('tahun') border-red-500 @enderror" required>
                                @for ($year = date('Y'); $year >= 2020; $year--)
                                    <option value="{{ $year }}"
                                        {{ old('tahun', date('Y')) == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                            @error('tahun')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4 w-full flex flex-col">
                            <label for="bulan" class="mb-2 text-gray-600">Bulan</label>
                            <select name="bulan" id="bulan"
                                class="rounded-md @error('bulan') border-red-500 @enderror" required>
                                @foreach (range(1, 12) as $month)
                                    <option value="{{ $month }}"
                                        {{ old('bulan', date('n')) == $month ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bulan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4 w-full flex flex-col">
                            <label for="no_kontrol_id" class="mb-2 text-gray-600">No Kontrol Pelanggan</label>
                            <select name="no_kontrol_id" id="no_kontrol_id"
                                class="rounded-md @error('no_kontrol_id') border-red-500 @enderror" required>
                                <option value="">Pilih No Kontrol</option>
                                @foreach ($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->no_kontrol }}"
                                        {{ old('no_kontrol_id') == $pelanggan->no_kontrol ? 'selected' : '' }}>
                                        {{ $pelanggan->no_kontrol }} - {{ $pelanggan->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('no_kontrol_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4 w-full flex flex-col">
                            <label for="meter_awal" class="mb-2 text-gray-600">Meter Awal</label>
                            <input type="number" name="meter_awal" id="meter_awal"
                                class="rounded-md @error('meter_awal') border-red-500 @enderror"
                                value="{{ old('meter_awal') }}" min="0" required onchange="calculateTotal()"
                                onkeyup="calculateTotal()">
                            @error('meter_awal')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4 w-full flex flex-col">
                            <label for="meter_akhir" class="mb-2 text-gray-600">Meter Akhir</label>
                            <input type="number" name="meter_akhir" id="meter_akhir"
                                class="rounded-md @error('meter_akhir') border-red-500 @enderror"
                                value="{{ old('meter_akhir') }}" min="0" required onchange="calculateTotal()"
                                onkeyup="calculateTotal()">
                            @error('meter_akhir')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4 w-full flex flex-col">
                            <label for="jumlah_pakai" class="mb-2 text-gray-600">Jumlah Pemakaian</label>
                            <input type="number" id="jumlah_pakai" name="jumlah_pakai" class="rounded-md bg-gray-100"
                                readonly>
                        </div>

                        <div class="mb-4 w-full flex flex-col">
                            <label for="biaya_beban_pemakai" class="mb-2 text-gray-600">Biaya Beban</label>
                            <input type="number" name="biaya_beban_pemakai" id="biaya_beban_pemakai"
                                class="rounded-md @error('biaya_beban_pemakai') border-red-500 @enderror"
                                value="{{ old('biaya_beban_pemakai') }}" step="0.01" min="0" required>
                            @error('biaya_beban_pemakai')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- <div class="mb-4 w-full flex flex-col">
                            <label for="biaya_pemakaian" class="mb-2 text-gray-600">Biaya Pemakaian</label>
                            <input type="number" name="biaya_pemakaian" id="biaya_pemakaian"
                                class="rounded-md @error('biaya_pemakaian') border-red-500 @enderror"
                                value="{{ old('biaya_pemakaian') }}" step="0.01" min="0" required>
                            @error('biaya_pemakaian')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div> --}}

                        <div class="flex items-center gap-2">
                            <button type="submit"
                                class="bg-blue-500 px-4 py-2 rounded-lg text-white hover:bg-blue-600 transition-colors">
                                Simpan
                            </button>
                            <a href="{{ route('pemakaian.index') }}"
                                class="bg-gray-500 px-4 py-2 rounded-lg text-white hover:bg-gray-600 transition-colors">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function calculateTotal() {
                const meterAwal = parseFloat(document.getElementById('meter_awal').value) || 0;
                const meterAkhir = parseFloat(document.getElementById('meter_akhir').value) || 0;

                if (meterAkhir >= meterAwal) {
                    const total = meterAkhir - meterAwal;
                    document.getElementById('jumlah_pakai').value = total;
                } else {
                    document.getElementById('jumlah_pakai').value = '';
                }
            }

            // Calculate on page load if values exist
            document.addEventListener('DOMContentLoaded', function() {
                calculateTotal();
            });
        </script>
    @endpush
</x-app-layout>
