<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\PersonRepository")
 */
class Slide
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="first_name", type="string", length=50)
     */
    protected $firstName;

    /**
     * @ORM\Column(name="surname", type="string", length=50)
     */
    protected $surname;

    /**
     * @ORM\Column(name="fiscal_code", type="string", length=16)
     */
    protected $fiscalCode;

    /**
     * @ORM\Column(name="birthday", type="date")
     */
    protected $birthday;

    /**
     * @ORM\Column(name="address", type="string", length=50)
     */
    private $address;

    /**
     * @ORM\Column(name="street_number", type="string", length=10)
     */
    protected $streetNumber;

    /**
     * @ORM\Column(name="zip_code", type="string", length=10)
     */
    protected $zipCode;

    /**
     * @ORM\Column(name="state", type="string", length=50)
     */
    protected $state;






    /**
     * @ORM\Column(name="date_creation", type="date")
     */
    protected $date_creation;

    /**
     * @ORM\Column(name="notes", type="string")
     */
    protected $notes;


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
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * @param string $notes
     */
    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
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