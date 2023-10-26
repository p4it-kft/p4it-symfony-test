<?php

namespace App\Controller;

use App\Entity\formModel\MessageForm;
use App\Entity\Message;
use App\Form\Type\MessageFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactUsAdvancedController extends AbstractController
{
    #[Route('/tell-me-advanced/create', name: 'tell_me_advanced - create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $messageForm = new MessageForm();

        $form = $this->createForm(MessageFormType::class, $messageForm);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $messageId = $messageForm->insertAll($entityManager, $form);

            $this->addFlash('success', 'Message and its relations are created');

            return $this->redirectToRoute('tell_me_advanced - update', ['id' => $messageId]);
        }

        return $this->render('contact-us-advanced/form-explained.html.twig', compact('form'));
    }

    #[Route('/tell-me-advanced/update/{id}', name: 'tell_me_advanced - update')]
    public function update($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = $entityManager->getRepository(Message::class)->find($id);

        $messageForm = new MessageForm();
        $messageForm->setMessage($message);

        $form = $this->createForm(MessageFormType::class, $messageForm, [
            'action' => $this->generateUrl('tell_me_advanced - update', ['id' => $messageForm->getMessageId()])
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $messageForm->updateAll($entityManager, $form);

            $this->addFlash('success', 'Message and its relations are created');

            return $this->redirectToRoute('tell_me_advanced - update', ['id' => $messageForm->getMessageId()]);
        }

        return $this->render('contact-us-advanced/form.html.twig', compact('form'));
    }

    #[Route('/tell-me-advanced/list', name: 'tell me - advanced -- list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $messages = $entityManager->getRepository(Message::class)->findAll();

        return $this->render('contact-us-advanced/list.html.twig', [
            'messages' => $messages,
        ]);
    }

}
