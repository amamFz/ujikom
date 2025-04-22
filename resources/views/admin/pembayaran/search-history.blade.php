<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Riwayat Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-lg rounded-lg">
                <div class="p-6">
                    {{-- Error Messages --}}
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    {{-- Warning Message --}}
                    @if (session('warning'))
                        <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                            <p>{{ session('warning') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('pembayaran.search.history') }}" method="GET" class="space-y-6">
                        <div>
                            <label for="no_kontrol" class="block text-sm font-medium text-gray-700">
                                Nomor Kontrol Pelanggan
                            </label>
                            <div class="mt-1">
                                <input type="text" name="no_kontrol" id="no_kontrol"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('no_kontrol') border-red-500 @enderror"
                                    placeholder="Masukkan nomor kontrol"
                                    value="{{ old('no_kontrol') }}"
                                    required>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cari Riwayat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
