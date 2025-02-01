<?php

namespace App\Http\Controllers;

use App\Enums\RentalType;
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
            ->approved()
            ->when(
                $request->query('total_guests'),
                fn ($query, $totalGuest) => $query->where('total_guests', '>=', $totalGuest)
            )
            ->when(
                $request->query('checkInDate') && $request->query('checkOutDate'),
                fn ($query) => $query->availableIn($request->query('checkInDate'), $request->query('checkOutDate'))
            )
            ->when($request->query('category'), fn ($query, $categoryName) => $query->byCategory($categoryName))
            ->when($request->query('city'), fn ($query, $cityName) => $query->byCity($cityName))
            ->latest()
            ->paginate($request->per_page ?? 6)
            ->withQueryString();

        $rentals->getCollection()->transform(function ($item) {
            if (is_array($item->images)) {
                $item->images = collect($item->images)
                    ->map(fn ($image) => asset("storage/{$image}"))
                    ->all();
            }

            return $item;
        });

        $categories = collect(RentalType::cases())->map(function ($type) {
            static $i = 1;

            return ['id' => $i++, 'name' => $type];
        });

        return inertia()->render('Search', [
            'rentals' => $rentals,
            'cities' => CityResource::collection(config('cities')),
            'categories' => $categories,
            'filters' => $request->query(),
        ]);
    }
}
