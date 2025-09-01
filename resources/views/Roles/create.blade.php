<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles/Create') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('roles.store') }}">
                        @csrf

                        <!-- Role Name -->
                        <div>
                            <x-input-label for="name" :value="__('Role Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Permissions -->
                        <div class="mt-6">
                            <x-input-label :value="__('Assign Permissions')" />

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-2">
                                @foreach($permissions as $permission)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                               {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                        <span>{{ $permission->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('permissions')" class="mt-2" />
                        </div>

                        <!-- Submit -->
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Create Role') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
