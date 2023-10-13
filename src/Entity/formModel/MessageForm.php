<?php

namespace App\Entity\formModel;

use App\Entity\Message;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class MessageForm extends Message
{
    #[ORM\Column(name: 'email', type: 'string', length: 255, nullable: false)]
    #[NotBlank]
    #[Length(min: 25, minMessage: 'Too short email!')]
    private $email;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }
}