<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Mostra totes les imatges paginades.
     */
    public function index(): View
    {
        $images = Image::with('user', 'likes', 'comments')
                       ->orderBy('created_at', 'desc')
                       ->paginate(5);

        return view('home', compact('images'));
    }
}