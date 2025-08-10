<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookAvailabilityRequest;
use App\Http\Requests\BookStoreRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\RentalResource;
use App\Models\Booking;
use App\Models\Rental;
use App\Models\User;
use App\Services\PaymentService\PaymentProcessor;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class BookingController extends Controller
{
    public function index(): Response
    {
        $bookings = Booking::query()
            ->with(['rental', 'rental.amenities', 'rental.location'])
            ->where('user_id', auth()->user()->id)
            ->latest()
            ->get();

        return inertia()->render('Bookings', [
            'bookings' => BookingResource::collection($bookings),
        ]);
    }

    public function checkAvailability(Rental $rental): Response
    {
        // already booking dates
        $bookedDates = Booking::where('rental_id', $rental->id)->approved()->get(['check_in_date', 'check_out_date']);

        return inertia()->render('CheckAvailability', [
            'rental' => new RentalResource($rental->load('location')),
            'bookedDates' => $bookedDates,
        ]);
    }

    public function availabilityValidate(BookAvailabilityRequest $request, Rental $rental): RedirectResponse
    {
        return redirect()->back();
    }

    public function checkout(Request $request, Rental $rental): Response
    {
        $availablePaymentMethods = PaymentProcessor::availableProviders();

        $requestCheckInDate = (string) $request->query('checkInDate');
        $requestCheckOutDate = (string) $request->query('checkOutDate');

        $totalStay = Carbon::createFromDate($requestCheckInDate)->diffInDays(Carbon::createFromDate($requestCheckOutDate));

        return inertia()->render('Checkout', [
            'rental' => new RentalResource($rental->load('location')),
            'totalStay' => $totalStay,
            'totalPrice' => ($totalStay * $rental->price),
            'checkInDate' => $requestCheckInDate,
            'checkOutDate' => $requestCheckOutDate,
            'availablePaymentMethods' => $availablePaymentMethods,
        ]);
    }

    public function storeBooking(BookStoreRequest $request, Rental $rental): mixed
    {
        $bookingData = $request->validated();

        $bookingData['user_id'] = $request->user()->id;

        $booking = $rental->bookings()->create($bookingData);

        return PaymentProcessor::create()->process(User::where('id', auth()->user()->id)->first(), $booking, $bookingData['paymentMethod']);
    }
}
