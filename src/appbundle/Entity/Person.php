<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\PersonRepository")
 */
class Person
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
     * @ORM\Column(name="country", type="string", length=50)
     */
    protected $country;

    /**
     * @ORM\Column(name="telephone_number", type="string", length=50)
     */
    protected $telephoneNumber;

    /**
     * @ORM\Column(name="cellular_number", type="string", length=50)
     */
    protected $cellularNumber;

    /**
     * @ORM\Column(name="email", type="string", length=50)
     */
    protected $email;

    /**
     * @ORM\Column(name="notes", type="string")
     */
    protected $notes;

    /**
     * @ORM\Column(name="date_creation", type="date")
     */
    protected $dateCreation;

    /**
     * @ORM\Column(name="date_edit", type="date")
     */
    protected $dateEdit;


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

    /**
     * @return string
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param string $notes
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }
}