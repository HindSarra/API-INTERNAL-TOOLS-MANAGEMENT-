<?php
namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: "string", length: 7, nullable: true)]
    private ?string $colorHex = null;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $createdAt;

    #[ORM\OneToMany(mappedBy: "category", targetEntity: Tool::class, cascade: ["persist", "remove"])]
    private Collection $tools;

    public function __construct()
    {
        $this->tools = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    // ------------------ Getters et Setters ------------------

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getColorHex(): ?string
    {
        return $this->colorHex;
    }

    public function setColorHex(?string $colorHex): static
    {
        $this->colorHex = $colorHex;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getTools(): Collection
    {
        return $this->tools;
    }

    public function addTool($tool): static
    {
        if (!$this->tools->contains($tool)) {
            $this->tools->add($tool);
            $tool->setCategory($this); // Relie l’outil à cette catégorie
        }
        return $this;
    }

    public function removeTool($tool): static
    {
        if ($this->tools->removeElement($tool)) {
            $tool->setCategory(null);
        }
        return $this;
    }
}
