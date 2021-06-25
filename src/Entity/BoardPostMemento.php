<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoardPostMementoRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * @ORM\Entity(repositoryClass=BoardPostMementoRepository::class)
 */
#[ApiResource]
class BoardPostMemento
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=BoardTopic::class)
     */
    private $BoardTopic;

    /**
     * @ORM\Column(type="datetime", nullable="true")
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity=BoardPost::class, inversedBy="Mementos")
     */
    private $boardPost;

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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getBoardTopic(): ?BoardTopic
    {
        return $this->BoardTopic;
    }

    public function setBoardTopic(?BoardTopic $BoardTopic): self
    {
        $this->BoardTopic = $BoardTopic;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getBoardPost(): ?BoardPost
    {
        return $this->boardPost;
    }

    public function setBoardPost(?BoardPost $boardPost): self
    {
        $this->boardPost = $boardPost;

        return $this;
    }
}
