<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\FullNameRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FullNameRepository::class)]
class FullName
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $middleName = null;

    #[ORM\OneToOne(mappedBy: 'fullName', cascade: ['persist', 'remove'])]
    private ?Sender $sender = null;

    #[ORM\OneToOne(mappedBy: 'fullName', cascade: ['persist', 'remove'])]
    private ?Recipient $recipient = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(string $middleName): static
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function getSender(): ?Sender
    {
        return $this->sender;
    }

    public function setSender(Sender $sender): static
    {
        // set the owning side of the relation if necessary
        if ($sender->getFullName() !== $this) {
            $sender->setFullName($this);
        }

        $this->sender = $sender;

        return $this;
    }

    public function getRecipient(): ?Recipient
    {
        return $this->recipient;
    }

    public function setRecipient(Recipient $recipient): static
    {
        // set the owning side of the relation if necessary
        if ($recipient->getFullName() !== $this) {
            $recipient->setFullName($this);
        }

        $this->recipient = $recipient;

        return $this;
    }
}
