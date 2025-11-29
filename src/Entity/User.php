<?php

namespace App\Entity;

use App\Enum\DepartmentEnum;
use App\Enum\RoleEnum;
use App\Enum\UserStatusEnum;
use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $name;

    #[ORM\Column(length: 150, unique: true)]
    private string $email;

    #[ORM\Column(enumType: DepartmentEnum::class)]
    private DepartmentEnum $department;

    #[ORM\Column(enumType: RoleEnum::class)]
    private RoleEnum $role = RoleEnum::Employee;

    #[ORM\Column(enumType: UserStatusEnum::class)]
    private UserStatusEnum $status = UserStatusEnum::Active;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $hireDate = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserToolAccess::class)]
    private Collection $toolAccesses;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: AccessRequest::class)]
    private Collection $accessRequests;

    public function __construct()
    {
        $this->toolAccesses = new ArrayCollection();
        $this->accessRequests = new ArrayCollection();
    }
}
