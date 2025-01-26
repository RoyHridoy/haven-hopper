<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return inertia()->render('Search', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'rentals' => []
        ]);
    }
}
