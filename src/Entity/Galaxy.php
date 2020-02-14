<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GalaxyRepository")
 */
class Galaxy
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *  @ORM\Column(type="string")
     */
    private $name;

    /**
     *  @ORM\Column(type="string")
     */
    private $age;

    /**
     *  @ORM\Column(type="integer")
     */
    private $size;

    /**
     *  @ORM\Column(type="string")
     */
    private $constellation;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string")
     */
    private $brochureFilename;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Star", mappedBy="galaxy", cascade={"remove"})
     */
    private $stars;

    public function __construct()
    {
        $this->stars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of stars
     */
    public function getstars()
    {
        return $this->stars;
    }

    /**
     * Get the value of age
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set the value of age
     *
     * @return  self
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get the value of size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set the value of size
     *
     * @return  self
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get the value of constellation
     */
    public function getConstellation()
    {
        return $this->constellation;
    }

    /**
     * Set the value of constellation
     *
     * @return  self
     */
    public function setConstellation($constellation)
    {
        $this->constellation = $constellation;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of brochureFilename
     */
    public function getBrochureFilename()
    {
        return $this->brochureFilename;
    }

    /**
     * Set the value of brochureFilename
     *
     * @return  self
     */
    public function setBrochureFilename($brochureFilename)
    {
        $this->brochureFilename = $brochureFilename;

        return $this;
    }
}
