<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Pemakaian') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <div class="mb-6 flex items-center justify-between">
            <h3 class="text-xl font-semibold leading-tight text-gray-600">Daftar Pemakaian</h3>
            <a href="{{ route('pemakaian.create') }}" class="rounded-lg bg-blue-500 px-3 py-2 text-white">Tambah
              Pemakaian</a>
          </div>

          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 rtl:text-right">
                  No
                </th>
                <th scope="col" class="px-12 py-3.5 text-left text-sm font-normal text-gray-500 rtl:text-right">
                  No Kontrol
                </th>
                <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 rtl:text-right">
                  Tahun
                </th>
                <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 rtl:text-right">
                  Bulan
                </th>
                <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 rtl:text-right">
                  Meter Awal
                </th>
                <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 rtl:text-right">
                  Meter Akhir
                </th>
                <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 rtl:text-right">
                  Jumlah Pemakaian
                </th>
                <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 rtl:text-right">
                  Biaya Beban Pemakaian
                </th>
                <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 rtl:text-right">
                  Biaya Pemakaian
                </th>
                </th>

                <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 rtl:text-right">
                  Aksi
                </th>


              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              @foreach ($pemakaians as $pemakaian)
                <tr>
                  <td class="whitespace-nowrap px-4 py-4 text-sm">
                    <p class="text-sm font-normal text-gray-600">
                      {{ $loop->index + 1 }}</p>
                  </td>
                  <td class="whitespace-nowrap px-4 py-4 text-sm">
                    <p class="text-sm font-normal text-gray-600">
                      {{ $pemakaian->pelanggan->no_kontrol }}</p>
                  </td>
                  <td class="whitespace-nowrap px-4 py-4 text-sm">
                    <p class="text-sm font-normal text-gray-600">
                      {{ $pemakaian->tahun }}</p>
                  </td>
                  <td class="whitespace-nowrap px-4 py-4 text-sm">
                    <p class="text-sm font-normal text-gray-600">
                      {{ $pemakaian->bulan }}</p>
                  </td>
                  <td class="whitespace-nowrap px-4 py-4 text-sm">
                    <p class="text-sm font-normal text-gray-600">
                      {{ $pemakaian->meter_awal }}</p>
                  </td>
                  <td class="whitespace-nowrap px-4 py-4 text-sm">
                    <p class="text-sm font-normal text-gray-600">
                      {{ $pemakaian->meter_akhir }}</p>
                  </td>
                  <td class="whitespace-nowrap px-4 py-4 text-sm">
                    <p class="text-sm font-normal text-gray-600">
                      {{ $pemakaian->jumlah_pakai }}</p>
                  </td>
                  <td class="whitespace-nowrap px-4 py-4 text-sm">
                    <p class="text-sm font-normal text-gray-600">
                      {{ 'Rp ' . number_format($pemakaian->pelanggan->tarif->biaya_beban, 0, ',', '.') }}
                    </p>
                  </td>
                  <td class="whitespace-nowrap px-4 py-4 text-sm">
                    <p class="text-sm font-normal text-gray-600">
                      {{ 'Rp ' . number_format($pemakaian->biaya_pemakaian, 0, ',', '.') }}
                    </p>
                  </td>
                  </td>
                  <td class="whitespace-nowrap px-4 py-4 text-sm">
                    <a href="{{ route('pemakaian.show', $pemakaian->id) }}"class="text-sm font-normal text-gray-600">
                      Detail
                    </a>
                    <a href="{{ route('pemakaian.edit', $pemakaian->id) }}"class="text-sm font-normal text-gray-600">
                      Edit
                    </a>
                    <form action="{{ route('pemakaian.destroy', $pemakaian->id) }}" method="POST"
                      onsubmit="apakah anda ingin mengapusnya">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-sm font-normal text-gray-600">
                        Delete
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
