<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Data Pemakaian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('pemakaian.update', $pemakaian->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Hidden Fields --}}
                        <input type="hidden" name="is_status" value="{{ $pemakaian->is_status }}">
                        <input type="hidden" name="no_kontrol_id" value="{{ $pemakaian->no_kontrol_id }}">

                        {{-- Tahun --}}
                        <div class="mb-4 flex w-full flex-col">
                            <label for="tahun" class="mb-2 text-gray-600">Tahun</label>
                            <input type="number" name="tahun" id="tahun"
                                class="@error('tahun') border-red-500 @enderror rounded-md"
                                value="{{ old('tahun', $pemakaian->tahun) }}"
                                required readonly>
                            @error('tahun')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Bulan --}}
                        <div class="mb-4 flex w-full flex-col">
                            <label for="bulan" class="mb-2 text-gray-600">Bulan</label>
                            <input type="number" name="bulan" id="bulan"
                                class="@error('bulan') border-red-500 @enderror rounded-md"
                                value="{{ old('bulan', $pemakaian->bulan) }}"
                                required readonly>
                            @error('bulan')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- No Kontrol (Display Only) --}}
                        <div class="mb-4 flex w-full flex-col">
                            <label class="mb-2 text-gray-600">No Kontrol Pelanggan</label>
                            <input type="text"
                                class="rounded-md bg-gray-100"
                                value="{{ $pemakaian->no_kontrol_id }}"
                                readonly disabled>
                        </div>

                        {{-- Meter Awal --}}
                        <div class="mb-4 flex w-full flex-col">
                            <label for="meter_awal" class="mb-2 text-gray-600">Meter Awal</label>
                            <input type="number" name="meter_awal" id="meter_awal"
                                class="@error('meter_awal') border-red-500 @enderror rounded-md"
                                value="{{ old('meter_awal', $pemakaian->meter_awal) }}"
                                min="0"
                                required readonly>
                            @error('meter_awal')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Meter Akhir --}}
                        <div class="mb-4 flex w-full flex-col">
                            <label for="meter_akhir" class="mb-2 text-gray-600">Meter Akhir</label>
                            <input type="number" name="meter_akhir" id="meter_akhir"
                                class="@error('meter_akhir') border-red-500 @enderror rounded-md"
                                value="{{ old('meter_akhir', $pemakaian->meter_akhir) }}"
                                min="0"
                                required>
                            @error('meter_akhir')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Peringatan jika Meter Akhir lebih kecil dari Meter Awal --}}
                        @if ($errors->has('meter_akhir'))
                            <div class="bg-red-100 p-3 rounded-md mt-4">
                                <p class="text-red-600">
                                    Perhatian: {{ $errors->first('meter_akhir') }}
                                </p>
                            </div>
                        @endif

                        {{-- Peringatan jika Meter Awal bulan depan lebih kecil --}}
                        @if (session('meter_awal_warning'))
                            <div class="bg-yellow-100 p-3 rounded-md mt-4">
                                <p class="text-yellow-600">
                                    Peringatan: Meter Awal bulan berikutnya perlu diperbarui untuk menghindari ketidaksesuaian.
                                </p>
                            </div>
                        @endif

                        <div class="flex items-center gap-2 mt-4">
                            <button type="submit"
                                class="rounded-lg bg-blue-500 px-4 py-2 text-white transition-colors hover:bg-blue-600">
                                Update
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
</x-app-layout>
