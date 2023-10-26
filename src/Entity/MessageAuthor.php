<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MessageAuthor
 *
 */
#[ORM\Table(name: 'message_author')]
#[ORM\Entity]
class MessageAuthor
{
    /**
     * @var int
     *
     */
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;

    /**
     * @var string
     *
     */
    #[ORM\Column(name: 'name', type: 'string', length: 255, nullable: false)]
    private $name;

    /**
     * @var string
     *
     */
    #[ORM\Column(name: 'email', type: 'string', length: 255, nullable: false)]
    private $email;

    #[ORM\OneToOne(mappedBy: 'author', cascade: ['persist', 'remove'])]
    private ?Message $message = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): static
    {
        // unset the owning side of the relation if necessary
        if ($message === null && $this->message !== null) {
            $this->message->setAuthor(null);
        }

        // set the owning side of the relation if necessary
        if ($message !== null && $message->getAuthor() !== $this) {
            $message->setAuthor($this);
        }

        $this->message = $message;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf("%s - %s", $this->name, $this->email);
    }
}
