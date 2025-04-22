<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tambah Data Pemakaian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->has('duplicate'))
                        <div class="mb-4 rounded-md border border-red-200 bg-red-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">
                                        {{ $errors->first('duplicate') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Form for filtering --}}
                    <form action="{{ route('pemakaian.create') }}" method="GET" class="mb-6">
                        <div class="mb-4 flex w-full flex-col">
                            <label for="tahun" class="mb-2 text-gray-600">Tahun</label>
                            <select name="tahun" id="tahun"
                                class="@error('tahun') border-red-500 @enderror rounded-md"
                                onchange="this.form.submit()">
                                @for ($year = date('Y'); $year >= 2020; $year--)
                                    <option value="{{ $year }}" {{ $tahun == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="mb-4 flex w-full flex-col">
                            <label for="bulan" class="mb-2 text-gray-600">Bulan</label>
                            <select name="bulan" id="bulan"
                                class="@error('bulan') border-red-500 @enderror rounded-md"
                                onchange="this.form.submit()">
                                @foreach (range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ $bulan == $month ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4 flex w-full flex-col">
                            <label for="no_kontrol_id" class="mb-2 text-gray-600">No Kontrol Pelanggan</label>
                            <select name="no_kontrol_id" id="no_kontrol_id"
                                class="@error('no_kontrol_id') border-red-500 @enderror rounded-md"
                                onchange="this.form.submit()">
                                <option value="">Pilih No Kontrol</option>
                                @foreach ($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->no_kontrol }}"
                                        {{ $no_kontrol_id == $pelanggan->no_kontrol ? 'selected' : '' }}>
                                        {{ $pelanggan->no_kontrol }} - {{ $pelanggan->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    {{-- Form for storing data --}}
                    <form action="{{ route('pemakaian.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tahun" value="{{ $tahun }}">
                        <input type="hidden" name="bulan" value="{{ $bulan }}">
                        <input type="hidden" name="no_kontrol_id" value="{{ $no_kontrol_id }}">

                        <div class="mb-4 flex w-full flex-col">
                            <label for="meter_awal" class="mb-2 text-gray-600">Meter Awal</label>
                            <input type="number" name="meter_awal" id="meter_awal"
                                class="@error('meter_awal') border-red-500 @enderror rounded-md {{ !empty($meter_awal) ? 'bg-gray-100' : '' }}"
                                value="{{ $meter_awal }}" {{ !empty($meter_awal) ? 'readonly' : '' }} min="0"
                                required>
                            @error('meter_awal')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4 flex w-full flex-col">
                            <label for="meter_akhir" class="mb-2 text-gray-600">Meter Akhir</label>
                            <input type="number" name="meter_akhir" id="meter_akhir"
                                class="@error('meter_akhir') border-red-500 @enderror rounded-md"
                                value="{{ old('meter_akhir') }}" min="0" required onchange="calculateTotal()"
                                onkeyup="calculateTotal()">
                            @error('meter_akhir')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4 flex w-full flex-col">
                            <label for="jumlah_pakai" class="mb-2 text-gray-600">Jumlah Pemakaian</label>
                            <input type="number" id="jumlah_pakai" name="jumlah_pakai" class="rounded-md bg-gray-100"
                                readonly>
                        </div>

                        {{-- Dalam form storing data --}}
                        <div class="mb-4 flex w-full flex-col">
                            <label for="biaya_beban_pemakai" class="mb-2 text-gray-600">Biaya Beban</label>
                            <input type="number" name="biaya_beban_pemakai" id="biaya_beban_pemakai"
                                class="@error('biaya_beban_pemakai') border-red-500 @enderror rounded-md {{ !empty($biaya_beban_pemakai) ? 'bg-gray-100' : '' }}"
                                value="{{ $biaya_beban_pemakai }}"
                                {{ !empty($biaya_beban_pemakai) ? 'readonly' : '' }} step="0.01" min="0"
                                required>
                            @error('biaya_beban_pemakai')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="submit"
                                class="rounded-lg bg-blue-500 px-4 py-2 text-white transition-colors hover:bg-blue-600">
                                Simpan
                            </button>
                            <a href="{{ route('pemakaian.index') }}"
                                class="rounded-lg bg-gray-500 px-4 py-2 text-white transition-colors hover:bg-gray-600">
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

            document.addEventListener('DOMContentLoaded', function() {
                const meterAwal = document.getElementById('meter_awal').value;
                const meterAkhir = document.getElementById('meter_akhir').value;

                if (meterAwal && meterAkhir) {
                    calculateTotal();
                }

                if (meterAwal) {
                    const meterAwalInput = document.getElementById('meter_awal');
                    meterAwalInput.readOnly = true;
                    meterAwalInput.classList.add('bg-gray-100');
                }
            });
        </script>
    @endpush
</x-app-layout>
