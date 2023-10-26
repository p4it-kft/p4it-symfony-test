<?php

namespace App\Entity\formModel;

use App\Entity\Message;
use App\Entity\MessageAuthor;
use App\Entity\MessageHasTag;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class MessageForm extends Message
{
    #[ORM\Column(name: 'authorEmail', type: Types::STRING, length: 255, nullable: false)]
    #[NotBlank]
    #[Length(min: 5, minMessage: 'Too short email!')]
    private $authorEmail;

    #[ORM\Column(name: 'messageTags', type: Types::SIMPLE_ARRAY, nullable: true)]
    private $messageTags;

    #[ORM\Column(name: 'messageModel', type: Types::JSON, nullable: true)]
    private $messageModel;

    #[ORM\Column(name: 'messageId', type: Types::INTEGER, nullable: true)]
    private $messageId;

    public function getAuthorEmail(): ?string
    {
        return $this->authorEmail;
    }

    public function setAuthorEmail(string $authorEmail): static
    {
        $this->authorEmail = $authorEmail;

        return $this;
    }

    public function getMessageTags()
    {
        return $this->messageTags;
    }

    public function setMessageTags($messageTags): static
    {
        $this->messageTags = $messageTags;

        return $this;
    }

    public function getMessageModel()
    {
        return $this->messageModel;
    }

    public function setMessageModel($messageModel)
    {
        $this->messageModel = $messageModel;

        return $this;
    }

    public function getMessageId()
    {
        return $this->messageId;
    }

    public function setMessageId($messageId): static
    {
        $this->messageId = $messageId;

        return $this;
    }

    public function setMessage(Message $message)
    {
        $this->messageModel = $message;

        $this->messageId = $message->getId();

        $this->setName($message->getName());
        $this->setTitle($message->getTitle());
        $this->setText($message->getText());

        $this->setAuthorEmail($message->getAuthor() ? $message->getAuthor()->getEmail() : '');
        $this->setMessageTags($message->getTags()->toArray());
    }

    public function insertAll(EntityManagerInterface $entityManager, FormInterface $form): ?int
    {
        $entityManager->getConnection()->beginTransaction();

        try {
            $author = new MessageAuthor();
            $author->setName($form->get('name')->getData());
            $author->setEmail($form->get('authorEmail')->getData());

            $message = new Message();
            $message
                ->setName($form->get('name')->getData())
                ->setTitle($form->get('title')->getData())
                ->setText($form->get('text')->getData())
                ->setAuthor($author);

            $newTags = $form->get('messageTags')->getData();
            foreach ($newTags as $newTag) {
                $message->addTag($newTag);
            }

            $entityManager->persist($message);
            $entityManager->flush();

            $entityManager->getConnection()->commit();

            return $message->getId();
        } catch (\Exception $e) {
            $entityManager->getConnection()->rollBack();

            throw $e;
        }
    }

    public function updateAll(EntityManagerInterface $entityManager, FormInterface $form): void
    {
        $entityManager->getConnection()->beginTransaction();

        try {
            $message = $entityManager->getRepository(Message::class)->find($this->messageId);
            $messageAuthor = $message->getAuthor();
            $oldMessageTags = $message->getTags()->toArray();

            $message
                ->setName($form->get('name')->getData())
                ->setTitle($form->get('title')->getData())
                ->setText($form->get('text')->getData());

            if (!$messageAuthor) {
                $messageAuthor = new MessageAuthor();
                $messageAuthor->setName($form->get('name')->getData());
                $messageAuthor->setEmail($form->get('authorEmail')->getData());

                $message->setAuthor($messageAuthor);
            } else {
                $messageAuthor->setName($form->get('name')->getData());
                $messageAuthor->setEmail($form->get('authorEmail')->getData());
            }

            foreach ($oldMessageTags as $oldMessageTag) {
                $message->removeTag($oldMessageTag);
            }
            $newTags = $form->get('messageTags')->getData();
            foreach ($newTags as $newTag) {
                $message->addTag($newTag);
            }

            $entityManager->persist($message);
            $entityManager->flush();

            $entityManager->getConnection()->commit();
        } catch (\Exception $e) {
            $entityManager->getConnection()->rollBack();

            throw $e;
        }
    }

}