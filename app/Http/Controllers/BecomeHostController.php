<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterOwnerRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class BecomeHostController extends Controller
{
    public function index(): Response
    {
        return inertia()->render('BecomeHost');
    }

    public function generateRegisterForm(): Response
    {
        return inertia()->render('HostRegister');
    }

    public function register(RegisterOwnerRequest $registerOwnerRequest): RedirectResponse
    {

        auth()->user()->update([
            'phone' => $registerOwnerRequest->input('phone'),
            'want_to_host' => true,
        ]);

        return redirect()->route('dashboard')->with([
            'message' => [
                'body' => 'Request received. Wait for the admin approval.',
                'type' => 'success',
            ],
        ]);
    }
}
