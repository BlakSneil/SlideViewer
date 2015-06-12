<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="slide")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\SlideRepository")
 */
class Slide
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(name="date_creation", type="date")
     */
    private $date_creation;

    /**
     * @ORM\ManyToOne(targetEntity="Vendor")
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="id")
     */
    private $vendor;

    /**
     * @ORM\Column(name="width", type="integer")
     */
    private $width;

    /**
     * @ORM\Column(name="height", type="integer")
     */
    private $height;

    /**
     * @ORM\Column(name="tile_dim", type="integer")
     */
    private $tileDim;

    /**
     * @ORM\Column(name="notes", type="string")
     */
    private $notes;


    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return datetime
     */
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * @param datetime $date_creation
     */
    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }

    /**
     * @return \AppBundle\Entity\Vendor
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param \AppBundle\Entity\Vendor $vendor
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return mixed
     */
    public function getTileDim()
    {
        return $this->tileDim;
    }

    /**
     * @param mixed $tileDim
     */
    public function setTileDim($tileDim)
    {
        $this->tileDim = $tileDim;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }
}