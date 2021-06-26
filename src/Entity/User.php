<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("read")
     * @ApiProperty(identifier=false)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups("read")     
     * @ApiProperty(identifier=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     * @Groups("read")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups("write")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=BoardPost::class, mappedBy="author")
     */
    private $boardPosts;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("read")
     */
    private $api;

    /**
     * @ORM\OneToMany(targetEntity=BoardTopic::class, mappedBy="author")
     */
    private $boardTopics;

    /**
     * @ORM\OneToMany(targetEntity=BoardCategory::class, mappedBy="author")
     */
    private $boardCategories;

    /**
     * @ORM\OneToMany(targetEntity=ChatMessage::class, mappedBy="author")
     */
    private $chatMessagesAuthor;

    /**
     * @ORM\OneToMany(targetEntity=ChatMessage::class, mappedBy="recipient")
     */
    private $chatMessagesRecipient;

    public function __construct()
    {
        $this->boardPosts = new ArrayCollection();
        $this->boardTopics = new ArrayCollection();
        $this->boardCategories = new ArrayCollection();
        $this->chatMessagesAuthor = new ArrayCollection();
        $this->chatMessagesRecipient = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function addRole(string $role): self
    {
        $this->roles[] = $role;
        $this->roles = array_unique($this->roles);
        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $boardPost->setAuthor($this);
        }

        return $this;
    }

    public function removeBoardPost(BoardPost $boardPost): self
    {
        if ($this->boardPosts->removeElement($boardPost)) {
            // set the owning side to null (unless already changed)
            if ($boardPost->getAuthor() === $this) {
                $boardPost->setAuthor(null);
            }
        }

        return $this;
    }

    public function getApi(): ?string
    {
        return $this->api;
    }

    public function setApi(?string $api): self
    {
        $this->api = $api;

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
            $boardTopic->setAuthor($this);
        }

        return $this;
    }

    public function removeBoardTopic(BoardTopic $boardTopic): self
    {
        if ($this->boardTopics->removeElement($boardTopic)) {
            // set the owning side to null (unless already changed)
            if ($boardTopic->getAuthor() === $this) {
                $boardTopic->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BoardCategory[]
     */
    public function getBoardCategories(): Collection
    {
        return $this->boardCategories;
    }

    public function addBoardCategory(BoardCategory $boardCategory): self
    {
        if (!$this->boardCategories->contains($boardCategory)) {
            $this->boardCategories[] = $boardCategory;
            $boardCategory->setAuthor($this);
        }

        return $this;
    }

    public function removeBoardCategory(BoardCategory $boardCategory): self
    {
        if ($this->boardCategories->removeElement($boardCategory)) {
            // set the owning side to null (unless already changed)
            if ($boardCategory->getAuthor() === $this) {
                $boardCategory->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ChatMessage[]
     */
    public function getChatMessagesAuthor(): Collection
    {
        return $this->chatMessagesAuthor;
    }

    public function addChatMessageAuthor(ChatMessage $chatMessage): self
    {
        if (!$this->chatMessagesAuthor->contains($chatMessage)) {
            $this->chatMessagesAuthor[] = $chatMessage;
            $chatMessage->setAuthor($this);
        }

        return $this;
    }

    public function removeChatMessageAuthor(ChatMessage $chatMessage): self
    {
        if ($this->chatMessagesAuthor->removeElement($chatMessage)) {
            // set the owning side to null (unless already changed)
            if ($chatMessage->getAuthor() === $this) {
                $chatMessage->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ChatMessage[]
     */
    public function getChatMessagesRecipient(): Collection
    {
        return $this->chatMessagesRecipient;
    }

    public function addChatMessagesRecipient(ChatMessage $chatMessagesRecipient): self
    {
        if (!$this->chatMessagesRecipient->contains($chatMessagesRecipient)) {
            $this->chatMessagesRecipient[] = $chatMessagesRecipient;
            $chatMessagesRecipient->setRecipient($this);
        }

        return $this;
    }

    public function removeChatMessagesRecipient(ChatMessage $chatMessagesRecipient): self
    {
        if ($this->chatMessagesRecipient->removeElement($chatMessagesRecipient)) {
            // set the owning side to null (unless already changed)
            if ($chatMessagesRecipient->getRecipient() === $this) {
                $chatMessagesRecipient->setRecipient(null);
            }
        }

        return $this;
    }
}
