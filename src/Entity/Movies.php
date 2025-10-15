<?php

namespace App\Entity;

use App\Repository\MoviesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Category;

#[ORM\Entity(repositoryClass: MoviesRepository::class)]
class Movies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    // ✅ Replace genre string with relationship to Category
    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'movies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $time = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\Column(length: 6)]
    private ?string $duration = null;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: Showtime::class, cascade: ['persist', 'remove'])]
    private Collection $showtimes;

    public function __construct()
    {
        $this->showtimes = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $title): static { $this->title = $title; return $this; }

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

    // 🎬 Relationship with Category
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;
        return $this;
    }
}
