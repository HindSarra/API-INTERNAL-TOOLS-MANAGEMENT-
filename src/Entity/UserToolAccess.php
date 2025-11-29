<?php

namespace App\Entity;

use App\Repository\UserToolAccessRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\AccessStatusEnum;
use App\Entity\Tool;


#[ORM\Entity(repositoryClass: UserToolAccessRepository::class)]
class UserToolAccess
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

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $grantedAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $grantedBy = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $revokedAt = null;

    #[ORM\ManyToOne]
    private ?User $revokedBy = null;

    #[ORM\Column(enumType: AccessStatusEnum::class)]
    private AccessStatusEnum $status = AccessStatusEnum::APPROVED;

    public function getId(): ?int
    {
        return $this->id;
    }
}
