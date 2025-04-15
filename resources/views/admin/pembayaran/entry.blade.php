<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Entri Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-lg rounded-lg">
                <div class="p-8">
                    <!-- Card Header with Customer Info -->
                    <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Data Pembayaran</h3>
                            <p class="text-gray-500">{{ date('d F Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-semibold text-gray-800">#{{ $pelanggan->no_kontrol }}</p>
                            <p class="text-gray-500">{{ $pelanggan->name }}</p>
                        </div>
                    </div>

                    <!-- Customer Details -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-semibold text-gray-600 mb-4">Informasi Pelanggan</h4>
                                <div class="space-y-2">
                                    <p class="flex justify-between">
                                        <span class="text-gray-600">No Kontrol</span>
                                        <span class="font-medium">{{ $pelanggan->no_kontrol }}</span>
                                    </p>
                                    <p class="flex justify-between">
                                        <span class="text-gray-600">Nama</span>
                                        <span class="font-medium">{{ $pelanggan->name }}</span>
                                    </p>
                                    <p class="flex justify-between">
                                        <span class="text-gray-600">Alamat</span>
                                        <span class="font-medium">{{ $pelanggan->alamat }}</span>
                                    </p>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-600 mb-4">Informasi Tarif</h4>
                                <div class="space-y-2">
                                    <p class="flex justify-between">
                                        <span class="text-gray-600">Tarif/kWh</span>
                                        <span class="font-medium">Rp
                                            {{ number_format($pelanggan->tarif->tarif_kwh, 0, ',', '.') }}</span>
                                    </p>
                                    <p class="flex justify-between">
                                        <span class="text-gray-600">Biaya Beban</span>
                                        <span class="font-medium">Rp
                                            {{ number_format($pelanggan->tarif->biaya_beban, 0, ',', '.') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($pemakaian)
                        <!-- Usage Details -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
                            <h4 class="font-semibold text-gray-800 mb-4">Detail Pemakaian</h4>
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <p class="flex justify-between">
                                        <span class="text-gray-600">Periode</span>
                                        <span class="font-medium">{{ date('F', mktime(0, 0, 0, $pemakaian->bulan, 1)) }}
                                            {{ $pemakaian->tahun }}</span>
                                    </p>
                                    <p class="flex justify-between">
                                        <span class="text-gray-600">Meter Awal</span>
                                        <span class="font-medium">{{ $pemakaian->meter_awal }}</span>
                                    </p>
                                    <p class="flex justify-between">
                                        <span class="text-gray-600">Meter Akhir</span>
                                        <span class="font-medium">{{ $pemakaian->meter_akhir }}</span>
                                    </p>
                                    <p class="flex justify-between">
                                        <span class="text-gray-600">Jumlah Pakai</span>
                                        <span class="font-medium">{{ $pemakaian->jumlah_pakai }} kWh</span>
                                    </p>
                                </div>
                                <div class="space-y-3">
                                    <p class="flex justify-between">
                                        <span class="text-gray-600">Biaya Beban</span>
                                        <span class="font-medium">Rp
                                            {{ number_format($pemakaian->biaya_beban_pemakai, 0, ',', '.') }}</span>
                                    </p>
                                    <p class="flex justify-between">
                                        <span class="text-gray-600">Biaya Pemakaian</span>
                                        <span class="font-medium">Rp
                                            {{ number_format($pemakaian->biaya_pemakaian, 0, ',', '.') }}</span>
                                    </p>
                                    <p class="flex justify-between text-lg font-bold text-blue-600 pt-3 border-t">
                                        <span>Total Tagihan</span>
                                        <span>Rp
                                            {{ number_format($pemakaian->biaya_beban_pemakai + $pemakaian->biaya_pemakaian, 0, ',', '.') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Form -->
                        <form action="{{ route('pembayaran.entry') }}" method="POST">
                            @csrf
                            <input type="hidden" name="no_kontrol" value="{{ $pelanggan->no_kontrol }}">
                            <input type="hidden" name="tahun" value="{{ $pemakaian->tahun }}">
                            <input type="hidden" name="bulan" value="{{ $pemakaian->bulan }}">

                            <div class="flex justify-end gap-4">
                                @if (!$pemakaian->is_status)
                                    <button type="submit"
                                        class="px-6 py-3 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition-colors duration-200 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Konfirmasi Pembayaran
                                    </button>
                                @endif
                                @if ($pemakaian->is_status)
                                    <a href="{{ route('pembayaran.receipt', $pemakaian->id) }}"
                                        class="px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition-colors duration-200 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3v-13" />
                                        </svg>
                                        Download Struk
                                    </a>
                                @endif
                            </div>
                        </form>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-yellow-400 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <p class="text-yellow-700 font-medium">Data pemakaian belum tersedia.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
