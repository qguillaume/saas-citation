<?php

namespace App\Controller;

use App\Service\StripeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class StripeController extends AbstractController
{
    private $stripeService;
    private $security;

    public function __construct(Security $security, StripeService $stripeService)
    {
        $this->security = $security;
        $this->stripeService = $stripeService;
    }

    #[Route('/stripe/checkout', name: 'stripe_checkout')]
    public function checkout(): Response
    {
        if (!$this->security->getUser()) {
            return $this->redirectToRoute('login');
        }

        $session = $this->stripeService->createCheckoutSession();
        return $this->redirect($session['url']);
    }

    #[Route('/success', name: 'stripe_success')]
    public function success(EntityManagerInterface $em): Response
    {
        $user = $this->security->getUser();
        if ($user) {
            $user->setIsPremium(true);
            $em->persist($user);
            $em->flush();
        }
        return new Response(
            '<html><body><h1>Merci pour votre paiement !</h1></body></html>'
        );
    }

    #[Route('/cancel', name: 'stripe_cancel')]
    public function cancel(): Response
    {
        return new Response(
            '<html><body><h1>Le paiement a échoué !</h1></body></html>'
        );
    }
}
