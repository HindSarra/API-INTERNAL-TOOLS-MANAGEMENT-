<?php

namespace App\Entity;

use App\Repository\UsageLogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsageLogRepository::class)]
class UsageLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tool $tool = null;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $sessionDate;

    #[ORM\Column]
    private int $usageMinutes = 0;

    #[ORM\Column]
    private int $actionsCount = 0;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt;
}
