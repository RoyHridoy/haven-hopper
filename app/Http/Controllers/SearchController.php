<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Response;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Response
    {
        return inertia()->render('Search', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'rentals' => [],
        ]);
    }
}
