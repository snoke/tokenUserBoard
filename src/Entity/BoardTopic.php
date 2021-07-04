<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoardTopicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * @ORM\Entity(repositoryClass=BoardTopicRepository::class)
 */
#[ApiResource]
class BoardTopic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=BoardCategory::class, inversedBy="boardTopics")
     * @ORM\JoinColumn(nullable=false)
     */
    private $BoardCategory;

    /**
     * @ORM\OneToMany(targetEntity=BoardPost::class, mappedBy="BoardTopic", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $boardPosts;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="boardTopics")
     */
    private $author;

    /**
     * @ORM\Column(type="datetime", nullable="true")
     */
    private $created;

    public function __construct()
    {
        $this->boardPosts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBoardCategory(): ?BoardCategory
    {
        return $this->BoardCategory;
    }

    public function setBoardCategory(?BoardCategory $BoardCategory): self
    {
        $this->BoardCategory = $BoardCategory;

        return $this;
    }

    /**
     * @return Collection|BoardPost[]
     */
    public function getBoardPosts(): Collection
    {
        return $this->boardPosts;
    }

    public function addBoardPost(BoardPost $boardPost): self
    {
        if (!$this->boardPosts->contains($boardPost)) {
            $this->boardPosts[] = $boardPost;
            $boardPost->setBoardTopic($this);
        }

        return $this;
    }

    public function removeBoardPost(BoardPost $boardPost): self
    {
        if ($this->boardPosts->removeElement($boardPost)) {
            // set the owning side to null (unless already changed)
            if ($boardPost->getBoardTopic() === $this) {
                $boardPost->setBoardTopic(null);
            }
        }

        return $this;
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

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }
}
