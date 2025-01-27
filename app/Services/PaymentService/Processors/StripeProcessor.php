<?php

namespace App\Services\PaymentService\Processors;

use App\Services\PaymentService\Concern\PaymentProcessorConcern;

class CashProcessor extends PaymentProcessorConcern
{
    public function process(): mixed
    {
        $this->booking->update(['payment_status' => 'paid']);

        return true;
    }
}
