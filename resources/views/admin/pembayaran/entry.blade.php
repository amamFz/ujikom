<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Entri Pembayaran') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h3 class="mb-4 text-lg font-bold">Data Pelanggan</h3>
          <p><strong>No Kontrol:</strong> {{ $pelanggan->no_kontrol }}</p>
          <p><strong>Nama:</strong> {{ $pelanggan->name }}</p>
          <p><strong>Alamat:</strong> {{ $pelanggan->alamat }}</p>

          <h4 class="mb-4 mt-6 text-lg font-bold">Data Pemakaian</h4>
          @if ($pemakaian)
            <p><strong>Tahun:</strong> {{ $pemakaian->tahun }}</p>
            <p><strong>Bulan:</strong> {{ $pemakaian->bulan }}</p>
            <p><strong>Jumlah Pakai:</strong> {{ $pemakaian->jumlah_pakai }} kWh</p>
            <p><strong>Biaya Pemakaian:</strong> Rp {{ number_format($pemakaian->biaya_pemakaian, 0, ',', '.') }}</p>
          @else
            <p>Data pemakaian belum tersedia.</p>
          @endif

          <form action="{{ route('pembayaran.entry') }}" method="POST" class="mt-6">
            @csrf
            <input type="hidden" name="no_kontrol" value="{{ $pelanggan->no_kontrol }}">
            <input type="hidden" name="tahun" value="{{ $pemakaian->tahun ?? '' }}">
            <input type="hidden" name="bulan" value="{{ $pemakaian->bulan ?? '' }}">
            <div class="mb-4">
              <label for="jumlah_bayar" class="block text-gray-700">Jumlah Bayar</label>
              <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="w-full rounded-md border-gray-300"
                required>
            </div>
            <button type="submit" class="rounded-lg bg-green-500 px-4 py-2 text-white hover:bg-green-600">
              Simpan Pembayaran
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
