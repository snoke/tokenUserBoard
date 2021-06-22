<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoardPostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BoardPostRepository::class)
 */
#[ApiResource]
class BoardPost
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="boardPosts")
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=BoardTopic::class, inversedBy="boardPosts")
     */
    private $BoardTopic;

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
}
