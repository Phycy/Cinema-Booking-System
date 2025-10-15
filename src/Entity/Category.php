<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Movies;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $discription = null;

    // ✅ One category can have many movies
    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Movies::class, cascade: ['persist', 'remove'])]
    private Collection $movies;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getName(): ?string { return $this->name; }
    public function setName(string $name): static { $this->name = $name; return $this; }

    public function getDiscription(): ?string { return $this->discription; }
    public function setDiscription(string $discription): static { $this->discription = $discription; return $this; }

    /** @return Collection<int, Movies> */
    public function getMovies(): Collection { return $this->movies; }

    public function addMovie(Movies $movie): static
    {
        if (!$this->movies->contains($movie)) {
            $this->movies->add($movie);
            $movie->setCategory($this);
        }
        return $this;
    }

    public function removeMovie(Movies $movie): static
    {
        if ($this->movies->removeElement($movie)) {
            if ($movie->getCategory() === $this) {
                $movie->setCategory(null);
            }
        }
        return $this;
    }
}
