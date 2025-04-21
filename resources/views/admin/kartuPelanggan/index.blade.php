<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Kartu Pelanggan') }}
      </h2>
      <a href="{{ route('pelanggan.create') }}"
        class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-blue-700 focus:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 active:bg-blue-900">
        <i class="fas fa-plus mr-2"></i>
        Tambah Pelanggan
      </a>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <!-- Search and Filter Section -->
          <div class="mb-6">
            <form action="{{ route('pelanggan.index') }}" method="GET">
              <div class="flex gap-4">
                <div class="flex-1">
                  <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                      class="w-full rounded-lg border border-gray-300 py-2 pl-10 pr-4 focus:border-blue-500 focus:ring-blue-500"
                      placeholder="Cari berdasarkan no kontrol, nama, atau alamat...">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                      <i class="fas fa-search text-gray-400"></i>
                    </div>
                  </div>
                </div>
                <button type="submit"
                  class="rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                  Cari
                </button>
              </div>
            </form>
          </div>

          <!-- Table Section -->
          <div class="overflow-hidden overflow-x-auto rounded-lg bg-white shadow">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">No</th>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">No Kontrol
                  </th>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nama</th>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Alamat</th>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Telepon</th>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Jenis</th>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($pelanggans as $pelanggan)
                  <tr class="hover:bg-gray-50">
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                      {{ $loop->iteration }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                      {{ $pelanggan->no_kontrol }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                      {{ $pelanggan->name }}
                    </td>
                    <td class="max-w-xs truncate px-6 py-4 text-sm text-gray-900">
                      {{ $pelanggan->alamat }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                      {{ $pelanggan->telepon }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                      <span
                        class="inline-flex rounded-full bg-blue-100 px-2 text-xs font-semibold leading-5 text-blue-800">
                        {{ $pelanggan->tarif->jenis_pelanggan->name }}
                      </span>
                    </td>
                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                      <a href="{{ route('pelanggan.show', $pelanggan->id) }}" class="text-blue-500 hover:underline">
                        <i class="fas fa-eye"></i> Detail
                      </a>
                      <a href="{{ route('pelanggan.edit', $pelanggan->id) }}"
                        class="ml-2 text-green-500 hover:underline">
                        <i class="fas fa-edit"></i> Edit
                      </a>
                      <form action="{{ route('pelanggan.destroy', $pelanggan->id) }}" method="POST"
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
                    <td colspan="7" class="whitespace-nowrap px-6 py-4 text-center text-sm text-gray-500">
                      Tidak ada data pelanggan
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <div class="mt-4">
            {{ $pelanggans->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
