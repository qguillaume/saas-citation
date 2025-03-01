<?php

// src/Service/StripeService.php

namespace App\Service;

use Stripe\StripeClient;

class StripeService
{
    private $stripe;

    public function __construct(string $stripeApiKey)
    {
        $this->stripe = new StripeClient($stripeApiKey);
    }

    public function createCheckoutSession(): array
    {
        return $this->stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'line_items' => [
                [
                    'price' => $_ENV['STRIPE_PRICE_PRODUCT_ID'], // ID du produit Stripe
                    'quantity' => 1,
                ]
            ],
            'success_url' => 'http://localhost:8000/success',
            'cancel_url' => 'http://localhost:8000/cancel',
        ])->toArray();
    }
}
