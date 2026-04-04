<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar publicació') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg overflow-hidden p-6">

                <form id="edit-form" method="POST" action="{{ route('posts.update', $image) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <!-- Imatge actual -->
                    <div>
                        <x-input-label :value="__('Imatge actual')" />
                        <img
                            src="{{ asset('storage/' . $image->image_path) }}"
                            alt="{{ $image->description }}"
                            class="mt-1 w-full max-h-64 object-cover rounded-lg"
                            id="preview"
                        />
                    </div>

                    <!-- Canviar imatge -->
                    <div class="mt-4">
                        <x-input-label for="image" :value="__('Canviar imatge (opcional)')" />
                        <input
                            id="image"
                            type="file"
                            name="image"
                            accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-700"
                        />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <!-- Descripció -->
                    <div class="mt-4">
                        <x-input-label for="description" :value="__('Descripció')" />
                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                            placeholder="{{ __('Escriu una descripció...') }}"
                        >{{ old('description', $image->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </form>

                <div class="mt-6 flex justify-between">
                    <!-- Eliminar publicació - form separat -->
                    <form method="POST" action="{{ route('posts.destroy', $image) }}">
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="text-sm text-red-600 hover:text-red-900 underline"
                            onclick="return confirm('{{ __('Estàs segur que vols eliminar aquesta publicació?') }}')"
                        >
                            {{ __('Eliminar publicació') }}
                        </button>
                    </form>

                    <div class="flex items-center gap-4">
                        <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                            {{ __('Cancel·lar') }}
                        </a>
                        <x-primary-button form="edit-form">
                            {{ __('Guardar canvis') }}
                        </x-primary-button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Previsualització de la nova imatge abans de pujar -->
    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

</x-app-layout>