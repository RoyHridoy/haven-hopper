<?php

namespace App\Http\Controllers;

use App\Http\Resources\RentalResource;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Response
    {
        $rentals = RentalResource::collection(Rental::query()->latest()->with('location', 'amenities')->take(6)->get());

        return inertia()->render('Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'rentals' => $rentals,
        ]);
    }
}
