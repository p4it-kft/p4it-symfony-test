<?php

namespace App\Controller;

use App\Entity\formModel\MessageForm;
use App\Entity\Message;
use App\Entity\MessageAuthor;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactUsAdvancedController extends AbstractController
{
    #[Route('/contact/us/advanced', name: 'app_contact_us_advanced')]
    public function index(): Response
    {
        return $this->render('contact_us_advanced/index.html.twig', [
            'controller_name' => 'ContactUsAdvancedController',
        ]);
    }

    #[Route('/tell-me/advanced')]
    public function advanced(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new MessageForm();

//        $author = new MessageAuthor();
//        $message->setAuthor($author);

        $formBuilder = $this->createFormBuilder($message)
            ->add('name')
            ->add('title')
            ->add('text', TextareaType::class)
            ->add('email')

//            ->add('email', TextType::class, [
//                'mapped' => false,
//                'constraints' => [
//                    new NotBlank([
//                        'message' => 'Choose an email!'
//                    ]),
//                    new Length([
//                        'min' => 25,
//                        'minMessage' => 'Too short email!'
//                    ])
//                ]
//            ])

            ->add('tag', EntityType::class, [
                'class' => Tag::class,
//                'choices' => $entityManager->getRepository(Tag::class)->findAll(),
                'multiple' => true,
                'expanded' => false,
            ])
            ->add('save', SubmitType::class, ['label' => 'Send']);

//        $formBuilder->addEventSubscriber(new AddU)

        $form = $formBuilder->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $author = new MessageAuthor();
            $author->setName($form->get('name')->getData());
            $author->setEmail($form->get('email')->getData());
            $entityManager->persist($author);

            /** @var Message $message */
            $message = $form->getData();
            $message->setAuthor($author);
            $entityManager->persist($message);

            $entityManager->flush();

            $this->addFlash('success', 'Message and its relations are saved');

            return $this->redirectToRoute('app_message_sent');
        }

        return $this->render('contact-us/advanced.html.twig', compact('form'));
    }

}
