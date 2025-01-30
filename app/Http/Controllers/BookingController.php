<?php

namespace App\Http\Controllers;

use App\Enums\BookingPaymentStatus;
use App\Http\Requests\BookAvailabilityRequest;
use App\Http\Requests\BookStoreRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\RentalResource;
use App\Models\Booking;
use App\Models\Rental;
use App\Models\User;
use App\Services\PaymentService\PaymentFailedException;
use App\Services\PaymentService\PaymentProcessor;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        return inertia()->render('CheckAvailability', [
            'rental' => new RentalResource($rental->load('location')),
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

    public function storeBooking(BookStoreRequest $request, Rental $rental): RedirectResponse
    {
        $bookingData = $request->validated();
        $bookingData['user_id'] = $request->user()->id;
        DB::beginTransaction();
        try {

            $booking = $rental->bookings()->create($bookingData);

            PaymentProcessor::process(User::where('id', auth()->user()->id)->first(), $booking, $bookingData['paymentMethod']);
            DB::commit();

        } catch (PaymentFailedException $paymentFailedException) {

            $booking->update([
                'payment_status' => BookingPaymentStatus::FAILED,
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }

        return redirect()->route('bookings.index')->with([
            'message' => [
                'body' => 'Successfully Created Booking',
                'type' => 'success',
            ],
        ]);
    }
}
