<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(length: 50)]
    private ?string $energy = null;

    #[ORM\Column]
    private ?int $nbDoor = null;

    #[ORM\Column]
    private ?bool $is_shared = null;

    #[ORM\Column]
    private ?bool $is_kaput = null;

    #[ORM\Column(length: 100)]
    private ?string $immatriculation = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    private ?Company $company = null;

    #[ORM\Column(nullable: true)]
    private ?int $autonomy = null;

    #[ORM\OneToMany(mappedBy: 'vehicle', targetEntity: Reservation::class, cascade: ['persist', 'remove'])]
    private Collection $reservations;

    #[ORM\Column(length: 100)]
    private ?string $type = null;

    #[ORM\Column(length: 50)]
    private ?string $gearbox = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $poster = null;

    #[ORM\Column]
    private ?bool $isAvailable = null;

    #[ORM\Column(nullable: true)]
    private ?int $kilometers = null;

    #[ORM\Column]
    private ?bool $isSharedNow = null;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getEnergy(): ?string
    {
        return $this->energy;
    }

    public function setEnergy(string $energy): self
    {
        $this->energy = $energy;

        return $this;
    }

    public function getNbDoor(): ?int
    {
        return $this->nbDoor;
    }

    public function setNbDoor(int $nbDoor): self
    {
        $this->nbDoor = $nbDoor;

        return $this;
    }

    public function isIsShared(): ?bool
    {
        return $this->is_shared;
    }

    public function setIsShared(bool $is_shared): self
    {
        $this->is_shared = $is_shared;

        return $this;
    }

    public function isIsKaput(): ?bool
    {
        return $this->is_kaput;
    }

    public function setIsKaput(bool $is_kaput): self
    {
        $this->is_kaput = $is_kaput;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getAutonomy(): ?int
    {
        return $this->autonomy;
    }

    public function setAutonomy(int $autonomy): self
    {
        $this->autonomy = $autonomy;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setVehicle($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getVehicle() === $this) {
                $reservation->setVehicle(null);
            }
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getGearbox(): ?string
    {
        return $this->gearbox;
    }

    public function setGearbox(string $gearbox): self
    {
        $this->gearbox = $gearbox;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(?string $poster)
    {
        $this->poster = $poster;
        
        return $this;
    }

    public function isIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getKilometers(): ?int
    {
        return $this->kilometers;
    }

    public function setKilometers(?int $kilometers): self
    {
        $this->kilometers = $kilometers;

        return $this;
    }

    public function isIsSharedNow(): ?bool
    {
        return $this->isSharedNow;
    }

    public function setIsSharedNow(bool $isSharedNow): self
    {
        $this->isSharedNow = $isSharedNow;

        return $this;
    }
}
