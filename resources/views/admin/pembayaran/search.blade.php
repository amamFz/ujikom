<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Cari Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="mb-4 rounded-md bg-red-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        Terdapat beberapa kesalahan:
                                    </h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc space-y-1 pl-5">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <form action="{{ route('pembayaran.search') }}" method="GET" class="space-y-4">
                        <!-- No Kontrol -->
                        <div>
                            <label for="no_kontrol" class="block text-sm font-medium text-gray-700">No Kontrol</label>
                            <input type="text" name="no_kontrol" id="no_kontrol"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('no_kontrol') border-red-500 @enderror"
                                value="{{ old('no_kontrol') }}"
                                required>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <!-- Tahun -->
                            <div>
                                <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                                <select name="tahun" id="tahun"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Pilih Tahun</option>
                                    @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                        <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Bulan -->
                            <div>
                                <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                                <select name="bulan" id="bulan"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Pilih Bulan</option>
                                    @foreach (range(1, 12) as $month)
                                        <option value="{{ $month }}" {{ request('bulan') == $month ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit"
                                class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-search mr-2"></i> Cari
                            </button>
                        </div>
                    </form>

                    {{-- @if ($errors->any())
                        <div class="mt-4 rounded-md bg-red-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        Terdapat beberapa kesalahan:
                                    </h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc space-y-1 pl-5">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
