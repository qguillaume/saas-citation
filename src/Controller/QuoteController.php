<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuoteController extends AbstractController
{
    #[Route('/api/quote', name: 'quote', methods: ['GET'])]
    public function getQuote(): JsonResponse
    {
        $quotes = [
            'Le succès est la somme de petits efforts répétés jour après jour.',
            'La seule façon de faire du bon travail est d’aimer ce que vous faites.',
            'La persévérance est la clé du succès.',
        ];
        $quote = $quotes[array_rand($quotes)];
        return new JsonResponse(['quote' => $quote]);
    }
}