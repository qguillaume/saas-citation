<?php

namespace App\Controller;

use App\Service\StripeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    private $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    #[Route('/stripe/checkout', name: 'stripe_checkout')]
    public function checkout(): Response
    {
        // Appel à la méthode de StripeService pour créer une session
        $session = $this->stripeService->createCheckoutSession();
        return $this->redirect($session['url']);
    }

    #[Route('/success', name: 'stripe_success')]
    public function success()
    {
        return new Response(
            '<html><body><h1>Merci pour votre paiement !</h1></body></html>'
        );
    }

    #[Route(path: '/cancel', name: 'stripe_cancel')]
    public function cancel()
    {
        return new Response(
            '<html><body><h1>Le paiement a échoué !</h1></body></html>'
        );
    }
}
