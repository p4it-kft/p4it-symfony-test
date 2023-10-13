<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

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
     * @var MessageAuthor
     *
     */
    #[ORM\JoinColumn(name: 'author_id', referencedColumnName: 'id')]
    #[ORM\ManyToOne(targetEntity: 'MessageAuthor')]
    private $author;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     */
    #[ORM\JoinTable(name: 'message_has_tag')]
    #[ORM\JoinColumn(name: 'message_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'tag_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: 'Tag', inversedBy: 'message')]
    private $tag = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tag = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getAuthor(): ?MessageAuthor
    {
        return $this->author;
    }

    public function setAuthor(?MessageAuthor $author): static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tag->contains($tag)) {
            $this->tag->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        $this->tag->removeElement($tag);

        return $this;
    }

}
