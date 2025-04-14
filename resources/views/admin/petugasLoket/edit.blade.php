<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Perbarui Account') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-semibold text-xl text-gray-600 leading-tight">Tambah Account</h3>
                    </div>
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4 w-full flex flex-col">
                            <label for="name" class="mb-2 text-gray-600">Nama</label>
                            <input type="text" name="name" id="name"
                                class="rounded-md @error('name') border-red-500 @enderror" value="{{ $user->name }}"
                                required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4 w-full flex flex-col">
                            <label for="email" class="mb-2 text-gray-600">Email</label>
                            <input type="email" name="email" id="email"
                                class="rounded-md @error('email') border-red-500 @enderror" value="{{ $user->email }}"
                                required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4 w-full flex flex-col">
                            <label for="password" class="mb-2 text-gray-600">Password</label>
                            <input type="password" name="password" id="password"
                                class="rounded-md @error('password') border-red-500 @enderror"
                                value="{{ $user->password }}" required>
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4 w-full flex flex-col">
                            <label for="role" class="mb-2 text-gray-600">Role</label>
                            <select name="role" id="role"
                                class="rounded-md @error('role') border-red-500 @enderror" required>
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>
                                    Petugas</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-2">
                            <button
                                class="bg-blue-500 px-4 py-2 rounded-lg text-white hover:bg-blue-600 transition-colors"
                                type="submit">
                                Perbarui
                            </button>
                            <a href="{{ route('users.index') }}"
                                class="bg-gray-500 px-4 py-2 rounded-lg text-white hover:bg-gray-600 transition-colors">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
