<?php

namespace App\Entity;

use App\Repository\MessageHasTagRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageHasTagRepository::class)]
class MessageHasTag
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'messageHasTags')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Message $message = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'messageHasTags')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tag $tag = null;

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(?Tag $tag): static
    {
        $this->tag = $tag;

        return $this;
    }

}
