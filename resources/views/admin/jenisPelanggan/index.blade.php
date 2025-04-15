<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jenis Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-semibold text-xl text-gray-600 leading-tight">Daftar Jenis Pelanggan</h3>
                        <a href="{{ route('jenis_pelanggan.create') }}"
                            class="py-2 px-3 bg-blue-500 text-white rounded-lg">Tambah
                            Jenis Pelanggan</a>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>

                                <th scope="col"
                                    class="px-12 py-3.5 text-left text-sm font-normal text-gray-500 rtl:text-right">
                                    No
                                </th>
                                <th scope="col"
                                    class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 rtl:text-right">
                                    Nama Jeni Pelanggan
                                </th>

                                <th scope="col"
                                    class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 rtl:text-right">
                                    Aksi
                                </th>


                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($pelanggans as $pelanggan)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                                        <p class="text-sm font-normal text-gray-600">
                                            {{ $loop->index + 1 }}</p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                                        <p class="text-sm font-normal text-gray-600">
                                            {{ $pelanggan->name }}</p>
                                    </td>

                                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                                        <a
                                            href="{{ route('jenis_pelanggan.show', $pelanggan->id) }}"class="text-sm font-normal text-gray-600">
                                            Detail
                                        </a>
                                        <a
                                            href="{{ route('jenis_pelanggan.edit', $pelanggan->id) }}"class="text-sm font-normal text-gray-600">
                                            Edit
                                        </a>
                                        <form action="{{ route('jenis_pelanggan.destroy', $pelanggan->id) }}"
                                            method="POST" onsubmit="apakah anda ingin mengapusnya">
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
