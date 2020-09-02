<?php

namespace App\Controller;

use App\Form\QuoteRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/services")
*/
class ServicesController extends AbstractController
{
    /**
     * @Route("/", name="services_index")
     */
    public function index()
    {
        return $this->render('services/index.html.twig', [
            'controller_name' => 'ServicesController',
        ]);
    }

/**
     * @Route("/quoterequest", name="quote_request")
     */
    public function quoteRequest(Request $request, \Swift_Mailer $mailer)
    {

        $form = $this->createForm(QuoteRequestType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quoteRequest = $form->getData();
            
            // On crée le message
            $message = (new \Swift_Message('Demande de devis : '. $quoteRequest->getName()))
            ->setFrom("noreply.websitequote@gmail.com")
            ->setTo("kevin.adorais@gmail.com")
            ->setReplyTo($quoteRequest->getMail())
            ->setBody(
                $this->renderView('emails/quoteRequestMail.html.twig',
                    ['quote' => $quoteRequest]
                ),
                'text/html'
            );

            // On envoie le message
            $mailer->send($message);


            $this->addFlash('success', "Votre demande a bien été envoyée.");
            return $this->redirectToRoute('services_index');
        }

        return $this->render('quoteRequest/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}