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
          <form action="{{ route('pembayaran.search') }}" method="GET">
            <div class="mb-4">
              <label for="no_kontrol" class="block text-gray-700">No Kontrol</label>
              <input type="text" name="no_kontrol" id="no_kontrol" class="w-full rounded-md border-gray-300"
                required>
            </div>
            <button type="submit" class="rounded-lg bg-blue-500 px-4 py-2 text-white hover:bg-blue-600">
              Cari
            </button>
          </form>
          @if ($errors->any())
            <div class="text-red-500">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
