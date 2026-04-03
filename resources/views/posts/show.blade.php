<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Publicació') }}
        </h2>
    </x-slot>

    <div class="flex items-center justify-center px-4" style="min-height: calc(100vh - 200px);">
        <div class="max-w-4xl w-full">
            <div class="bg-white shadow sm:rounded-lg overflow-hidden flex flex-col md:flex-row" style="min-height: 500px;">

                <!-- Imatge esquerra -->
                <div class="md:w-1/2 bg-black flex items-center justify-center">
                    <img
                        src="{{ asset('storage/' . $image->image_path) }}"
                        alt="{{ $image->description }}"
                        class="w-full h-full object-contain"
                        style="max-height: 600px;"
                    />
                </div>

                <!-- Contingut dreta -->
                <div class="md:w-1/2 flex flex-col" style="max-height: 600px;">

                    <!-- Capçalera usuari -->
                    <div class="flex items-center gap-3 px-4 py-3 border-b border-gray-100">
                        <a href="{{ route('users.show', $image->user) }}" class="flex items-center gap-3 hover:opacity-80 transition">
                            @if ($image->user->avatar)
                                <img src="{{ asset('storage/' . $image->user->avatar) }}"
                                     alt="{{ $image->user->name }}"
                                     class="w-9 h-9 rounded-full object-cover" />
                            @else
                                <div class="w-9 h-9 rounded-full bg-indigo-500 flex items-center justify-center text-white text-sm font-bold">
                                    {{ strtoupper(substr($image->user->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="font-semibold text-sm text-gray-800">{{ $image->user->name }}</span>
                        </a>
                        <span class="ml-auto text-xs text-gray-400">{{ $image->created_at->diffForHumans() }}</span>
                    </div>

                    <!-- Descripció -->
                    @if ($image->description)
                        <div class="px-4 py-3 text-sm text-gray-700 border-b border-gray-100">
                            <span class="font-semibold">{{ $image->user->name }}</span>
                            {{ $image->description }}
                        </div>
                    @endif

                    <!-- Comentaris amb scroll -->
                    <div class="flex-1 overflow-y-auto px-4 py-3 space-y-3">
                        @forelse ($image->comments->sortBy('created_at') as $comment)
                            <div class="flex gap-2">
                                <a href="{{ route('users.show', $comment->user) }}">
                                    @if ($comment->user->avatar)
                                        <img src="{{ asset('storage/' . $comment->user->avatar) }}"
                                             alt="{{ $comment->user->name }}"
                                             class="w-7 h-7 rounded-full object-cover flex-shrink-0" />
                                    @else
                                        <div class="w-7 h-7 rounded-full bg-indigo-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </a>
                                <div>
                                    <span class="text-sm font-semibold text-gray-800">{{ $comment->user->name }}</span>
                                    <span class="text-sm text-gray-700"> {{ $comment->body }}</span>
                                    <div class="text-xs text-gray-400 mt-0.5">{{ $comment->created_at->diffForHumans() }}</div>
                                    @auth
                                        @if ($comment->user_id === auth()->id())
                                            <div class="flex gap-2 mt-1">
                                                <a href="{{ route('comments.edit', $comment) }}" class="text-xs text-gray-400 hover:text-gray-600">
                                                    {{ __('Editar') }}
                                                </a>
                                                <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs text-red-400 hover:text-red-600">
                                                        {{ __('Eliminar') }}
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">{{ __('Encara no hi ha comentaris.') }}</p>
                        @endforelse
                    </div>

                    <!-- Likes -->
                    <div class="px-4 py-2 border-t border-gray-100 flex items-center gap-3 text-sm text-gray-600">
                        <button
                            id="like-btn"
                            class="flex items-center gap-1 focus:outline-none"
                            data-url="{{ route('likes.toggle', $image) }}"
                            data-liked="{{ auth()->check() && $image->likes->contains('user_id', auth()->id()) ? 'true' : 'false' }}"
                        >
                            <svg id="like-icon" xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5 transition"
                                 fill="{{ auth()->check() && $image->likes->contains('user_id', auth()->id()) ? 'red' : 'none' }}"
                                 stroke="{{ auth()->check() && $image->likes->contains('user_id', auth()->id()) ? 'red' : 'currentColor' }}"
                                 viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                            <span id="like-count">{{ $image->likes->count() }}</span> likes
                        </button>
                        <span class="text-xs text-gray-400">{{ $image->comments->count() }} comentaris</span>
                        <a href="{{ route('home') }}" class="ml-auto text-xs text-gray-400 hover:text-gray-600">
                            ← {{ __('Tornar') }}
                        </a>
                    </div>

                    <!-- Input comentari -->
                    @auth
                        <div class="px-4 py-3 border-t border-gray-100">
                            <form method="POST" action="{{ route('comments.store', $image) }}" class="flex items-center gap-2">
                                @csrf
                                <input
                                    type="text"
                                    name="body"
                                    placeholder="{{ __('Afegeix un comentari...') }}"
                                    class="flex-1 text-sm border-0 border-b border-gray-300 focus:ring-0 focus:border-indigo-500 bg-transparent px-0"
                                    required
                                />
                                <button type="submit" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 focus:outline-none">
                                    {{ __('Enviar') }}
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <script>
        // ─── Like a la vista standalone ───────────────────────────────────
        const likeBtn = document.getElementById('like-btn');

        likeBtn?.addEventListener('click', () => {
            fetch(likeBtn.dataset.url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '',
                    'Content-Type': 'application/json',
                }
            })
            .then(res => res.json())
            .then(data => {
                const icon = document.getElementById('like-icon');
                // Actualitzem icona
                icon.setAttribute('fill', data.liked ? 'red' : 'none');
                icon.setAttribute('stroke', data.liked ? 'red' : 'currentColor');
                document.getElementById('like-count').textContent = data.like_count;
                likeBtn.dataset.liked = data.liked ? 'true' : 'false';
                // Animació
                icon.style.transition = 'transform 0.15s ease';
                icon.style.transform = 'scale(1.4)';
                setTimeout(() => icon.style.transform = 'scale(1)', 150);
            });
        });
    </script>
</x-app-layout>