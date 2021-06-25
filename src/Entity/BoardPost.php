<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoardPostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

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

    /**
     * @ORM\Column(type="datetime", nullable="true")
     */
    private $created;

    /**
     * @ORM\OneToMany(targetEntity=BoardPostMemento::class, mappedBy="boardPost", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $Mementos;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    public function __construct()
    {
        $this->Mementos = new ArrayCollection();
    }

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

    /**
     * @return Collection|BoardPostMemento[]
     */
    public function getMementos(): Collection
    {
        return $this->Mementos;
    }

    public function addMemento(BoardPostMemento $memento): self
    {
        if (!$this->Mementos->contains($memento)) {
            $this->Mementos[] = $memento;
            $memento->setBoardPost($this);
        }

        return $this;
    }

    public function removeMemento(BoardPostMemento $memento): self
    {
        if ($this->Mementos->removeElement($memento)) {
            // set the owning side to null (unless already changed)
            if ($memento->getBoardPost() === $this) {
                $memento->setBoardPost(null);
            }
        }

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }
}
