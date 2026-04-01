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
                    <a href="{{ route('users.show', $image->user) }}" class="flex items-center gap-3 px-3 py-2 hover:bg-gray-50 transition">
                        @if ($image->user->avatar)
                            <img src="{{ asset('storage/' . $image->user->avatar) }}"
                                 alt="{{ $image->user->name }}"
                                 class="w-8 h-8 rounded-full object-cover" />
                        @else
                            <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white text-sm font-bold">
                                {{ strtoupper(substr($image->user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="font-semibold text-sm text-gray-800">{{ $image->user->name }}</div>
                        <div class="ml-auto text-xs text-gray-400">{{ $image->created_at->diffForHumans() }}</div>
                    </a>

                    <!-- Imatge clicable -->
                    <button class="w-full text-left open-modal" data-id="{{ $image->id }}">
                        <img src="{{ asset('storage/' . $image->image_path) }}"
                             alt="{{ $image->description }}"
                             class="w-full object-cover max-h-64" />
                    </button>

                    <!-- Peu -->
                    <div class="px-3 py-2 flex items-center gap-4 text-sm text-gray-600">
                        <!-- Like -->
                        <button
                            class="like-btn flex items-center gap-1 focus:outline-none"
                            data-id="{{ $image->id }}"
                            data-liked="{{ auth()->check() && $image->likes->contains('user_id', auth()->id()) ? 'true' : 'false' }}"
                            data-url="{{ route('likes.toggle', $image) }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="like-icon w-5 h-5 transition"
                                 fill="{{ auth()->check() && $image->likes->contains('user_id', auth()->id()) ? 'red' : 'none' }}"
                                 stroke="{{ auth()->check() && $image->likes->contains('user_id', auth()->id()) ? 'red' : 'currentColor' }}"
                                 viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                            <span class="like-count">{{ $image->likes->count() }}</span>
                        </button>

                        <!-- Comentaris clicables -->
                        <button class="open-modal flex items-center gap-1 focus:outline-none" data-id="{{ $image->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                            </svg>
                            <span>{{ $image->comments->count() }}</span>
                        </button>

                        @auth
                            @if ($image->user_id === auth()->id())
                                <a href="{{ route('posts.edit', $image) }}" class="ml-auto text-xs text-gray-400 hover:text-gray-600">
                                    {{ __('Editar') }}
                                </a>
                            @endif
                        @endauth
                    </div>

                    <!-- Descripció -->
                    @if ($image->description)
                        <div class="px-3 pb-3 text-xs text-gray-700">
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

    <!-- Importació de Modal -->
    @include('partials.post-modal')
</x-app-layout>