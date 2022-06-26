<?php

namespace App\Entity;

use App\Repository\ContinentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContinentsRepository::class)
 */
class Continents
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $Name;

    /**
     * @ORM\OneToMany(targetEntity=Countries::class, mappedBy="continent", orphanRemoval=true)
     */
    private $countries;

    public function __construct()
    {
        $this->countries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection<int, Countries>
     */
    public function getCountries(): Collection
    {
        return $this->countries;
    }

    public function addCountry(Countries $country): self
    {
        if (!$this->countries->contains($country)) {
            $this->countries[] = $country;
            $country->setContinent($this);
        }

        return $this;
    }

    public function removeCountry(Countries $country): self
    {
        if ($this->countries->removeElement($country)) {
            // set the owning side to null (unless already changed)
            if ($country->getContinent() === $this) {
                $country->setContinent(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->Name;
    }
}
