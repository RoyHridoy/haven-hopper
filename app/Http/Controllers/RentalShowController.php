<?php

namespace App\Http\Controllers;

use App\Http\Resources\RentalResource;
use App\Models\Rental;
use Illuminate\Http\Request;
use Inertia\Response;

class RentalShowController extends Controller
{
    public function __invoke(Rental $rental, Request $request): Response
    {
        return inertia()->render('Rental', [
            'rental' => RentalResource::make($rental),
        ]);
    }
}
