<?php

namespace App\Entity;

use App\Repository\MoviesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoviesRepository::class)]
class Movies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 100)]
    private ?string $genre = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $time = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\Column(length: 6)]
    private ?string $duration = null;

    // Bidirectional relation to Showtime
    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: Showtime::class, cascade: ['persist', 'remove'])]
    private Collection $showtimes;

    public function __construct()
    {
        $this->showtimes = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $title): static { $this->title = $title; return $this; }
    public function getGenre(): ?string { return $this->genre; }
    public function setGenre(string $genre): static { $this->genre = $genre; return $this; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(string $description): static { $this->description = $description; return $this; }
    public function getTime(): ?\DateTime { return $this->time; }
    public function setTime(?\DateTime $time): static { $this->time = $time; return $this; }
    public function getDate(): ?\DateTime { return $this->date; }
    public function setDate(?\DateTime $date): static { $this->date = $date; return $this; }
    public function getDuration(): ?string { return $this->duration; }
    public function setDuration(string $duration): static { $this->duration = $duration; return $this; }

    /** @return Collection<int, Showtime> */
    public function getShowtimes(): Collection { return $this->showtimes; }

    public function addShowtime(Showtime $showtime): static
    {
        if (!$this->showtimes->contains($showtime)) {
            $this->showtimes->add($showtime);
            $showtime->setMovie($this);
        }
        return $this;
    }

    public function removeShowtime(Showtime $showtime): static
    {
        if ($this->showtimes->removeElement($showtime)) {
            if ($showtime->getMovie() === $this) {
                $showtime->setMovie(null);
            }
        }
        return $this;
    }
}
