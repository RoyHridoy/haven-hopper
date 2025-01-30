<?php

namespace App\Http\Controllers;

use App\Enums\BookingStatus;
use App\Enums\RentalApprovalStatus;
use App\Http\Resources\CityResource;
use App\Models\Rental;
use Carbon\Carbon;
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
            ->where('approval_status', RentalApprovalStatus::APPROVED)
            ->when($request->query('total_guests'),
                fn ($query, $totalGuest) => $query->where('total_guests', $totalGuest)
            )
            ->when($request->query('checkInDate') && $request->query('checkOutDate'), function ($query) use ($request) {
                $checkInDate = Carbon::parse($request->query('checkInDate'));
                $checkOutDate = Carbon::parse($request->query('checkOutDate'));
                $query = $query->whereDoesntHave('bookings', fn ($query) => $query->overlap($checkInDate, $checkOutDate, BookingStatus::APPROVED));
            })
            ->when($request->query('city'), function ($query, $cityName) {
                $query = $query->whereHas('location', fn ($query) => $query->where('city', $cityName));
            })->latest()
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

        return inertia()->render('Search', [
            'rentals' => $rentals,
            'cities' => CityResource::collection(config('cities')),
            'filters' => $request->query(),
        ]);
    }
}
