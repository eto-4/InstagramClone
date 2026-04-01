<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Capçalera del perfil -->
            <div class="bg-white shadow sm:rounded-lg p-6 flex items-center gap-6 mb-6">
                <!-- Avatar / Inicials -->
                <div class="w-20 h-20 rounded-full bg-indigo-500 flex items-center justify-center text-white text-2xl font-bold flex-shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <!-- Informació -->
                <div>
                    <h1 class="text-xl font-bold text-gray-800">{{ $user->name }}</h1>
                    @if ($user->phone_number)
                        <p class="text-sm text-gray-500 mt-1">{{ $user->phone_number }}</p>
                    @endif
                    <p class="text-sm text-gray-400 mt-1">
                        {{ $images->total() }} {{ __('publicacions') }}
                    </p>
                </div>
            </div>

            <!-- Grid de publicacions -->
            @if ($images->count())
                <div class="grid grid-cols-3 gap-1">
                    @foreach ($images as $image)
                        <button class="open-modal block aspect-square overflow-hidden" data-id="{{ $image->id }}">
                            <img
                                src="{{ asset('storage/' . $image->image_path) }}"
                                alt="{{ $image->description }}"
                                class="w-full h-full object-cover hover:opacity-80 transition"
                            />
                        </button>
                    @endforeach
                </div>

                <!-- Paginació -->
                <div class="mt-6">
                    {{ $images->links() }}
                </div>
            @else
                <div class="bg-white shadow sm:rounded-lg p-6 text-center text-gray-400">
                    {{ __('Aquest usuari encara no ha publicat res.') }}
                </div>
            @endif

        </div>
    </div>

    <!-- Importació de Modal -->
    @include('partials.post-modal')
</x-app-layout>