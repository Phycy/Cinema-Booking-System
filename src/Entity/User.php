<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: BookingSit::class, cascade: ['persist', 'remove'])]
    private Collection $bookingSits;

    public function __construct()
    {
        $this->bookingSits = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): static { $this->email = $email; return $this; }
    public function getUserIdentifier(): string { return (string) $this->email; }
    public function getRoles(): array { return array_unique(array_merge($this->roles, ['ROLE_USER','ROLE_ADMIN'])); }
    public function setRoles(array $roles): static { $this->roles = $roles; return $this; }
    public function getPassword(): ?string { return $this->password; }
    public function setPassword(string $password): static { $this->password = $password; return $this; }
    
  /*  public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);
        return $data;
    }*/

    public function __serialize(): array
    {
    return [
        'id' => $this->id,
        'email' => $this->email,
        'roles' => $this->roles,
        'password' => $this->password, // store the hashed password directly
    ];
    }

    #[\Deprecated]
    public function eraseCredentials(): void {}

    /** @return Collection<int, BookingSit> */
    public function getBookingSits(): Collection { return $this->bookingSits; }

    public function addBookingSit(BookingSit $bookingSit): static
    {
        if (!$this->bookingSits->contains($bookingSit)) {
            $this->bookingSits->add($bookingSit);
            $bookingSit->setUser($this);
        }
        return $this;
    }

    public function removeBookingSit(BookingSit $bookingSit): static
    {
        if ($this->bookingSits->removeElement($bookingSit)) {
            if ($bookingSit->getUser() === $this) {
                $bookingSit->setUser(null);
            }
        }
        return $this;
    }
}
