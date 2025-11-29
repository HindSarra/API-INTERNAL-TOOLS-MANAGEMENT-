<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\ToolRepository;

#[ORM\Entity(repositoryClass: ToolRepository::class)]
class Tool
{
    // -------------------------------
    // PRIMARY KEY
    // -------------------------------
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['tool:read'])]
    private ?int $id = null;


    // -------------------------------
    // BASIC FIELDS
    // -------------------------------

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['tool:read', 'tool:write'])]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['tool:read', 'tool:write'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['tool:read', 'tool:write'])]
    private ?string $vendor = null;

    #[ORM\Column(length: 255)]
    #[Assert\Url]
    #[Groups(['tool:read', 'tool:write'])]
    private ?string $websiteUrl = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Assert\PositiveOrZero]
    #[Groups(['tool:read', 'tool:write'])]
    private ?float $monthlyCost = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    #[Groups(['tool:read'])]
    private int $activeUsersCount = 0;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Groups(['tool:read', 'tool:write'])]
    private ?string $ownerDepartment = null;

    #[ORM\Column(length: 50)]
    #[Assert\Choice(['active', 'deprecated', 'trial'])]
    #[Groups(['tool:read', 'tool:write'])]
    private string $status = 'active';


    // -------------------------------
    // RELATIONS
    // -------------------------------

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['tool:read', 'tool:write'])]
    private ?Category $category = null;

    #[ORM\OneToMany(targetEntity: UserToolAccess::class, mappedBy: 'tool')]
    private Collection $accesses;

    #[ORM\OneToMany(targetEntity: AccessRequest::class, mappedBy: 'tool')]
    private Collection $requests;

    #[ORM\OneToMany(targetEntity: UsageLog::class, mappedBy: 'tool')]
    private Collection $usageLogs;

    #[ORM\OneToMany(targetEntity: CostTracking::class, mappedBy: 'tool')]
    private Collection $costTrackings;


    // -------------------------------
    // TIMESTAMPS
    // -------------------------------

    #[ORM\Column]
    #[Groups(['tool:read'])]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    #[Groups(['tool:read'])]
    private ?\DateTimeImmutable $updatedAt = null;


    // -------------------------------
    // CONSTRUCTOR
    // -------------------------------
    public function __construct()
    {
        $this->accesses = new ArrayCollection();
        $this->requests = new ArrayCollection();
        $this->usageLogs = new ArrayCollection();
        $this->costTrackings = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }


    // -------------------------------
    // GETTERS & SETTERS
    // (Pas obligatoires si tu utilises Symfony 7 + autowiring)
    // -------------------------------

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

    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(?string $d): self
    {
        $this->description = $d;
        return $this;
    }

    public function getVendor(): ?string
    {
        return $this->vendor;
    }
    public function setVendor(string $v): self
    {
        $this->vendor = $v;
        return $this;
    }

    public function getWebsiteUrl(): ?string
    {
        return $this->websiteUrl;
    }
    public function setWebsiteUrl(string $url): self
    {
        $this->websiteUrl = $url;
        return $this;
    }

    public function getMonthlyCost(): ?float
    {
        return $this->monthlyCost;
    }
    public function setMonthlyCost(float $c): self
    {
        $this->monthlyCost = $c;
        return $this;
    }

    public function getActiveUsersCount(): int
    {
        return $this->activeUsersCount;
    }
    public function setActiveUsersCount(int $n): self
    {
        $this->activeUsersCount = $n;
        return $this;
    }

    public function getOwnerDepartment(): ?string
    {
        return $this->ownerDepartment;
    }
    public function setOwnerDepartment(string $d): self
    {
        $this->ownerDepartment = $d;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
    public function setStatus(string $s): self
    {
        $this->status = $s;
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }
    public function setCategory(?Category $c): self
    {
        $this->category = $c;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new \DateTimeImmutable();
        return $this;
    }
}
