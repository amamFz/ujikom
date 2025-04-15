<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jenis Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('jenis_pelanggan.update', $jenisPelanggan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4 w-full flex flex-col">
                            <label for="name" class="mb-2 text-gray-600">Nama Jenis Pelanggan</label>
                            <input type="text" name="name" id="name"
                                class="rounded-md @error('name') border-red-500 @enderror"
                                value="{{ old('name', $jenisPelanggan->name) }}" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="submit"
                                class="bg-blue-500 px-4 py-2 rounded-lg text-white hover:bg-blue-600 transition-colors">
                                Update
                            </button>
                            <a href="{{ route('jenis_pelanggan.index') }}"
                                class="bg-gray-500 px-4 py-2 rounded-lg text-white hover:bg-gray-600 transition-colors">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
