<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityResource;
use App\Models\Rental;
use Illuminate\Http\Request;
use Inertia\Response;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Response
    {
        $rentals = Rental::query()
            ->with(['location', 'amenities'])
            ->when(
                $request->query('total_guests'),
                fn ($query, $guestsCount) => $query->where('total_guests', intval($guestsCount))
            )
            ->when(
                $request->query('city'),
                fn ($query, $cityName) => $query->where('city', $cityName)
            )
            ->latest()
            ->paginate($request->per_page ?? 6)
            ->withQueryString();

        return inertia()->render('Search', [
            'rentals' => $rentals,
            'cities' => CityResource::collection(config('cities')),
            'filters' => $request->query(),
        ]);
    }
}
