<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Detail Data Pemakaian') }}
      </h2>
      <a href="{{ route('pemakaian.report.pdf', $pemakaian->id) }}" target="_blank"
        class="flex items-center gap-2 rounded-lg bg-red-500 px-4 py-2 text-white transition-colors hover:bg-red-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd"
            d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586L7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
            clip-rule="evenodd" />
        </svg>
        Export PDF
      </a>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-8 text-gray-900">
          <div class="grid grid-cols-3 gap-6">
            <div class="space-y-6">
              <div class="rounded-lg bg-gray-50 p-4">
                <label class="block text-sm font-semibold text-gray-600">No Kontrol</label>
                <p class="mt-1 text-lg font-medium text-gray-800">{{ $pemakaian->no_kontrol_id }}</p>
              </div>

              <div class="rounded-lg bg-gray-50 p-4">
                <label class="block text-sm font-semibold text-gray-600">Nama Pelanggan</label>
                <p class="mt-1 text-lg font-medium text-gray-800">{{ $pemakaian->pelanggan->name }}</p>
              </div>

              <div class="rounded-lg bg-gray-50 p-4">
                <label class="block text-sm font-semibold text-gray-600">Tahun</label>
                <p class="mt-1 text-lg font-medium text-gray-800">{{ $pemakaian->tahun }}</p>
              </div>
            </div>

            <div class="space-y-6">
              <div class="rounded-lg bg-gray-50 p-4">
                <label class="block text-sm font-semibold text-gray-600">Bulan</label>
                <p class="mt-1 text-lg font-medium text-gray-800">
                  {{ date('F', mktime(0, 0, 0, $pemakaian->bulan, 1)) }}
                </p>
              </div>

              <div class="rounded-lg bg-gray-50 p-4">
                <label class="block text-sm font-semibold text-gray-600">Meter Awal</label>
                <p class="mt-1 text-lg font-medium text-gray-800">{{ $pemakaian->meter_awal }}</p>
              </div>

              <div class="rounded-lg bg-gray-50 p-4">
                <label class="block text-sm font-semibold text-gray-600">Meter Akhir</label>
                <p class="mt-1 text-lg font-medium text-gray-800">{{ $pemakaian->meter_akhir }}</p>
              </div>
            </div>

            <div class="space-y-6">
              <div class="rounded-lg bg-gray-50 p-4">
                <label class="block text-sm font-semibold text-gray-600">Jumlah Pemakaian</label>
                <p class="mt-1 text-lg font-medium text-gray-800">{{ $pemakaian->jumlah_pakai }}</p>
              </div>

              <div class="rounded-lg bg-gray-50 p-4">
                <label class="block text-sm font-semibold text-gray-600">Biaya Beban Pemakaian</label>
                <p class="mt-1 text-lg font-medium text-gray-800">
                  Rp {{ number_format($pemakaian->biaya_beban_pemakai, 2, ',', '.') }}
                </p>
              </div>

              <div class="rounded-lg bg-gray-50 p-4">
                <label class="block text-sm font-semibold text-gray-600">Biaya Pemakaian</label>
                <p class="mt-1 text-lg font-medium text-gray-800">
                  Rp {{ number_format($pemakaian->biaya_pemakaian, 2, ',', '.') }}
                </p>
              </div>
            </div>
          </div>

          <div class="mt-8 flex items-center gap-2">
            <a href="{{ route('pemakaian.edit', $pemakaian->id) }}"
              class="rounded-lg bg-yellow-500 px-4 py-2 text-white transition-colors hover:bg-yellow-600">
              Edit
            </a>
            <a href="{{ route('pemakaian.index') }}"
              class="rounded-lg bg-gray-500 px-4 py-2 text-white transition-colors hover:bg-gray-600">
              Kembali
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
