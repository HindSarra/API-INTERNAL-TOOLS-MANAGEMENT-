<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Metadata\ApiFilter;
use App\Repository\ToolRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ToolRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['tool:read']]),
        new GetCollection(normalizationContext: ['groups' => ['tool:read']]),
        new Post(denormalizationContext: ['groups' => ['tool:write']]),
        new Put(denormalizationContext: ['groups' => ['tool:write']]),
    ]
)]
#[
    ApiFilter(SearchFilter::class, properties: [
        'ownerDepartment' => 'partial',
        'status' => 'exact',
        'category' => 'partial'
    ]),
    ApiFilter(RangeFilter::class, properties: ['monthlyCost'])
]
class Tool
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['tool:read'])]
    private ?int $id = null;

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

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Groups(['tool:read', 'tool:write'])]
    private ?string $category = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Assert\PositiveOrZero]
    #[Groups(['tool:read', 'tool:write'])]
    private ?float $monthlyCost = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Groups(['tool:read', 'tool:write'])]
    private ?string $ownerDepartment = null;

    #[ORM\Column(length: 50)]
    #[Assert\Choice(choices: ['active', 'deprecated', 'draft'])]
    #[Groups(['tool:read', 'tool:write'])]
    private ?string $status = 'active';

    #[ORM\Column(length: 255)]
    #[Assert\Url]
    #[Groups(['tool:read', 'tool:write'])]
    private ?string $websiteUrl = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    #[Groups(['tool:read'])]
    private ?int $activeUsersCount = 0;

    #[ORM\Column]
    #[Groups(['tool:read'])]
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

}
