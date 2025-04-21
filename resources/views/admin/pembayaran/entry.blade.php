<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Entri Pembayaran') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
      <div class="overflow-hidden rounded-lg bg-white shadow-lg">
        <div class="p-8">
          <!-- Card Header with Customer Info -->
          <div class="mb-8 flex items-center justify-between border-b border-gray-200 pb-4">
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
          <div class="mb-8 rounded-lg bg-gray-50 p-6">
            <div class="grid gap-6 md:grid-cols-2">
              <div>
                <h4 class="mb-4 font-semibold text-gray-600">Informasi Pelanggan</h4>
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
                <h4 class="mb-4 font-semibold text-gray-600">Informasi Tarif</h4>
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

          @if ($currentPemakaian)
            <!-- Current Usage Details -->
            <div class="mb-8 rounded-lg border border-gray-200 bg-white p-6">
              <h4 class="mb-4 font-semibold text-gray-800">Tagihan Bulan Ini</h4>
              <div class="grid gap-6 md:grid-cols-2">
                <div class="space-y-3">
                  <p class="flex justify-between">
                    <span class="text-gray-600">Periode</span>
                    <span class="font-medium">
                      {{ date('F', mktime(0, 0, 0, $currentPemakaian->bulan, 1)) }}
                      {{ $currentPemakaian->tahun }}
                    </span>
                  </p>
                  <p class="flex justify-between">
                    <span class="text-gray-600">Meter Awal</span>
                    <span class="font-medium">{{ $currentPemakaian->meter_awal }}</span>
                  </p>
                  <p class="flex justify-between">
                    <span class="text-gray-600">Meter Akhir</span>
                    <span class="font-medium">{{ $currentPemakaian->meter_akhir }}</span>
                  </p>
                  <p class="flex justify-between">
                    <span class="text-gray-600">Jumlah Pakai</span>
                    <span class="font-medium">{{ $currentPemakaian->jumlah_pakai }} kWh</span>
                  </p>
                </div>
                <div class="space-y-3">
                  <p class="flex justify-between">
                    <span class="text-gray-600">Biaya Beban</span>
                    <span class="font-medium">Rp
                      {{ number_format($currentPemakaian->biaya_beban_pemakai, 0, ',', '.') }}</span>
                  </p>
                  <p class="flex justify-between">
                    <span class="text-gray-600">Biaya Pemakaian</span>
                    <span class="font-medium">Rp
                      {{ number_format($currentPemakaian->biaya_pemakaian, 0, ',', '.') }}</span>
                  </p>
                  <p class="flex justify-between border-t pt-3 text-lg font-bold text-blue-600">
                    <span>Total Tagihan Bulan Ini</span>
                    <span>Rp {{ number_format($currentBill, 0, ',', '.') }}</span>
                  </p>
                </div>
              </div>
            </div>

            <!-- Unpaid Bills Section -->
            @if ($unpaidBills->count() > 0)
              <div class="mb-8 rounded-lg border border-red-200 bg-red-50 p-6">
                <h4 class="mb-4 font-semibold text-red-800">Tunggakan Sebelumnya</h4>
                <div class="space-y-4">
                  @foreach ($unpaidBills as $bill)
                    <div class="flex items-center justify-between border-b border-red-200 pb-3">
                      <div>
                        <p class="text-red-700">
                          {{ date('F Y', mktime(0, 0, 0, $bill->bulan, 1, $bill->tahun)) }}
                        </p>
                        <p class="text-sm text-red-600">
                          Pemakaian: {{ $bill->jumlah_pakai }} kWh
                        </p>
                      </div>
                      <p class="font-semibold text-red-800">
                        Rp {{ number_format($bill->total_bayar, 0, ',', '.') }}
                      </p>
                    </div>
                  @endforeach
                  <div class="flex items-center justify-between pt-3 text-lg font-bold text-red-800">
                    <span>Total Tunggakan</span>
                    <span>Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</span>
                  </div>
                </div>
              </div>
            @endif

            <!-- Grand Total Section -->
            <div class="mb-8 rounded-lg border border-blue-200 bg-blue-50 p-6">
              <div class="flex items-center justify-between text-xl font-bold text-blue-800">
                <span>Total Pembayaran</span>
                <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
              </div>
            </div>

            <!-- Payment Form -->
            <form action="{{ route('pembayaran.entry') }}" method="POST">
              @csrf
              <input type="hidden" name="no_kontrol" value="{{ $pelanggan->no_kontrol }}">
              @foreach ($unpaidBills as $bill)
                <input type="hidden" name="pemakaian_ids[]" value="{{ $bill->id }}">
              @endforeach
              <input type="hidden" name="pemakaian_ids[]" value="{{ $currentPemakaian->id }}">

              <!-- Payment Form -->
              <div class="flex justify-end gap-4">
                @if (!$currentPemakaian->is_status)
                  <form action="{{ route('pembayaran.entry') }}" method="POST">
                    @csrf
                    <input type="hidden" name="no_kontrol" value="{{ $pelanggan->no_kontrol }}">
                    @foreach ($unpaidBills as $bill)
                      <input type="hidden" name="pemakaian_ids[]" value="{{ $bill->id }}">
                    @endforeach
                    <input type="hidden" name="pemakaian_ids[]" value="{{ $currentPemakaian->id }}">

                    <button type="submit"
                      class="flex items-center rounded-lg bg-green-500 px-6 py-3 font-semibold text-white transition-colors duration-200 hover:bg-green-600">
                      <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      Konfirmasi Pembayaran
                    </button>
                  </form>
                @else
                  <a href="{{ route('pembayaran.receipt', ['pemakaian' => $currentPemakaian->id]) }}"
                    class="flex items-center rounded-lg bg-blue-500 px-6 py-3 font-semibold text-white transition-colors duration-200 hover:bg-blue-600">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3v-13" />
                    </svg>
                    Download Struk
                  </a>
                @endif
              </div>
            </form>
          @else
            <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-6">
              <div class="flex items-center">
                <svg class="mr-3 h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="font-medium text-yellow-700">Data pemakaian belum tersedia.</p>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
