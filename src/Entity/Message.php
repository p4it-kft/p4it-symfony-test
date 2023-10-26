<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * Message
 *
 */
#[ORM\Table(name: 'message')]
#[ORM\UniqueConstraint(name: 'unique_author_1', columns: ['author_id'])]
#[ORM\Entity]
class Message
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
    #[ORM\Column(name: 'title', type: 'string', length: 255, nullable: false)]
    private $title;

    /**
     * @var string|null
     *
     */
    #[ORM\Column(name: 'text', type: 'text', nullable: true)]
    private $text;

    /**
     * @var MessageAuthor|null
     *
     */
    #[ORM\JoinColumn(name: 'author_id', referencedColumnName: 'id')]
    #[ORM\OneToOne(targetEntity: 'MessageAuthor', inversedBy: 'message', cascade: ['persist', 'remove'])]
    private ?MessageAuthor $author = null;

    /**
     * @var PersistentCollection
     *
     */
    #[ORM\JoinTable(name: 'message_has_tag')]
    #[ORM\JoinColumn(name: 'message_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'tag_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: 'Tag', inversedBy: 'message')]
    private $tags = [];

    /**
     * @var PersistentCollection
     *
     * This will actually be a PersistentCollection (as every relation - in my opinion)
     * In the construct I cannot instantiate the PersistentCollection (required more parameters)
     *
     */
    #[ORM\OneToMany(mappedBy: 'message', targetEntity: MessageHasTag::class)]
    private $messageHasTags = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->messageHasTags = new ArrayCollection();
    }

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getTags(): PersistentCollection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getMessageHasTags(): PersistentCollection
    {
        return $this->messageHasTags;
    }

    public function addMessageHasTag(MessageHasTag $messageHasTag): static
    {
        if (!$this->messageHasTags->contains($messageHasTag)) {
            $this->messageHasTags->add($messageHasTag);
            $messageHasTag->setMessage($this);
        }

        return $this;
    }

    public function removeMessageHasTag(MessageHasTag $messageHasTag): static
    {
        if ($this->messageHasTags->removeElement($messageHasTag)) {
            // set the owning side to null (unless already changed)
            if ($messageHasTag->getMessage() === $this) {
                $messageHasTag->setMessage(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        $outputData[] = $this->name;
        $outputData[] = $this->title;
        $outputData[] = $this->author ? $this->author->getEmail() : '';

        $tagLabels = (new ArrayCollection($this->getTags()->toArray() ?? []))
            ->map(function(Tag $tag){
                return $tag->getLabel();
            })
            ->getValues();

        $outputData[] = '(' . implode(', ', $tagLabels) . ')';

        return implode(' | ', $outputData);
    }

    public function getAuthor(): ?MessageAuthor
    {
        return $this->author;
    }

    public function setAuthor(?MessageAuthor $author): static
    {
        $this->author = $author;

        return $this;
    }

}
