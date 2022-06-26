<?php

namespace App\Entity;

use App\Repository\LanguagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LanguagesRepository::class)
 */
class Languages
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $Lang;

    /**
     * @ORM\ManyToMany(targetEntity=Countries::class, mappedBy="languages")
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

    public function getLang(): ?string
    {
        return $this->Lang;
    }

    public function setLang(string $Lang): self
    {
        $this->Lang = $Lang;

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
            $country->addLanguage($this);
        }

        return $this;
    }

    public function removeCountry(Countries $country): self
    {
        if ($this->countries->removeElement($country)) {
            $country->removeLanguage($this);
        }

        return $this;
    }

    /*public function __toString() {
        return $this->countries;
    } */
}
