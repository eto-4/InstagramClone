<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detall de la imatge') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg overflow-hidden flex flex-col md:flex-row">

                <!-- Imatge -->
                <div class="md:w-1/2">
                    <img
                        src="{{ asset('storage/' . $image->image_path) }}"
                        alt="{{ $image->description }}"
                        class="w-full h-full object-cover"
                    />
                </div>

                <!-- Informació -->
                <div class="md:w-1/2 flex flex-col">

                    <!-- Capçalera usuari -->
                    <div class="flex items-center px-4 py-3 border-b border-gray-100">
                        <div class="font-semibold text-sm text-gray-800">
                            {{ $image->user->name }}
                        </div>
                        <div class="ml-auto text-xs text-gray-400">
                            {{ $image->created_at->diffForHumans() }}
                        </div>
                    </div>

                    <!-- Descripció -->
                    @if ($image->description)
                        <div class="px-4 py-3 text-sm text-gray-700 border-b border-gray-100">
                            <span class="font-semibold">{{ $image->user->name }}</span>
                            {{ $image->description }}
                        </div>
                    @endif

                    <!-- Llista de comentaris -->
                    <div class="flex-1 overflow-y-auto px-4 py-3 space-y-3 max-h-64">
                        @forelse ($image->comments->sortBy('created_at') as $comment)
                            <div class="text-sm text-gray-700">
                                <span class="font-semibold">{{ $comment->user->name }}</span>
                                {{ $comment->body }}
                                <div class="text-xs text-gray-400 mt-1">
                                    {{ $comment->created_at->diffForHumans() }}
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">{{ __('Encara no hi ha comentaris.') }}</p>
                        @endforelse
                    </div>

                    <!-- Likes -->
                    <div class="px-4 py-2 border-t border-gray-100 text-sm text-gray-600">
                        {{ $image->likes->count() }} likes
                    </div>

                    <!-- Formulari de comentari -->
                    @auth
                        <div class="px-4 py-3 border-t border-gray-100">
                            <form method="POST" action="{{ route('comments.store', $image) }}">
                                @csrf
                                <div class="flex gap-2">
                                    <input
                                        type="text"
                                        name="body"
                                        placeholder="{{ __('Afegeix un comentari...') }}"
                                        class="flex-1 text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                                        required
                                    />
                                    <x-primary-button>
                                        {{ __('Enviar') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    @endauth

                </div>
            </div>

            <!-- Botó tornar -->
            <div class="mt-4">
                <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                    ← {{ __('Tornar a l\'inici') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>