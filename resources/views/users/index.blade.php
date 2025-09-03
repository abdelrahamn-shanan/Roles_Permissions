<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Messages --}}
                    <x-messages />

                    {{-- users Table --}}
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-6 py-3 border text-left text-sm font-medium">#</th>
                                    <th class="px-6 py-3 border text-left text-sm font-medium">Name</th>
                                    <th class="px-6 py-3 border text-left text-sm font-medium">Email</th>
                                    <th class="px-6 py-3 border text-left text-sm font-medium">Roles</th>
                                    <th class="px-6 py-3 border text-left text-sm font-medium">Created</th>
                                    <th class="px-6 py-3 border text-center text-sm font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 border">{{ $user->id }}</td>
                                        <td class="px-6 py-4 border">{{ $user->name }}</td>
                                        <td class="px-6 py-4 border">{{ $user->email }}</td>
                                        <td class="px-6 py-4 border">
                                            @foreach($user->roles as $role)
                                                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1">
                                                    {{ $role->name }}
                                                </span>
                                            @endforeach
                                        <td class="px-6 py-4 border">{{ $user->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4 border text-center flex justify-center items-center gap-2">

                                            {{-- Edit Button --}}
                                            <a href="{{ route('users.edit', $user->id) }}"  
                                            class="px-4 py-2 bg-green-600 text-blue text-sm font-medium rounded-lg shadow hover:bg-green-700 transition">
                                                Edit
                                            </a>
                                            
                                            {{-- Delete Form --}}
                                            <form action="{{ route('users.destroy', $user->id) }}" 
                                                method="POST" 
                                                class="inline-block"
                                                onsubmit="return confirm('Are you sure you want to delete this permission?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg shadow hover:bg-red-700 transition">
                                                    Delete
                                                </button>
                                            </form>

                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                            No users found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $users->links() }} {{-- Pagination links --}}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
