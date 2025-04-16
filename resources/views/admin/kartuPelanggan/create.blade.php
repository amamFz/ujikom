<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Membuat Pelanggan') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <form action="{{ route('pelanggan.store') }}" method="POST">
            @csrf
            <div class="mb-4 flex w-full flex-col">
              <label for="no_kontrol" class="mb-2 text-gray-600">No Kontrol</label>
              <input type="text" name="no_kontrol" id="no_kontrol" class="rounded-md bg-gray-100"
                value="{{ $no_kontrol }}" readonly>
            </div>

            <div class="mb-4 flex w-full flex-col">
              <label for="name" class="mb-2 text-gray-600">Nama</label>
              <input type="text" name="name" id="name"
                class="@error('name') border-red-500 @enderror rounded-md" value="{{ old('name') }}" required>
              @error('name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
              @enderror
            </div>

            <div class="mb-4 flex w-full flex-col">
              <label for="alamat" class="mb-2 text-gray-600">Alamat</label>
              <textarea name="alamat" id="alamat" class="@error('alamat') border-red-500 @enderror rounded-md" rows="3">{{ old('alamat') }}</textarea>
              @error('alamat')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
              @enderror
            </div>

            <div class="mb-4 flex w-full flex-col">
              <label for="telepon" class="mb-2 text-gray-600">Telepon</label>
              <input type="number" name="telepon" id="telepon"
                class="@error('telepon') border-red-500 @enderror rounded-md" value="{{ old('telepon') }}" required
                pattern="[0-9]{8,16}">
              @error('telepon')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
              @enderror
            </div>

            <div class="mb-4 flex w-full flex-col">
              <label for="jenis_plg_id" class="mb-2 text-gray-600">Jenis Pelanggan</label>

              <select name="jenis_plg_id" id="jenis_plg_id" class="form-control"
                class="@error('jenis_plg_id') border-red-500 @enderror rounded-md">
                <option value="">Pilih Jenis Pelanggan</option>
                @foreach ($tarifs as $tarif)
                  <option value="{{ $tarif->id }}"
                    {{ old('jenis_plg_id', $pelanggan->jenis_plg_id ?? '') == $tarif->id ? 'selected' : '' }}>
                    {{ $tarif->jenis_pelanggan->name }} 
                  </option>
                @endforeach
              </select>
              @error('jenis_plg_id')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
              @enderror
            </div>

            <div class="flex items-center gap-2">
              <button type="submit"
                class="rounded-lg bg-blue-500 px-4 py-2 text-white transition-colors hover:bg-blue-600">
                Simpan
              </button>
              <a href="{{ route('pelanggan.index') }}"
                class="rounded-lg bg-gray-500 px-4 py-2 text-white transition-colors hover:bg-gray-600">
                Batal
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
