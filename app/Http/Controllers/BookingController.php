<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookAvailabilityRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\RentalResource;
use App\Models\Booking;
use App\Models\Rental;
use Illuminate\Http\Request;
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

    public function checkAvailability(Rental $rental): Response
    {
        return inertia()->render('CheckAvailability', [
            'rental' => new RentalResource($rental->load('location')),
        ]);
    }

    public function availabilityValidate(BookAvailabilityRequest $request, Rental $rental) {
        return inertia()->render('Checkout', [
            'rental' => new RentalResource($rental->load('location')),
            'checkInDate' => $request->input('check_in_date'),
            'checkOutDate' => $request->input('check_out_date'),
        ]);
    }

    public function checkout(Request $request)
    {
        dd($request->all());
    }
}
