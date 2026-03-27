<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nova publicació') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg overflow-hidden p-6">

                <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Imatge -->
                    <div>
                        <x-input-label for="image" :value="__('Imatge')" />
                        <input
                            id="image"
                            type="file"
                            name="image"
                            accept="image/*"
                            class="mt-1 block w-full text-sm text-gray-700"
                            required
                        />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <!-- Previsualització -->
                    <div class="mt-4 hidden" id="preview-container">
                        <img id="preview" src="" alt="Preview" class="w-full max-h-64 object-cover rounded-lg" />
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
                        >{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Botó -->
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-gray-900 underline mr-4 self-center">
                            {{ __('Cancel·lar') }}
                        </a>
                        <x-primary-button>
                            {{ __('Publicar') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Previsualització de la imatge abans de pujar -->
    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

</x-app-layout>