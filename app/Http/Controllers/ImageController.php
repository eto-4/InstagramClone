<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Mostra el detall d'una imatge.
     */
    public function show(Image $image): View
    {
        // Carreguem les relacions necessàries
        $image->load('user', 'likes.user', 'comments.user');

        return view('images.show', compact('image'));
    }
    
    /**
     * Mostra el formulari per crear una nova imatge.
     */
    public function create(): View
    {
        return view('posts.create');
    }

    /**
     * Guarda una nova imatge a la base de dades i a l'storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'image'       => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        // Guardem la imatge a storage/app/public/images
        $path = $request->file('image')->store('images', 'public');

        Image::create([
            'user_id'    => auth()->id(),
            'image_path' => $path,
            'description' => $request->description,
        ]);

        return redirect()->route('home')->with('success', 'Imatge publicada correctament!');
    }

    /**
     * Mostra el formulari per editar una imatge.
     */
    public function edit(Image $image): View
    {
        // Només el propietari pot editar la seva imatge
        abort_if(auth()->id() !== $image->user_id, 403);

        return view('posts.edit', compact('image'));
    }

    /**
     * Actualitza una imatge existent.
     */
    public function update(Request $request, Image $image): RedirectResponse
    {
        // Només el propietari pot actualitzar la seva imatge
        abort_if(auth()->id() !== $image->user_id, 403);

        $request->validate([
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        // Si s'ha pujat una nova imatge la substituïm
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $image->update(['image_path' => $path]);
        }

        $image->update([
            'description' => $request->description,
        ]);

        return redirect()->route('images.show', $image)->with('success', 'Imatge actualitzada correctament!');
    }

    /**
     * Elimina una imatge de la base de dades i de l'storage.
     */
    public function destroy(Image $image): RedirectResponse
    {
        // Només el propietari pot eliminar la seva imatge
        abort_if(auth()->id() !== $image->user_id, 403);

        // Eliminem el fitxer de l'storage
        \Storage::disk('public')->delete($image->image_path);

        $image->delete();

        return redirect()->route('home')->with('success', 'Imatge eliminada correctament!');
    }
}