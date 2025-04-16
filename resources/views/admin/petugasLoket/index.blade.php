<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Account') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <div class="mb-6 flex items-center justify-between">
            <h3 class="text-xl font-semibold leading-tight text-gray-600">Daftar Account</h3>
            <a href="{{ route('users.create') }}"
              class="rounded-lg bg-blue-500 px-3 py-2 text-white transition hover:bg-blue-600">
              Tambah Account
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
                    Username
                  </th>
                  <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500">
                    Email
                  </th>
                  <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500">
                    Role
                  </th>
                  <th scope="col" class="px-4 py-3.5 text-left text-sm font-normal text-gray-500">
                    Aksi
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
                @foreach ($users as $user)
                  <tr class="hover:bg-gray-100">
                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                      {{ $loop->index + 1 }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                      {{ $user->name }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                      {{ $user->email }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                      {{ $user->role }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                      <a href="{{ route('users.show', $user->id) }}" class="text-blue-500 hover:underline">
                        <i class="fas fa-eye"></i> Detail
                      </a>
                      <a href="{{ route('users.edit', $user->id) }}" class="ml-2 text-green-500 hover:underline">
                        <i class="fas fa-edit"></i> Edit
                      </a>
                      <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="ml-2 inline-block"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapusnya?')">
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
