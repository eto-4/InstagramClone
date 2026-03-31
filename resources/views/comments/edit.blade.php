<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar comentari') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg overflow-hidden p-6">
                <form method="POST" action="{{ route('comments.update', $comment) }}">
                    @csrf
                    @method('PATCH')

                    <!-- Cos del comentari -->
                    <div>
                        <x-input-label for="body" :value="__('Comentari')" />
                        <textarea
                            id="body"
                            name="body"
                            rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                            required
                        >{{ old('body', $comment->body) }}</textarea>
                        <x-input-error :messages="$errors->get('body')" class="mt-2" />
                    </div>

                    <!-- Botons -->
                    <div class="mt-6 flex justify-between items-center">
                        <!-- Eliminar comentari -->
                        <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="text-sm text-red-600 hover:text-red-900 underline"
                                onclick="return confirm('{{ __('Estàs segur que vols eliminar aquest comentari?') }}')"
                            >
                                {{ __('Eliminar comentari') }}
                            </button>
                        </form>

                        <div class="flex items-center gap-4">
                            
                                href="{{ route('images.show', $comment->image_id) }}"
                                class="text-sm text-gray-600 hover:text-gray-900 underline"
                            >
                                {{ __('Cancel·lar') }}
                            </a>
                            <x-primary-button>
                                {{ __('Guardar canvis') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>