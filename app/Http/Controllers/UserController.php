<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Mostra el perfil públic d'un usuari.
     */
    public function show(User $user): View
    {
        // Carreguem les imatges de l'usuari amb les relacions necessàries
        $images = $user->images()
                       ->withCount(['likes', 'comments'])
                       ->orderBy('created_at', 'desc')
                       ->paginate(12);

        return view('users.show', compact('user', 'images'));
    }
}