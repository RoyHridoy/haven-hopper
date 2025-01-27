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
        $query = Rental::query()->with(['location', 'amenities']);

        if ($request->query('total_guests')) {
            $query = $query->where('total_guests', $request->query('total_guests'));
        }

        if ($request->query('city')) {
            $query = $query->whereHas('location', function ($query) use ($request) {
                return $query->where('city', $request->query('city'));
            });
        }

        return inertia()->render('Search', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'rentals' => $query->latest()->paginate(6),
            'cities' => CityResource::collection(config('cities')),
            'filters' => $request->query(),
        ]);
    }
}
