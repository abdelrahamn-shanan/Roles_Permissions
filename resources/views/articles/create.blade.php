<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Articles/Create') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('articles.store') }}">
                        @csrf

                        <!-- Article Name -->
                        <div>
                            <x-input-label for="name" :value="__('Article Name')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Article Content -->
                        <div>
                            <x-input-label for="name" :value="__('Article Content')" />
                            <x-text-area-input id="text" class="block mt-1 w-full" type="text" name="text" :value="old('text')" autofocus />
                            <x-input-error :messages="$errors->get('text')" class="mt-2" />
                        </div>



                        <!-- Article Author -->
                        <div>
                            <x-input-label for="name" :value="__('Article Author')" />
                            <x-text-input id="author" class="block mt-1 w-full" type="text" name="author" :value="old('author')" autofocus />
                            <x-input-error :messages="$errors->get('author')" class="mt-2" />
                        </div>

                        <!-- Submit -->
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Create Article') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
