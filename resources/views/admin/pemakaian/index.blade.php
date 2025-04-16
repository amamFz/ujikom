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
            <a href="{{ route('pemakaian.create') }}"
              class="rounded-lg bg-blue-500 px-3 py-2 text-white transition hover:bg-blue-600">
              Tambah Pemakaian
            </a>
          </div>

          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500">No</th>
                  <th scope="col" class="px-12 py-3.5 text-left text-sm font-normal text-gray-500">No Kontrol</th>
                  <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500">Tahun</th>
                  <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500">Bulan</th>
                  <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500">Meter Awal</th>
                  <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500">Meter Akhir</th>
                  <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500">Jumlah Pemakaian
                  </th>
                  <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500">Biaya Beban</th>
                  <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500">Biaya Pemakaian
                  </th>
                  <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500">Total Bayar</th>
                  <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500">Status</th>
                  <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($pemakaians as $pemakaian)
                  <tr class="hover:bg-gray-100">
                    <td class="whitespace-nowrap px-4 py-4 text-sm">{{ $loop->index + 1 }}</td>
                    <td class="whitespace-nowrap px-4 py-4 text-sm">{{ $pemakaian->pelanggan->no_kontrol }}</td>
                    <td class="whitespace-nowrap px-4 py-4 text-sm">{{ $pemakaian->tahun }}</td>
                    <td class="whitespace-nowrap px-4 py-4 text-sm">{{ $pemakaian->bulan }}</td>
                    <td class="whitespace-nowrap px-4 py-4 text-sm">{{ $pemakaian->meter_awal }}</td>
                    <td class="whitespace-nowrap px-4 py-4 text-sm">{{ $pemakaian->meter_akhir }}</td>
                    <td class="whitespace-nowrap px-4 py-4 text-sm">{{ $pemakaian->jumlah_pakai }}</td>
                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                      {{ 'Rp ' . number_format($pemakaian->pelanggan->tarif->biaya_beban, 0, ',', '.') }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                      {{ 'Rp ' . number_format($pemakaian->biaya_pemakaian, 0, ',', '.') }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                      {{ 'Rp ' . number_format($pemakaian->total_bayar, 0, ',', '.') }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                      @if ($pemakaian->is_status == 0)
                        Belum Bayar
                      @elseif($pemakaian->is_status == 1)
                        Sudah Bayar
                      @else
                        Dibatalkan
                      @endif
                    </td>
                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                      <a href="{{ route('pemakaian.show', $pemakaian->id) }}" class="text-blue-500 hover:underline">
                        <i class="fas fa-eye"></i> Detail
                      </a>
                      <a href="{{ route('pemakaian.edit', $pemakaian->id) }}"
                        class="ml-2 text-green-500 hover:underline">
                        <i class="fas fa-edit"></i> Edit
                      </a>
                      <form action="{{ route('pemakaian.destroy', $pemakaian->id) }}" method="POST"
                        class="ml-2 inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapusnya?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">
                          <i class="fas fa-trash"></i> Delete
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
  </div>
</x-app-layout>
