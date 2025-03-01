<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends AbstractController
{
    #[Route('/make-premium/{id}', name: 'make_premium')]
    public function makePremium(int $id, EntityManagerInterface $em): Response
    {
        $user = $em->getRepository(User::class)->find($id);
        if ($user) {
            $user->setIsPremium(true);
            $em->persist($user);
            $em->flush();
        }
        return $this->redirectToRoute('home');
    }
}