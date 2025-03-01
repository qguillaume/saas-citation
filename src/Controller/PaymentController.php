<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends AbstractController
{
    /**
     * @Route("/success", name="payment_success")
     */
    public function success(): Response
    {
        return $this->render('payment/success.html.twig');
    }

    /**
     * @Route("/cancel", name="payment_cancel")
     */
    public function cancel(): Response
    {
        return $this->render('payment/cancel.html.twig');
    }
}
