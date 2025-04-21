<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Data Pemakaian Listrik') }}
      </h2>
      <div class="flex space-x-3">
        <a href="{{ route('pemakaian.create') }}"
          class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-blue-700 focus:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-blue-900">
          <i class="fas fa-plus mr-2"></i> Tambah Pemakaian
        </a>
        <a href="{{ route('pemakaian.report', [
            'tahun' => request('tahun', date('Y')),
            'bulan' => request('bulan', date('n')),
            'status' => request('status'),
        ]) }}"
          class="inline-flex items-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-green-700 focus:bg-green-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-green-900">
          <i class="fas fa-file-pdf mr-2"></i> Generate Report
        </a>
        <a href="{{ route('pemakaian.report.all') }}"
          class="inline-flex items-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-green-700 focus:bg-green-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-green-900">
          <i class="fas fa-file-pdf mr-2"></i> Generate All Report
        </a>
      </div>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6">
          <!-- Filter Section -->
          <div class="mb-8 rounded-lg border border-gray-200 bg-gray-50 p-4">
            <h3 class="mb-4 text-lg font-medium text-gray-900">Filter Data</h3>
            <form action="{{ route('pemakaian.index') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-4">
              <div>
                <label for="tahun" class="mb-1 block text-sm font-medium text-gray-700">Tahun</label>
                <select name="tahun" id="tahun"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                  @foreach (range(date('Y') - 5, date('Y')) as $year)
                    <option value="{{ $year }}" {{ request('tahun', date('Y')) == $year ? 'selected' : '' }}>
                      {{ $year }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div>
                <label for="bulan" class="mb-1 block text-sm font-medium text-gray-700">Bulan</label>
                <select name="bulan" id="bulan"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                  @foreach (range(1, 12) as $month)
                    <option value="{{ $month }}" {{ request('bulan', date('n')) == $month ? 'selected' : '' }}>
                      {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div>
                <label for="status" class="mb-1 block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                  <option value="">Semua Status</option>
                  <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Sudah
                    Bayar</option>
                  <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Belum
                    Bayar</option>
                </select>
              </div>

              <div class="flex items-end">
                <button type="submit"
                  class="w-full rounded-md bg-blue-600 px-4 py-2 text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                  <i class="fas fa-filter mr-2"></i> Filter
                </button>
              </div>
            </form>
          </div>

          <!-- Table Section -->
          <div class="overflow-x-auto rounded-lg bg-white shadow">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                    No</th>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                    No Kontrol</th>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                    Periode</th>
                  <th scope="col"
                    class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                    Meter Awal</th>
                  <th scope="col"
                    class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                    Meter Akhir</th>
                  <th scope="col"
                    class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                    Pemakaian</th>
                  <th scope="col"
                    class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                    Total Bayar</th>
                  <th scope="col"
                    class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500">
                    Status</th>
                  <th scope="col"
                    class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500">
                    Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($pemakaians as $index => $pemakaian)
                  <tr class="hover:bg-gray-50">
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                      {{ $index + 1 }}</td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                      {{ $pemakaian->pelanggan->no_kontrol }}</td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                      {{ date('F Y', mktime(0, 0, 0, $pemakaian->bulan, 1, $pemakaian->tahun)) }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-gray-900">
                      {{ number_format($pemakaian->meter_awal) }}</td>
                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-gray-900">
                      {{ number_format($pemakaian->meter_akhir) }}</td>
                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-gray-900">
                      {{ number_format($pemakaian->jumlah_pakai) }}</td>
                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-gray-900">Rp
                      {{ number_format($pemakaian->total_bayar, 0, ',', '.') }}</td>
                    <td class="whitespace-nowrap px-6 py-4 text-center text-sm">
                      <span
                        class="{{ $pemakaian->is_status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} inline-flex rounded-full px-2 text-xs font-semibold leading-5">
                        {{ $pemakaian->is_status ? 'Lunas' : 'Belum Lunas' }}
                      </span>
                    </td>
                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                      <a href="{{ route('pemakaian.show', $pemakaian->id) }}" class="text-blue-500 hover:underline">
                        <i class="fas fa-eye"></i> Detail
                      </a>
                      <a href="{{ route('pemakaian.edit', $pemakaian->id) }}"
                        class="ml-2 text-green-500 hover:underline">
                        <i class="fas fa-edit"></i> Edit
                      </a>
                      <a href="{{ route('pemakaian.report.pdf', $pemakaian->id) }}"
                        class="ml-2 text-yellow-500 hover:underline">
                        <i class="fas fa-edit"></i> Export
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
                @empty
                  <tr>
                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                      Tidak ada data pemakaian
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          @if ($pemakaians->hasPages())
            <div class="mt-4">
              {{ $pemakaians->links() }}
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
