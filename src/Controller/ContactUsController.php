<?php

namespace App\Controller;

use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactUsController extends AbstractController
{
    #[Route('/tell-me')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Message();

        $form = $this->createFormBuilder($message)
            ->add('name')
            ->add('title')
            ->add('text')
            ->add('save', SubmitType::class, ['label' => 'Send'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return $this->redirectToRoute('app_message_sent');
        }

        return $this->render('contact-us/index.html.twig', compact('form'));
    }

    #[Route('/message-sent', 'app_message_sent')]
    public function message_sent(): Response
    {
        return $this->render('contact-us/message_sent.html.twig');
    }
}