<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChatMessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChatMessageRepository::class)
 */
#[ApiResource]
class ChatMessage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="chatMessagesAuthor")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="chatMessagesRecipient")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipient;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $sent;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $seen;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $delivered;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $message;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getRecipient(): ?User
    {
        return $this->recipient;
    }

    public function setRecipient(?User $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getSent(): ?\DateTimeInterface
    {
        return $this->sent;
    }

    public function setSent(?\DateTimeInterface $sent): self
    {
        $this->sent = $sent;

        return $this;
    }

    public function getSeen(): ?\DateTimeInterface
    {
        return $this->seen;
    }

    public function setSeen(?\DateTimeInterface $seen): self
    {
        $this->seen = $seen;

        return $this;
    }

    public function getDelivered(): ?\DateTimeInterface
    {
        return $this->delivered;
    }

    public function setDelivered(?\DateTimeInterface $delivered): self
    {
        $this->delivered = $delivered;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
