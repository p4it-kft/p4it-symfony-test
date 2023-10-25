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
    public function create(): Response
    {
        $messageForm = new MessageForm();

        $form = $this->createForm(MessageFormType::class, $messageForm, [
            'action' => $this->generateUrl('tell-me-advanced/store')
        ]);

        return $this->render('contact-us-advanced/form.html.twig', compact('form'));
    }

    #[Route('/tell-me-advanced/update/{id}', name: 'tell_me_advanced - update')]
    public function update($id, EntityManagerInterface $entityManager): Response
    {
        $message = $entityManager->getRepository(Message::class)->find($id);

        $messageForm = new MessageForm();
        $messageForm->setMessage($message);

        $form = $this->createForm(MessageFormType::class, $messageForm, [
            'action' => $this->generateUrl('tell-me-advanced/store', ['id' => $messageForm->getMessageId()])
        ]);

        return $this->render('contact-us-advanced/form.html.twig', compact('form'));
    }

    #[Route('/tell-me-advanced/store/{id?}', name: 'tell-me-advanced/store')]
    public function store(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $messageForm = new MessageForm();

        $form = $this->createForm(MessageFormType::class, $messageForm);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($id) {
                $message = $entityManager->getRepository(Message::class)->find($id);

                $messageForm = new MessageForm();
                $messageForm->setMessage($message);

                $messageId = $messageForm->updateAll($entityManager, $form);
            } else {
                $messageId = $messageForm->insertAll($entityManager, $form);
            }

            $this->addFlash('success', 'Message and its relations are saved');

            return $this->redirectToRoute('tell_me_advanced - update', ['id' => $messageId]);
        }

        return $this->redirectToRoute('tell_me_advanced - create');
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
