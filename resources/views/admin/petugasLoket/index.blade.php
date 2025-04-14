<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-semibold text-xl text-gray-600 leading-tight">Daftar Account</h3>
                        <a href="{{ route('users.create') }}" class="py-2 px-3 bg-blue-500 text-white rounded-lg">Tambah
                            Account</a>
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
                                    Username
                                </th>
                                <th scope="col"
                                    class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 rtl:text-right">
                                    Email
                                </th>
                                <th scope="col"
                                    class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 rtl:text-right">
                                    Password
                                </th>
                                </th>
                                <th scope="col"
                                    class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 rtl:text-right">
                                    Role
                                </th>
                                <th scope="col"
                                    class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 rtl:text-right">
                                    Aksi
                                </th>


                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                                        <p class="text-sm font-normal text-gray-600">
                                            {{ $loop->index + 1 }}</p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                                        <p class="text-sm font-normal text-gray-600">
                                            {{ $user->name }}</p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                                        <p class="text-sm font-normal text-gray-600">
                                            {{ $user->email }}</p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                                        <p class="text-sm font-normal text-gray-600">
                                            {{ $user->password }}</p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                                        <p class="text-sm font-normal text-gray-600">
                                            {{ $user->role }}</p>
                                    </td>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-4 text-sm">
                                        <a
                                            href="{{ route('users.show', $user->id) }}"class="text-sm font-normal text-gray-600">
                                            Detail
                                        </a>
                                        <a
                                            href="{{ route('users.edit', $user->id) }}"class="text-sm font-normal text-gray-600">
                                            Edit
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                            onsubmit="apakah anda ingin mengapusnya">
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
