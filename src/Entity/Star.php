<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StarRepository")
 */
class Star
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @ORM\OrderBy({"title" = "DESC"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     *  
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $masse;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Galaxy", inversedBy="stars")
     *  @ORM\OrderBy({"title" = "ASC"})
     */
    private $galaxy;

    /**
     * @ORM\Column(type="string")
     */
    private $brochureFilename;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getname(): ?string
    {
        return $this->name;
    }

    public function setname(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get the value of galaxy
     */
    public function getGalaxy()
    {
        return $this->galaxy;
    }

    /**
     * Set the value of galaxy
     *
     * @return  self
     */
    public function setgalaxy($galaxy)
    {
        $this->galaxy = $galaxy;

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

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

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
     * Get the value of masse
     */ 
    public function getMasse()
    {
        return $this->masse;
    }

    /**
     * Set the value of masse
     *
     * @return  self
     */ 
    public function setMasse($masse)
    {
        $this->masse = $masse;

        return $this;
    }
}
