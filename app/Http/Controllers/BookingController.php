<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingResource;
use App\Http\Resources\RentalResource;
use App\Models\Booking;
use App\Models\Rental;
use Inertia\Response;

class BookingController extends Controller
{
    public function index(): Response
    {
        $bookings = Booking::query()
            ->with('rental')
            ->where('user_id', auth()->user()->id)
            ->get();

        return inertia()->render('Bookings', [
            'bookings' => BookingResource::collection($bookings),
        ]);
    }

    public function checkout(Rental $rental): Response
    {
        return inertia()->render('Checkout', [
            'rental' => new RentalResource($rental->load('location')),
        ]);
    }
}
