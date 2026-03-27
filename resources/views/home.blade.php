<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inici') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8 space-y-4">

            @foreach ($images as $image)
                <div class="bg-white shadow sm:rounded-lg overflow-hidden">

                    <!-- Capçalera amb l'usuari -->
                    <div class="flex items-center px-3 py-2">
                        <div class="font-semibold text-sm text-gray-800">
                            {{ $image->user->name }}
                        </div>
                        <div class="ml-auto text-xs text-gray-400">
                            {{ $image->created_at->diffForHumans() }}
                        </div>
                    </div>

                    <!-- Imatge -->
                    <img
                        src="{{ asset('storage/' . $image->image_path) }}"
                        alt="{{ $image->description }}"
                        class="w-full object-cover max-h-64"
                    />

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

                    <!-- Descripció -->
                    @if ($image->description)
                        <div class="px-3 pb-2 text-xs text-gray-700">
                            <span class="font-semibold">{{ $image->user->name }}</span>
                            {{ $image->description }}
                        </div>
                    @endif

                </div>
            @endforeach

            <!-- Paginació -->
            <div class="mt-4">
                {{ $images->links() }}
            </div>

        </div>
    </div>
</x-app-layout>