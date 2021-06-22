<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoardCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BoardCategoryRepository::class)
 * @ApiResource
 */
class BoardCategory
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
     * @ORM\OneToMany(targetEntity=BoardTopic::class, mappedBy="BoardCategory")
     */
    private $boardTopics;

    public function __construct()
    {
        $this->boardTopics = new ArrayCollection();
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

    /**
     * @return Collection|BoardTopic[]
     */
    public function getBoardTopics(): Collection
    {
        return $this->boardTopics;
    }

    public function addBoardTopic(BoardTopic $boardTopic): self
    {
        if (!$this->boardTopics->contains($boardTopic)) {
            $this->boardTopics[] = $boardTopic;
            $boardTopic->setBoardCategory($this);
        }

        return $this;
    }

    public function removeBoardTopic(BoardTopic $boardTopic): self
    {
        if ($this->boardTopics->removeElement($boardTopic)) {
            // set the owning side to null (unless already changed)
            if ($boardTopic->getBoardCategory() === $this) {
                $boardTopic->setBoardCategory(null);
            }
        }

        return $this;
    }
}
