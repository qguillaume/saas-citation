<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;


class QuoteController extends AbstractController
{
    private $security;
    private $userRepository;

    public function __construct($security, UserRepository $userRepository)
    {
        $this->security = $security;
        $this->userRepository = $userRepository;
    }

    #[Route('/api/quote', name: 'quote', methods: ['GET'])]
    public function getQuote(): JsonResponse
    {
        $user = $this->security->getUser();
        $isPremium = false;

        if ($user) {
            $isPremium = $user->getIsPremium();
        }

        $quotes = [
            'Le succès est la somme de petits efforts répétés jour après jour.',
            'La seule façon de faire du bon travail est d\'aimer ce que vous faites.',
            'La persévérance est la clé du succès.',
        ];

        $premiumQuotes = [
            'La réussite appartient à ceux qui se lèvent tôt.',
            'La connaissance est un trésor, mais la pratique est la clé.',
            'Pour aller loin, il faut ménager sa monture.',
        ];

        $quote = $quotes[array_rand($quotes)];
        $premiumQuote = $user && $user->getIsPremium() ? $premiumQuotes[array_rand($premiumQuotes)] : null;

        return new JsonResponse([
            'quote' => $quote,
            'isPremium' => $user ? $user->getIsPremium() : false,
            'isAuthenticated' => (bool) $user,
            'premiumQuote' => $premiumQuote,
        ]);
    }
}