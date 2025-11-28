<?php

namespace App\Entity;

use App\Repository\CategoryRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]

class Category
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $description = null;
    private ?string $colorHex = null;
    private \DateTimeInterface $createdAt;
    private Collection $tools;

    public function __construct()
    {
        // On initialise la collection d'outils
        $this->tools = new ArrayCollection();

        // On initialise la date de création à maintenant
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

    public function setColorHex(string $colorHex): static
    {
        $this->colorHex = $colorHex;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getTools(): Collection
    {
        return $this->tools;
    }

    // ------------------ Méthodes pour gérer la collection ------------------

    public function addTool($tool): static
    {
        if (!$this->tools->contains($tool)) {
            $this->tools->add($tool);
        }
        return $this;
    }

    public function removeTool($tool): static
    {
        $this->tools->removeElement($tool);
        return $this;
    }
}
