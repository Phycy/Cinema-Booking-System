<?php

namespace App\Entity;

use App\Repository\BookingSitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingSitRepository::class)]
class BookingSit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Showtime::class, inversedBy: 'bookingSits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Showtime $showtime = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'bookingSits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 10)]
    private ?string $seatNumber = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null; // available / booked

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int { return $this->id; }
    public function getShowtime(): ?Showtime { return $this->showtime; }
    public function setShowtime(?Showtime $showtime): static { $this->showtime = $showtime; return $this; }
    public function getUser(): ?User { return $this->user; }
    public function setUser(?User $user): static { $this->user = $user; return $this; }
    public function getSeatNumber(): ?string { return $this->seatNumber; }
    public function setSeatNumber(string $seatNumber): static { $this->seatNumber = $seatNumber; return $this; }
    public function getStatus(): ?string { return $this->status; }
    public function setStatus(string $status): static { $this->status = $status; return $this; }
    public function getCreatedAt(): ?\DateTimeImmutable { return $this->createdAt; }
    public function setCreatedAt(\DateTimeImmutable $createdAt): static { $this->createdAt = $createdAt; return $this; }
}
