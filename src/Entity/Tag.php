<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * Tag
 *
 */
#[ORM\Table(name: 'tag')]
#[ORM\Entity]
class Tag
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
    #[ORM\Column(name: 'label', type: 'string', length: 255, nullable: false)]
    private $label;

    /**
     * @var PersistentCollection
     *
     */
    #[ORM\ManyToMany(targetEntity: 'Message', mappedBy: 'tag')]
    private $message = [];

    /**
     * @var PersistentCollection
     */
    #[ORM\OneToMany(mappedBy: 'tag', targetEntity: MessageHasTag::class)]
    private $messageHasTags = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->message = new ArrayCollection();
        $this->messageHasTags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getMessage(): Collection
    {
        return $this->message;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->message->contains($message)) {
            $this->message->add($message);
            $message->addTag($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->message->removeElement($message)) {
            $message->removeTag($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->label;
    }

    public function getMessageHasTags(): Collection
    {
        return $this->messageHasTags;
    }

    public function addMessageHasTag(MessageHasTag $messageHasTag): static
    {
        if (!$this->messageHasTags->contains($messageHasTag)) {
            $this->messageHasTags->add($messageHasTag);
            $messageHasTag->setTag($this);
        }

        return $this;
    }

    public function removeMessageHasTag(MessageHasTag $messageHasTag): static
    {
        if ($this->messageHasTags->removeElement($messageHasTag)) {
            // set the owning side to null (unless already changed)
            if ($messageHasTag->getTag() === $this) {
                $messageHasTag->setTag(null);
            }
        }

        return $this;
    }

}
