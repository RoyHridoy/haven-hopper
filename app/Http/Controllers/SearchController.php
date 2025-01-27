<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityResource;
use App\Models\Rental;
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
        $filters = $request->only(['city', 'checkInDate', 'checkOutDate', 'total_guests']);
        // dd($filters);

        $rentals = Rental::query()->with(['location', 'amenities'])->latest()->paginate(6);

        return inertia()->render('Search', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'rentals' => $rentals,
            'cities' => CityResource::collection(config('cities')),
            'filters' => $filters,
        ]);
    }
}
