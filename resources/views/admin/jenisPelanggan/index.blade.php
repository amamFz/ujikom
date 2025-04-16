<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Jenis Pelanggan') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <div class="mb-6 flex items-center justify-between">
            <h3 class="text-xl font-semibold leading-tight text-gray-600">Daftar Jenis Pelanggan</h3>
            <a href="{{ route('jenis_pelanggan.create') }}"
              class="rounded-lg bg-blue-500 px-3 py-2 text-white transition hover:bg-blue-600">
              Tambah Jenis Pelanggan
            </a>
          </div>

          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-12 py-3.5 text-left text-sm font-normal text-gray-500">
                    No
                  </th>
                  <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500">
                    Nama Jenis Pelanggan
                  </th>
                  <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500">
                    Aksi
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($pelanggans as $pelanggan)
                  <tr class="hover:bg-gray-100">
                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                      {{ $loop->index + 1 }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                      {{ $pelanggan->name }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                      <a href="{{ route('jenis_pelanggan.show', $pelanggan->id) }}"
                        class="text-blue-500 hover:underline">
                        <i class="fas fa-eye"></i> Detail
                      </a>
                      <a href="{{ route('jenis_pelanggan.edit', $pelanggan->id) }}"
                        class="ml-2 text-green-500 hover:underline">
                        <i class="fas fa-edit"></i> Edit
                      </a>
                      <form action="{{ route('jenis_pelanggan.destroy', $pelanggan->id) }}" method="POST"
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
