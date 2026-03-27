<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Image;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Guarda un nou comentari.
     */
    public function store(Request $request, Image $image): RedirectResponse
    {
        $request->validate([
            'body' => ['required', 'string', 'max:500'],
        ]);

        $image->comments()->create([
            'user_id' => auth()->id(),
            'body'    => $request->body,
        ]);

        return back();
    }

    /**
     * Mostra el formulari d'edició d'un comentari.
     */
    public function edit(Comment $comment): \Illuminate\View\View
    {
        // Només el propietari pot editar el seu comentari
        abort_if(auth()->id() !== $comment->user_id, 403);

        return view('comments.edit', compact('comment'));
    }

    /**
     * Actualitza un comentari existent.
     */
    public function update(Request $request, Comment $comment): RedirectResponse
    {
        // Només el propietari pot actualitzar el seu comentari
        abort_if(auth()->id() !== $comment->user_id, 403);

        $request->validate([
            'body' => ['required', 'string', 'max:500'],
        ]);

        $comment->update([
            'body' => $request->body,
        ]);

        return back();
    }

    /**
     * Elimina un comentari.
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        // Només el propietari pot eliminar el seu comentari
        abort_if(auth()->id() !== $comment->user_id, 403);

        $comment->delete();

        return back();
    }
}