<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inici') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @foreach ($images as $image)
                <div class="bg-white shadow sm:rounded-lg overflow-hidden">

                    <!-- Capçalera de la imatge amb l'usuari -->
                    <div class="flex items-center px-4 py-3">
                        <div class="font-semibold text-gray-800">
                            {{ $image->user->name }}
                        </div>
                        <div class="ml-auto text-sm text-gray-500">
                            {{ $image->created_at->diffForHumans() }}
                        </div>
                    </div>

                    <!-- Imatge -->
                    <img
                        src="{{ asset('storage/' . $image->image_path) }}"
                        alt="{{ $image->description }}"
                        class="w-full object-cover"
                    />

                    <!-- Descripció -->
                    @if ($image->description)
                        <div class="px-4 py-3 text-gray-700">
                            <span class="font-semibold">{{ $image->user->name }}</span>
                            {{ $image->description }}
                        </div>
                    @endif

                    <!-- Peu amb likes i comentaris -->
                    <div class="px-4 py-3 border-t border-gray-100 flex items-center gap-4 text-sm text-gray-600">
                        <span class="flex items-center">
                            <x-heroicon-o-heart class="w-5 h-5 mr-1 text-red-500" />
                            {{ $image->likes->count() }}
                        </span>

                        <span class="flex items-center">
                            <x-heroicon-o-chat-bubble-left class="w-5 h-5 mr-1 text-gray-500" />
                            {{ $image->comments->count() }}
                        </span>
                    </div>

                </div>
            @endforeach

            <!-- Paginació -->
            <div class="mt-4">
                {{ $images->links() }}
            </div>

        </div>
    </div>
</x-app-layout>