<?php

namespace App\Entity;

use App\Repository\ShowtimeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShowtimeRepository::class)]
class Showtime
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Movies::class, inversedBy: 'showtimes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Movies $movie = null;

    #[ORM\Column(length: 50)]
    private ?string $hallNumber = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $dateTime = null;

    #[ORM\Column]
    private ?int $totalSeats = null;

    #[ORM\Column]
    private ?int $availableSeats = null;

    #[ORM\Column(type: Types::FLOAT)]
    private ?float $ticketPrice = null;

    #[ORM\OneToMany(mappedBy: 'showtime', targetEntity: BookingSit::class, cascade: ['persist', 'remove'])]
    private Collection $bookingSits;

    public function __construct()
    {
        $this->bookingSits = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getMovie(): ?Movies { return $this->movie; }
    public function setMovie(?Movies $movie): static { $this->movie = $movie; return $this; }
    public function getHallNumber(): ?string { return $this->hallNumber; }
    public function setHallNumber(string $hallNumber): static { $this->hallNumber = $hallNumber; return $this; }
    public function getDateTime(): ?\DateTimeImmutable { return $this->dateTime; }
    public function setDateTime(\DateTimeImmutable $dateTime): static { $this->dateTime = $dateTime; return $this; }
    public function getTotalSeats(): ?int { return $this->totalSeats; }
    public function setTotalSeats(int $totalSeats): static { $this->totalSeats = $totalSeats; return $this; }
    public function getAvailableSeats(): ?int { return $this->availableSeats; }
    public function setAvailableSeats(int $availableSeats): static { $this->availableSeats = $availableSeats; return $this; }
    public function getTicketPrice(): ?float { return $this->ticketPrice; }
    public function setTicketPrice(float $ticketPrice): static { $this->ticketPrice = $ticketPrice; return $this; }

    /** @return Collection<int, BookingSit> */
    public function getBookingSits(): Collection { return $this->bookingSits; }

    public function addBookingSit(BookingSit $bookingSit): static
    {
        if (!$this->bookingSits->contains($bookingSit)) {
            $this->bookingSits->add($bookingSit);
            $bookingSit->setShowtime($this);
        }
        return $this;
    }

    public function removeBookingSit(BookingSit $bookingSit): static
    {
        if ($this->bookingSits->removeElement($bookingSit)) {
            if ($bookingSit->getShowtime() === $this) {
                $bookingSit->setShowtime(null);
            }
        }
        return $this;
    }
}
