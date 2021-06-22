<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoardTopicRepository;
use Doctrine\ORM\Mapping as ORM;

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
}
